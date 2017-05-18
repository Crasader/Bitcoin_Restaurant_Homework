<?php

namespace App\Http\Controllers;

use App\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function webhook(Request $request)
    {
        $endpoint = $request->url();
        $inputs = json_decode(file_get_contents('php://input'), true);
        if (isset($inputs['type']) && $inputs['type'] == 'verify') {
            return hash('sha512', $endpoint);
        }
        if (isset($inputs['type']) && $inputs['type'] == 'btc_deposit') {
            $inputs['amount_btc'] = $inputs['amount'];
            unset($inputs['amount']);
            unset($inputs['tx_expired']);
            unset($inputs['type']);
            $transaction = Transaction::create($inputs);
            return $transaction->order;
        }
        return 1;
    }
}
