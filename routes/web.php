<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::post('/webhooks', function() {
    $endpoint = Request::url();
    $inputs = json_decode(file_get_contents('php://input'), true);
    if ( isset( $inputs['type'] ) && $inputs['type'] == 'verify' ) {
        return hash ('sha512', $endpoint);
    }
});
