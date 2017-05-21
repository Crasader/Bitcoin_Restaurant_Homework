<?php

namespace App;

class Order extends BaseModel
{
    const STATUS_NEW = 0;
    const STATUS_UNCONFIRMED_WRONG = 1;
    const STATUS_UNCONFIRMED_OK = 2;
    const STATUS_CONFIRMED_WRONG = 3;
    const STATUS_CONFIRMED_OK = 4;
    const STATUS_HISTORY_CANCELLED = 5;
    const STATUS_HISTORY_WRONG = 6;
    const STATUS_HISTORY_OK = 7;

    protected $guarded = [];

    protected $statuses = [
        self::STATUS_NEW => ['name' => 'New', 'class' => 'btn btn-primary'],
        self::STATUS_UNCONFIRMED_WRONG => ['name' => 'Not fully paid', 'class' => 'btn btn-warning'],
        self::STATUS_UNCONFIRMED_OK => ['name' => 'Paid', 'class' => 'btn btn-success'],
        self::STATUS_CONFIRMED_WRONG => ['name' => 'Not fully paid', 'class' => 'btn btn-warning'],
        self::STATUS_CONFIRMED_OK => ['name' => 'Paid', 'class' => 'btn btn-success'],
        self::STATUS_HISTORY_CANCELLED => ['name' => 'Archived', 'class' => 'btn btn-success'],
        self::STATUS_HISTORY_WRONG => ['name' => 'Archived', 'class' => 'btn btn-success'],
        self::STATUS_HISTORY_OK => ['name' => 'Archived', 'class' => 'btn btn-success'],
    ];

    public function __construct(array $attributes = [])
    {
        $callback = $this->getApplyFactorClosure();
        $attributes = $callback($attributes);
        parent::__construct($attributes);
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

    public function getStatusName()
    {
        return $this->statuses[$this->status]['name'];
    }

    public function getStatusClass()
    {
        return $this->statuses[$this->status]['class'];
    }

    public function getPaidAmountUAH() {
        return round(\Helper::getBTCToUAH($this->transactions->sum('amount_btc')), 2);
    }

    public function getUnpaidAmountUAH() {
        $amount = round($this->amount_uah - \Helper::getBTCToUAH($this->transactions->sum('amount_btc')), 2);
        return $amount > 0 ? $amount : 0;
    }

    public function getUnpaidAmountBTC() {
        $amount = round($this->amount_btc - $this->transactions->sum('amount_btc'), 8);
        return $amount > 0 ? $amount : 0;
    }

    public function isPaid() {
        return $this->transactions->sum('amount_btc') >= $this->amount_btc;
    }

    public function isConfirmed() {
        return !$this->transactions->where('confirmed', 0)->count();
    }

    /**
     * Scope a query to only include popular users.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOpened($query)
    {
        return $query->where('status', '<', 5);
    }

    public function scopeHistory($query)
    {
        return $query->where('status', 5);
    }

    public function transactions() {
        return $this->hasMany(Transaction::class, 'address', 'address');
    }
}
