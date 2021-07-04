<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\StockRequest;
use App\lottery;
use App\User;
use App\Http\Requests\StoreStockRequest;
use App\LotteryMember;
use App\LotteryManager;
use App\LotteryStock;
use RealRashid\SweetAlert\Facades\Alert;

class StockRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id,$type)
    {
        $lottery= lottery::find($id);
        
        return view('users.stockRequests.create',compact('lottery','type'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreStockRequest $request)
    {   
        $lotteryId = $request->lotteryId;
        $lotteryMemberId = LotteryMember::where('user_id',auth()->user()->id)->first()->id;
        if(count(stockRequest::where('lottery_id',$lotteryId)->where('lottery_member_id',$lotteryMemberId)->where('accepted_by_lotterymanager',false)->get())>0){
            return "شما قبلا یک درخواست داده ایدد. بعد از مشخص شدن نتیجه ی درخواست قبلی دوباره میتوانید درخواست جدید دهید  ... ";
        }

           
            if ($request->type=='sell') {
                $lotteryStocks = LotteryStock::where('lottery_id',$lotteryId)->get();
                $selfStocks = $lotteryStocks->where('owner', auth()->user()->id)->all();

                if($request->count_of_lots > count($selfStocks)){
                return "شما این تعداد سهام ندارید که بتوانید واگذار کنید ...";
                }
            }
            
            



        $stockRequest = StockRequest::create([
            'lottery_id'=> $lotteryId,
            'lottery_member_id'=>  $lotteryMemberId ,
            'count_of_stock'=>$request->count_of_lots,
            'type_of_request'=>$request->type,
        ]);
        return redirect(route('lotteries.show',$lotteryId));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    { 
        $lottery_id = StockRequest::find($id)->lottery_id;
        StockRequest::where('id',$id)->delete();
         return redirect(route('lotteries.show',$lottery_id));
    }

    public function answerStockRequest(Request $request, $id)
    {
        $lottery_id = StockRequest::find($id)->lottery_id;  
        if (isset($request->yes)) {
            $stockRequest = StockRequest::where('id',$id);
            $lotteryId = $stockRequest->first()->lottery_id;
            $lotteryStocks = LotteryStock::where('lottery_id',$lotteryId)->get();
            $countOfStockRequest = $stockRequest->first()->count_of_stock;
            $stockRequestUserid = LotteryMember::find($stockRequest->first()->lottery_member_id)->user_id;

            if ($stockRequest->first()->type_of_request=='buy') {

                 $freeStocks = $lotteryStocks->where('owner',NULL)->all();
                 








                 $onTimeLot = Lottery::find($lotteryId)->lots->where('stock_winner',NULL)->first();

                 $freeAndGoodDeallerStoksId=[];

                 foreach ($freeStocks as $freeStock) {
                    $paidInstallments = $freeStock->installments->where('lot_id','<=',$onTimeLot->id)->where('paid',true);
                    
                     if(count($paidInstallments) >= ($onTimeLot->number-1))
                    {
                     $freeAndGoodDeallerStoksId[] =  $freeStock->id;
                    }
                 }


                 



                $countOfStockRequest = $stockRequest->first()->count_of_stock;
                if ($countOfStockRequest <= count($freeAndGoodDeallerStoksId)) {
                    for ($i=1; $i <= $countOfStockRequest ; $i++) {

                        $lotteryStocks->where('id',$freeAndGoodDeallerStoksId[$i-1])->first()->update([
                             'owner'=>$stockRequestUserid,
                        ]);
                    }

                    $stockRequest->update(['accepted_by_lotterymanager'=>true,]);

                }else{
                    return "سهام به مقدار کافی موجود نمی باشد. دقت کنید که سهامی قابل واگذاری است که تحت مالکیت هیچ شخصی نباشد و هیچ قسطی بدهکار نباشد.";
                }
            }elseif($stockRequest->first()->type_of_request=='sell'){

                
                $selfStocks = $lotteryStocks->where('owner', $stockRequestUserid)->all();
                if ($countOfStockRequest <= count($selfStocks) ) {
                    for ($i=1; $i <= $countOfStockRequest ; $i++) { 
                        $lotteryStocks->where('owner',$stockRequestUserid)->first()->update([
                             'owner'=> NULL,
                        ]);
                    }
                    $stockRequest->update(['accepted_by_lotterymanager'=>true,]);
                }else{
                    return "کاربر مورد نظر به تعداد کافی سهام ندارد";
                }

            }






        }elseif (isset($request->no)) {
            StockRequest::where('id',$id)->delete();
        }
        
        return redirect(route('lotteries.show',$lottery_id));
    }


    public function changeStockOwner(Request $request,$id)
    {

        $stock = LotteryStock::where('id',$id)->first();
        $lottery = Lottery::find($stock->lottery_id);
        $LotteryManagerUserId = LotteryManager::find((Lottery::find($stock->lottery_id)->lottery_manager_id))->user_id; 
        
        if ($stock->owner == $LotteryManagerUserId && count($lottery->lotteryStocks->where('owner',$LotteryManagerUserId))<2 && count($lottery->lots->where('stock_winner','<>',null))==0) {
            
            return "چون نوع قرعه کشی شما قرعه ی اول برای برگزارکننده هست نمیتوانید همه ی سهام های خودتان را  تا قبل از شروع قرعه کشی بفروشید";
        }

        $stock->update([
            'owner'=>NULL,
        ]);

        $lotteryId = $stock->first()->lottery_id;
        return redirect(route('lotteries.show',$lotteryId));

    }
    public function addStockforLotteryManager($id)
    {
        $stock = LotteryStock::find($id);
        if ($stock->owner == NULL) {
            $stock->update([
                'owner' => User::find(LotteryManager::find(lottery::find($stock->lottery_id)->lottery_manager_id)->user_id)->id,
            ]);
            Alert::success('موفقیت آمیز', 'سهام مورد نظر متعلق به شما شد');
            return back();    
        }else{
            Alert::warning('ناموفق', 'این سهام متعلقق به کس دیگری می باشد');
            return back();
        }

    }

}
