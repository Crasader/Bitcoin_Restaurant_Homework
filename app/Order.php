<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    const STATUS_NEW = 0;
    const STATUS_UNCONFIRMED_LOWER = 1;
    const STATUS_UNCONFIRMED_EXACT = 2;
    const STATUS_CONFIRMED_LOWER = 3;
    const STATUS_CONFIRMED_EXACT = 4;

    protected $guarded = [];

    protected $statuses = [
        self::STATUS_NEW => ['name' => 'New', 'class' => 'btn btn-primary'],
        self::STATUS_UNCONFIRMED_LOWER => ['name' => 'Not fully paid', 'class' => 'btn btn-warning'],
        self::STATUS_UNCONFIRMED_EXACT => ['name' => 'Paid', 'class' => 'btn btn-success'],
        self::STATUS_CONFIRMED_LOWER => ['name' => 'Not fully paid', 'class' => 'btn btn-warning'],
        self::STATUS_CONFIRMED_EXACT => ['name' => 'Paid', 'class' => 'btn btn-success'],
    ];

    public function __call($method, $parameters)
    {
        $callback = function($parameters) {
            if (isset($parameters['amount_uah'])) {
                $parameters['amount_uah'] = round($parameters['amount_uah'],8) * \Config::get('exchange.factor');
            }
            if (isset($parameters['amount_btc'])) {
                $parameters['amount_btc'] = round($parameters['amount_btc'], 8) * \Config::get('exchange.factor');
            }
            return $parameters;
        };
        $parameters = array_map($callback, $parameters);
        return parent::__call($method, $parameters);
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

    public function getStatusName() {
        return $this->statuses[$this->status]['name'];
    }

    public function getStatusClass() {
        return $this->statuses[$this->status]['class'];
    }

    /**
     * Scope a query to only include popular users.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOpened($query)
    {
        return $query->where('status', '<',5);
    }
}
