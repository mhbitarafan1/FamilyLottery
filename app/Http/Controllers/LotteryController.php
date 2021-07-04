<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Verta;
use Carbon\Carbon;
use App\Http\Requests\StoreLottery;
use App\Lottery;
use App\Lot;
use App\LotteryStock;
use App\LotteryManager;
use App\LotteryMember;
use App\Installment;
use App\User;
use RealRashid\SweetAlert\Facades\Alert;

class LotteryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {  
        
       $myLotteries = Lottery::whereHas('lotterystocks', function($q){$q->where('owner', auth()->user()->id);})->orWhere('lottery_manager_id',LotteryManager::where('user_id',auth()->user()->id)->first()->id)->latest()->paginate(4, ['*'], 'myLotteries');
        $otherLotteries = Lottery::latest()->paginate(6, ['*'], 'otherLotteries');
        $users = User::all();
        $lotteryManagers = LotteryManager::all();
        $lotteryStocks = LotteryStock::all();
        

        return view('users.home',compact('otherLotteries','users','lotteryManagers','lotteryStocks','myLotteries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        return view('users.lotteries.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLottery $request)
    {

        $jalaliTime = Verta::createJalali($request->year,$request->month,$request->day,$request->hour,0,0);
        $miladiTime = Carbon::instance($jalaliTime->DateTime());

        if ($jalaliTime->lt(verta::tomorrow())) {
            return redirect()->back()->withErrors(['زمان شروع قرعه کشی  اشتباه است. حداقل یک روز  بعد را می توانید انتخاب کنید']);
        }
        $amount = str_replace(',', '', $request->amount);
        if (!is_numeric($amount)) {
            return back();
        }

        
        $lottery = Lottery::create([
            'lottery_manager_id' => auth()->user()->lotterymanager->id,
            'time_of_first_lot' => $miladiTime,
            'slug' => $request->name,
            "name" => $request->name,
            "amount" => $amount,
            "cycle" => $request->cycle,
            "count_of_lots" =>$request->count_of_lots, 
            "type_of_income" => $request->type_of_income,
            "type_of_choose_winner" => $request->type_of_choose_winner,
            "short_description" => $request->short_description,
        ]);

            
            $timeHoldingOfLotJalali = $jalaliTime;
        for ($i=1; $i <= $request->count_of_lots  ; $i++) {
            
            $lotteryStocksData[] = [
                'lottery_id' => $lottery->id,
                'number' => $i,
            ];




            switch ($request->cycle) {
                case 'هفتگی':
                    if ($i!=1) {
                        $timeHoldingOfLotJalali=$timeHoldingOfLotJalali->addWeek();
                     } 
                    break;
                case 'دو هفته یکبار':
                    if ($i!=1) {
                        $timeHoldingOfLotJalali=$timeHoldingOfLotJalali->addWeeks(2);
                     } 
                    break;
                case 'ماهیانه':
                    if ($i!=1) {
                        $timeHoldingOfLotJalali=$timeHoldingOfLotJalali->addMonth();
                     } 
                    break;
                case 'دو ماه یکبار':
                    if ($i!=1) {
                        $timeHoldingOfLotJalali=$timeHoldingOfLotJalali->addMonths(2);
                     } 
                    break;
                default:
                    if ($i!=1) {
                        $timeHoldingOfLotJalali=$timeHoldingOfLotJalali->addMonth();
                     } 
                    break;
            }


            $lotsData[] = [
                'lottery_id' => $lottery->id,
                'number' => $i,
                'time_holding' =>Carbon::instance($timeHoldingOfLotJalali->DateTime()),
                'amount' =>$amount,
            ];
            

                

        }

        
           

        $lotteryStock = LotteryStock::insert($lotteryStocksData);

        $lot = Lot::insert($lotsData);





        $lots = Lot::where('lottery_id',$lottery->id)->get();
        $stocks = LotteryStock::where('lottery_id',$lottery->id)->get();

        foreach ($lots as $lot) {
            foreach ($stocks as $stock) {

                $installmentsData[] = [
                'lot_id' => $lot->id,
                'lottery_stock_id' => $stock->id,
                ];


            }
        }


        $installment = Installment::insert($installmentsData);

        







        if ($lottery->type_of_income == 'firstlot') {
            $firstStock = $stocks->first();
            $firstStock->update([
                             'owner'=>auth()->user()->id,                            
                        ]);


        }

















        return redirect(route('lotteries.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {   
        $lottery = Lottery::find($id);
        $newCountOfView = $lottery->count_of_view+1;
        $lottery->update(['count_of_view'=>$newCountOfView]);
        $lots = Lot::where('lottery_id',$id)->get();
        $stocks = LotteryStock::where('lottery_id',$id)->get();
        $users = User::all();
        $amIManager = $lottery->lottery_manager_id == auth()->user()->lotterymanager->id;
        $amIMember = $stocks->where('lottery_id',$lottery->id)->where('owner',auth()->user()->id)->all();
        
        $stockRequests = $lottery->stockrequests()->where('accepted_by_lotterymanager',0)->get();

        $lotteryMembers = LotteryMember::all();
        $memberId = $lotteryMembers->where('user_id',auth()->user()->id)->first()->id;
         $myStockRequest = $stockRequests->where('lottery_member_id',$memberId)->first();
         $lastLot=$lots->where('stock_winner','!=',NULL)->last();
         $nextLot=$lots->where('stock_winner','=',NULL)->first();
        $lotteryManagerUserId = LotteryManager::find($lottery->lottery_manager_id)->user_id;
        $stocksDontWinned=$lottery->lotterystocks->where('winned',0);
            
        return view('users.lotteries.show',compact('lottery','lots','users','stocks','amIManager','amIMember','stockRequests','lotteryMembers','myStockRequest','lastLot','nextLot','lotteryManagerUserId','stocksDontWinned'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        return "ok";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   
        $countOfPastLot=count(lottery::find($id)->lots->where('stock_winner','<>',NULL)); 
        if ($countOfPastLot <= 1) {
            Lottery::where('id',$id)->first()->delete();
            Alert::success('موفقیت آمیز', 'قرعه کشی موردنظر با موفقیت حذف شد');
            return redirect(route('home'));
        }else{
           
           Alert::warning('حذف ناموفق', 'بعد از قرعه کشی  اول دیگر امکان حذف قرعه کشی نمی باشد');
           return back(); 
        }


    }



    public function chooseWinnerByManager(Request $request)
    {
        
        if(isset($request->stock_winner)){
            $winnerStockId = $request->stock_winner;
            $stockWinner = lotteryStock::find($winnerStockId);
            $lot = Lot::find($request->lot_id);

            $lot->update([
                'stock_winner' => $winnerStockId,
            ]);

            $stockWinner->update([
                'winned' => true,
            ]);
            Alert::success('موفقیت آمیز', 'سهام مورد نظر با موفقیت به عنوان برنده انتخاب شد');
            return back();
        }

         Alert::warning('برنده را انتخاب نمایید', 'سهامی  جهت معرفی وجود ندارد');
        return back();

    }



    public function like($lotteryId)
    {

        $lottery = lottery::find($lotteryId);
        $likedCount = $lottery->count_of_like + 1;
        $lottery->update([
            'count_of_like'=>$likedCount,
        ]); 
        return back();
    }

}
