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
    if(Auth::guest()) {
        return view('welcome');
    } else {
        return view('home');
    }

});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/orders', 'HomeController@index')->name('orders');
Route::get('/rate', 'HomeController@rate')->name('x-rate');
Route::get('/add_order', 'HomeController@index')->name('add_order');
Route::get('/history', 'HomeController@index')->name('history');
