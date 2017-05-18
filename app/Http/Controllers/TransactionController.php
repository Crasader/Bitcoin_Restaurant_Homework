<?php

namespace App\Http\Controllers;

use App\Order;
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
            $data = [
                'amount_btc' => $inputs['amount'],
                'address' => $inputs['address'],
                'transaction' => $inputs['transaction'],
                'confirmed' => $inputs['confirmed'],
            ];
            $transaction = Transaction::create($data);
            $order = $transaction->order;
            if (!in_array($order->status, [
                Order::STATUS_HISTORY_CANCELLED,
                Order::STATUS_HISTORY_WRONG,
                Order::STATUS_HISTORY_OK,
            ])) {
                if ($inputs['tx_expired']) {
                    
                } else {
                    if ($inputs['confirmed']) {
                        if ($order->isPaid()) {
                            $order->status = Order::STATUS_CONFIRMED_OK;
                        } else {
                            $order->status = Order::STATUS_CONFIRMED_WRONG;
                        }
                    } else {
                        if ($order->isPaid()) {
                            $order->status = Order::STATUS_UNCONFIRMED_OK;
                        } else {
                            $order->status = Order::STATUS_UNCONFIRMED_WRONG;
                        }
                    }
                }
                $order->save();
            }
        }
        return 1;
    }
}
