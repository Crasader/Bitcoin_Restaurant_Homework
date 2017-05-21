<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    public function __get($key)
    {
        $val = parent::__get($key);
        if (in_array($key, ['amount_uah', 'amount_btc'])) {
            $val = $val / \Config::get('exchange.factor');
        }
        return $val;
    }

    public function __set($key, $value)
    {
        if (in_array($key, ['amount_uah', 'amount_btc'])) {
            $value = round($value, 8) * \Config::get('exchange.factor');
        }
        parent::__set($key, $value);
    }
}
