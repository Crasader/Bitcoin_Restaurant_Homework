@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Exchange rate</div>
                    <div class="panel-body">
                        1 BTC = {{$btc_in_uah}} UAH
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection