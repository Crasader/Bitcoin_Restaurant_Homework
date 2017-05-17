@extends('layouts.app')
@section('content')
    <div class="container">
        <table class="table table-hover">
            <thead>
            <tr>
                <td class="col-xs-2 col-sm-2 col-md-2 col-lg-2">Date</td>
                <td class="col-xs-1 col-sm-1 col-md-1 col-lg-1">#</td>
                <td class="col-xs-2 col-sm-2 col-md-2 col-lg-2">Amount UAH</td>
                <td class="col-xs-2 col-sm-2 col-md-2 col-lg-2">Paid UAH</td>
                <td class="col-xs-2 col-sm-2 col-md-2 col-lg-2">Unpide UAH</td>
                <td class="col-xs-1 col-sm-1 col-md-1 col-lg-1">Status</td>
                <td class="col-xs-1 col-sm-1 col-md-1 col-lg-1">Details</td>
            </tr>
            </thead>
            <tbody>
            @foreach($orders as $order)
                <tr>
                    <td class="col-xs-2 col-sm-2 col-md-2 col-lg-2">{!! $order->updated_at !!}</td>
                    <td class="col-xs-1 col-sm-1 col-md-1 col-lg-1">{!! $order->id !!}</td>
                    <td class="text-right col-xs-2 col-sm-2 col-md-2 col-lg-2">{!! $order->amount_uah !!}</td>
                    <td class="text-right col-xs-2 col-sm-2 col-md-2 col-lg-2">0.00</td>
                    <td class="text-right col-xs-2 col-sm-2 col-md-2 col-lg-2">0.00</td>
                    <td class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                        <button type="button" class="{{$order->getStatusClass()}}">{{$order->getStatusName()}}</button>
                    </td>
                    <td class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                        <a href="{{ route('orders.show', ['order' => $order->id]) }}">
                            <button type="button" class="btn btn-primary">
                                <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
                            </button>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{$orders->links()}}
    </div>
@endsection