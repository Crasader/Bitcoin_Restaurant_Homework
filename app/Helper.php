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
    public static function getUAHToBTC($uah = 1)
    {
        $rate_btc_uah = static::getBTCToUAH();
        return $uah / $rate_btc_uah;
    }

    public static function getBTCToUAH($btc = 1)
    {
        $rates = static::getRates();
        $btc_usd_fee = \Config::get('exchange.btc_usd_fee');
        $usd_uah_fee = \Config::get('exchange.usd_uah_fee');
        $client_btc_usd = $rates['btc_usd'] * (1 - $btc_usd_fee);
        $client_usd_uah = $rates['usd_uah'] * (1 - $usd_uah_fee);
        $result = $client_btc_usd * $client_usd_uah;
        return $result * $btc;
    }

    public static function getBTCAddress()
    {
        $FstxApi = \App::make('FstxApi');
        $res = $FstxApi->query_private('address/get/new', ['is_autoexchange' => 1]);
        if (
            !isset($res['code'])
            || $res['code'] != 0
            || !isset($res['data']['address'])
            || $res['data']['address'] == ''
        ) {
            return false;
        }
        return $res['data']['address'];
    }

    public static function getQRCode($address, $amount, $orderNumber, $description)
    {
        $protocol = \Config::get('qr.protocol');
        $label = \Config::get('qr.label');
        $message = \Config::get('qr.message_prefix').$orderNumber. ' '.$description;
        $QRSrting = "$protocol:$address?amount=$amount&label=$label&message=$message";
        $QRSrting = urlencode(trim($QRSrting));
        return 'data:image/png;base64,' . \DNS2D::getBarcodePNG($QRSrting, "QRCODE");
    }

    private static function getRates() {
        static $rates = [];

        if (!isset($rates['btc_usd'])) {
            $FstxApi = \App::make('FstxApi');
            $res = $FstxApi->query_public('rate');
            if (isset($res['code']) && $res['code'] == 0) {
                $rates['btc_usd'] = $res['data']['bid'] / \Config::get('exchange.factor');
            } else {
                return false;
            }
        }

        if (!isset($rates['usd_uah'])) {
            $pbank_rates = json_decode(file_get_contents(\Config::get('pbapi.url')));
            if (!is_null($pbank_rates)) {
                foreach ($pbank_rates as $pbank_rate) {
                    if ($pbank_rate->ccy == 'USD' && $pbank_rate->base_ccy == 'UAH') {
                        $rates['usd_uah'] = $pbank_rate->buy;
                    }
                }
            } else {
                return false;
            }
        }

        return $rates;
    }
}