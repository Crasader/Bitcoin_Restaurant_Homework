@extends('layouts.app')

@section('content')
<div class="container">
    <form class="form-horizontal">
        <fieldset disabled>
            <div class="form-group">
                {!! Form::label('order_number', 'Order Number', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::text('order_number', $order->order_number, ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('amount_uah', 'Total Amount', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    <div class="input-group">
                        <div class="input-group-addon">₴</div>
                        {!! Form::text('amount_uah', $order->amount, ['class' => 'form-control']) !!}
                        <div class="input-group-addon">UAH</div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('amount_btc', 'Total Amount', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-btc"></i></div>
                        {!! Form::text('amount_btc', $btc_amount, ['class' => 'form-control']) !!}
                        <div class="input-group-addon">BTC</div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('address', 'Address', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::text('address', $order->address, ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="row">
                <div class="col-xs-4 col-md-4"></div>
                <div class="col-xs-3 col-md-3">
                    <div class="thumbnail">
                        <img src="{{$QRCode}}" alt="QR Code" width="100%">
                    </div>
                </div>
                <div class="col-xs-4 col-md-4"></div>
            </div>
        </fieldset>
    </form>
</div>
@endsection