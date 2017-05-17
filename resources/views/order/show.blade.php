@extends('layouts.app')

@section('content')
<div class="container">
    <table class="table table-bordered">
        <thead>
            <tr>
                <td>Order Number</td><td>{{$order->order_number}}</td>
            </tr><tr>
                <td>Amount UAH</td><td>{{$order->amount_uah}}</td>
            </tr><tr>
                <td>Amount BTC</td><td>{{$order->amount_btc}}</td>
            </tr><tr>
                <td>Address</td><td>{{$order->address}}</td>
            </tr><tr>
                <td>Description</td><td>{{$order->description}}</td>
            </tr><tr>
                <td>Paid UAH</td><td>{{$order->getPaidAmount()}}</td>
            </tr><tr>
                <td>Unpaid UAH</td><td>{{$order->getUnpaidAmount()}}</td>
            </tr><tr>
                <td>Created</td><td>{{$order->created_at}}</td>
            </tr><tr>
                <td>Updated</td><td>{{$order->updated_at}}</td>
            </tr>
        </thead>
        <tbody>
            <tr>

            </tr>
        </tbody>
    </table>
    @if($order->transactions->count())
        <table class="table table-bordered">
            <thead>
            <tr>
                <td>Date</td>
                <td>Amount BTC</td>
                <td>Status</td>
                <td>Transaction</td>
            </tr>
            </thead>
            <tbody>
                @foreach($order->transactions as $transaction)
                <tr>
                    <td>{{$transaction->created_at}}</td>
                    <td class="text-right">{{$transaction->amount_btc}}</td>
                    <td class="text-center">{{$transaction->confirmed ? '+' : '-'}}</td>
                    <td>{{$transaction->transaction}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif

</div>
@endsection