<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('order.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('order.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'order_number' => 'required|alpha_num',
            'amount' => 'required|numeric',
            'description' => 'max:200',
        ]);

        $inputData = $request->all();

        $address = \Helper::getBTCAddress();

        $order = Order::create([
            'address' => $address,
            'order_number' => $inputData['order_number'],
            'amount' => $inputData['amount'],
            'status' => Order::STATUS_NEW,
            'description' => $inputData['description'],
        ]);
        $btcAmount = 0.11111;
        $label = 'lebel';
        $message = 'message';
        $qrSrting = sprintf('bitcoin:%s?amount=%f&label=%s&message=%s', $address, $btcAmount, $label, $message);
        $data = [
            'order' => $order,
            'QRCode' => 'data:image/png;base64,'.\DNS2D::getBarcodePNG($qrSrting, "QRCODE"),
            'btc_amount' => $btcAmount,
        ];
        return view('order.qr', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        return view('order.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Order $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        return view('order.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Order $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
