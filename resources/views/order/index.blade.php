@extends('layouts.app')
@section('content')
    <div class="container">
        <table class="table table-hover">
            <thead>
                <tr>
                    <td>Status</td>
                    <td>#</td>
                    <td>Amount UAH</td>
                    <td>Paid</td>
                    <td></td>
                    <td></td>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr>
                    <td class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                        <button type="button" class="{{$order->getStatusClass()}}">{{$order->getStatusName()}}</button>
                    </td>
                    <td>{{$order->id}}</td>
                    <td class="col-xs-2 col-sm-2 col-md-2 col-lg-2">{{$order->amount_uah}}</td>
                    <td class="col-xs-1 col-sm-1 col-md-1 col-lg-1">Paid</td>
                    <td class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                        <button type="button" class="btn btn-primary">
                            <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
                        </button>
                    </td>
                    <td class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                    </td>
                    <td class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                        @if(!in_array($order->status, [\App\Order::STATUS_CONFIRMED_EXACT, \App\Order::STATUS_UNCONFIRMED_EXACT]))
                        <button type="button" class="{{$order->getStatusClass()}}">
                            <span class="glyphicon glyphicon-repeat" aria-hidden="true"></span>
                            Repeat
                        </button>
                        @endif
                    </td>
                    <td class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                        {!! Form::open(['route' => ['orders.update', $order->id], 'method' => 'PATCH']) !!}
                        <button type="submit" class="btn btn-danger">
                            <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                            Close order
                        </button>
                        {!! Form::close() !!}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection