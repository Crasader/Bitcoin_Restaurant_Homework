@extends('layouts.app')

@section('content')

    <div class="container">

        <h1>Create New Order</h1>
        <hr/>

        {!! Form::open(['route' => 'orders.store', 'class' => 'form-horizontal', 'files' => true]) !!}

        <div class="form-group {{ $errors->has('order_number') ? 'has-error' : ''}}">
            {!! Form::label('order_number', 'Order Number', ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-6">
                {!! Form::text('order_number', $order_number, ['class' => 'form-control']) !!}
                {!! $errors->first('order_number', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        <div class="form-group {{ $errors->has('amount') ? 'has-error' : ''}}">
            {!! Form::label('amount', 'Total Amount', ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-6">
                <div class="input-group">
                    <div class="input-group-addon">₴</div>
                    {!! Form::text('amount', null, ['class' => 'form-control']) !!}
                </div>
                {!! $errors->first('amount', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        <div class="form-group {{ $errors->has('description') ? 'has-error' : ''}}">
            {!! Form::label('description', 'Description', ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-6">
                {!! Form::textarea('description', null, ['class' => 'form-control', 'rows' => 3]) !!}
                {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
            </div>
        </div>


        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-3">
                {!! Form::submit('Create', ['class' => 'btn btn-primary form-control']) !!}
            </div>
        </div>
        {!! Form::close() !!}

        @if ($errors->any())
            <ul class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif

    </div>
@endsection