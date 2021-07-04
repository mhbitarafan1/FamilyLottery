<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\lot;
use App\LotteryStock;
use App\User;
use App\Lottery;
use App\Installment;
use RealRashid\SweetAlert\Facades\Alert;
use App\Order;
use App\Payment;
use App\LotteryManager;

class InstallmentController extends Controller
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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        $installment = Installment::where('id',$id)->first();
        $stock = LotteryStock::find($installment->lottery_stock_id);
        $lottery = Lottery::where('id',$stock->lottery_id)->first();

        $countOfPaidInstallmentsForPreviusLots = count($stock->installments->where('id','<',$installment->id)->where('paid',true));
        $numberOfPreviusLot = Lot::find($installment->lot_id)->number-1 ;
        if ($countOfPaidInstallmentsForPreviusLots < $numberOfPreviusLot ) {
             Alert::warning('تایید پرداخت ناموفق', 'این سهام  هنوز از قرعه های قبلی بدهکار است و تا اونها رو پرداخت نکند نمی تواند قسط این قرعه را پرداخت کند.');
             return back();
        }
          
            $installmentAmount = (Lot::find($installment->lot_id)->amount)/
            $lottery->count_of_lots;

            $stockUserId = $stock->owner;
            if ($stockUserId == NULL) {
                $stockUserId = User::find(LotteryManager::find($lottery->lottery_manager_id)->user_id)->id;
            }






            //confirmation pay amount (increment cash)
            $order1 = Order::create([
                'user_id' => $stockUserId,
                'amount'=>$installmentAmount,
                'return_order'=>false,
                'type_of_order'=>'addCash',
            ]);
            $order1->installments()->attach($installment->id);
            $userCashAfterPay1 = User::find($stockUserId)->cash + $order1->amount;
            
            
            $payment1 = Payment::create([
                'order_id'=>$order1->id,
                'type'=>'مدیر قرعه کشی',
                'tracking_code'=>rand(10000000,99999999),
                'status'=>'successful',
                'user_cash_after_pay'=> $userCashAfterPay1,
            ]);

            
            




            $order1->update([
                'status' => 'paid',
            ]);


            if ($order1->status == 'paid') {
                $updateUserCash = User::find($stockUserId)->update([
                    'cash' => $userCashAfterPay1,
                ]);
            }





            //confirmation pay installment(decriment cash)
            $order2 = Order::create([
                'user_id' => $stockUserId,
                'amount'=>$installmentAmount,
                'return_order'=>true,
                'type_of_order'=>'installment',
            ]);

            $order2->installments()->attach($installment->id);
            $userCashAfterPay2 = User::find($stockUserId)->cash - $order2->amount;
            
            $payment2 = Payment::create([
                'order_id'=>$order2->id,
                'type'=>'مدیر قرعه کشی',
                'tracking_code'=>rand(10000000,99999999),
                'status'=>'successful',
                'user_cash_after_pay'=> $userCashAfterPay2,
            ]);

            $order2->update([
                'status' => 'paid',
            ]);

            if ($order2->status == 'paid') {
                $installment->update([
                    'paid'=>true,
                    'confirmed_by'=> 'مدیر قرعه کشی',
                ]);
                
                $totalPayment = $stock->total_payment;
                $totalPayment += $installmentAmount;
                $stock->update([
                    'total_payment' => $totalPayment,
                ]);

                $updateUserCash2 = User::find($stockUserId)->update([
                    'cash' => $userCashAfterPay2,
                ]);

            }
















   








        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function manageInstallments($lotId)
    {
        $lot = Lot::where('id',$lotId)->first();
        $stocks = LotteryStock::where('lottery_id',$lot->lottery_id)->get();
        $users = User::all();
        $lottery = Lottery::where('id',$lot->lottery_id)->first();
        return view('users.installments.manage',compact('lot','stocks','users','lottery'));
    }
}
