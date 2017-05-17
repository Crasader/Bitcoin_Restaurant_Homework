<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    public function __construct(array $attributes = [])
    {
        $callback = $this->getApplyFactorClosure();
        $attributes = $callback($attributes);
        parent::__construct($attributes);
    }

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

    /**
     * @return \Closure
     */
    protected function getApplyFactorClosure()
    {
        $callback = function ($parameters) {
            if (isset($parameters['amount_uah'])) {
                $parameters['amount_uah'] = round($parameters['amount_uah'], 8) * \Config::get('exchange.factor');
            }
            if (isset($parameters['amount_btc'])) {
                $parameters['amount_btc'] = round($parameters['amount_btc'], 8) * \Config::get('exchange.factor');
            }
            return $parameters;
        };
        return $callback;
    }
}
