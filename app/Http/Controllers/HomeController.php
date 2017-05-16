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
        $data = ['error' => false];
        try {
            $data['btc_in_uah'] = \Helper::getBTCToUAH();
        } catch (\Exception $e) {
            $data['error'] = true;
        }
        return view('rate', $data);
    }
}
