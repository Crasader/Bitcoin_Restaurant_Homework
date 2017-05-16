<?php

namespace App\Http\Controllers;

use App\FstxApi;
use Illuminate\Http\Request;
use Mockery\Exception;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function rate()
    {
        $btc_in_uah = \Helper::getBTCToUAH();
        if ($btc_in_uah) {
            $data = ['btc_in_uah' => $btc_in_uah];
            return view('rate', $data);
        } else {
            $data = ['message' => 'Can not get exchange rate. Exchange service is not working. Try again later.'];
            return view('error', $data);
        }
    }
}
