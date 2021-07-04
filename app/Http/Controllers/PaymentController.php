<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Payment;
use App\Order;
use App\Lot;
use App\Checkout;
use App\Lottery;
use App\LotteryStock;


class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = auth()->user()->orders;
        $lots = Lot::all();
        $lotteries = Lottery::all();
        $stocks = LotteryStock::all();
        return view('users.payments.index',compact('orders','lots','lotteries','stocks'));
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
        //
    }


    public function checkoutRequest()
    {
        $paymentRequests = Checkout::where('user_id',auth()->user()->id)->get();
        return view('users.payments.checkout',compact('paymentRequests'));
    }

    public function checkout(Request $request)
    {
        $amount = str_replace(',', '', $request->amount);
        Checkout::create([
            'user_id' => auth()->user()->id,
            'amount' => $amount,
        ]);
        return back();
    }

}
