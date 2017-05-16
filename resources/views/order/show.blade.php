@extends('layouts.app')

@section('content')
<div class="container">
    <table class="table table-bordered">
        <thead>
            <tr>
                <td>#</td>
                <td>Address</td>
                <td>Order Number</td>
                <td>Status</td>
                <td>Amount UAH</td>
                <td>Amount BTC</td>
                <td>Description</td>
                <td>Created</td>
                <td>Updated</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{$order->id}}</td>
                <td>{{$order->address}}</td>
                <td>{{$order->order_number}}</td>
                <td>{{$order->getStatusName()}}</td>
                <td class="text-right">{{$order->amount_uah}}</td>
                <td class="text-right">{{$order->amount_btc}}</td>
                <td>{{$order->description}}</td>
                <td>{{$order->created_at}}</td>
                <td>{{$order->updated_at}}</td>
            </tr>
        </tbody>
    </table>
</div>
@endsection