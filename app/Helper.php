<?php
/**
 * Created by PhpStorm.
 * User: r00d1k
 * Date: 16.05.2017
 * Time: 3:41
 */

namespace App;

use Illuminate\Support\Facades\Facade;
use Mockery\Exception;

class Helper
{
    public static function getBTCToUAH()
    {
        $FstxApi = \App::make('FstxApi');
        $res = $FstxApi->query_public('rate');
        if (isset($res['code']) && $res['code'] == 0) {
            $btc_usd = round(floor($res['data']['bid']));
        } else {
            throw new Exception('Can not get BTC rate from FstxApi');
        }

        $pbank_rates = json_decode(file_get_contents(\Config::get('pbapi.url')));
        if (!is_null($pbank_rates)) {
            foreach ($pbank_rates as $pbank_rate) {
                if ($pbank_rate->ccy == 'USD' && $pbank_rate->base_ccy == 'UAH') {
                    $usd_uah = $pbank_rate->buy;
                }
            }
        } else {
            throw new Exception('Can not get USD rate from api.privatbank.ua');
        }

        $btc_usd_fee = \Config::get('exchange.btc_usd_fee');
        $usd_uah_fee = \Config::get('exchange.usd_uah_fee');
        $client_btc_usd = $btc_usd * (1 - $btc_usd_fee);
        $client_usd_uah = $usd_uah * (1 - $usd_uah_fee);
        $client_btc_uah = $client_btc_usd * $client_usd_uah;
        return $client_btc_uah;
    }

    public static function getBTCAddress() {
        $FstxApi = \App::make('FstxApi');
        $res = $FstxApi->query_private('address/get/new', ['is_autoexchange' => 1]);
        if (
            !isset($res['code'])
            || $res['code'] != 0
            || !isset($res['data']['address'])
            || $res['data']['address'] == ''
        )
        {
            return false;
        }
        return $res['data']['address'];
    }
}