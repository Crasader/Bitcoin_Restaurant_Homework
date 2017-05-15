<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/webhooks', function(Request $request) {
    $endpoint = $request->url();
    $inputs = json_decode(file_get_contents('php://input'), true);
    if ( isset( $inputs['type'] ) && $inputs['type'] == 'verify' ) {
        return hash ('sha512', $endpoint);
    }
});
