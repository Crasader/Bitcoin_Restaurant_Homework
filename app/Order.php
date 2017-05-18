<?php

namespace App;

class Order extends BaseModel
{
    const STATUS_NEW = 0;
    const STATUS_UNCONFIRMED_WRONG = 1;
    const STATUS_UNCONFIRMED_OK = 2;
    const STATUS_CONFIRMED_WRONG = 3;
    const STATUS_CONFIRMED_OK = 4;
    const STATUS_HISTORY = 5;

    protected $guarded = [];

    protected $statuses = [
        self::STATUS_NEW => ['name' => 'New', 'class' => 'btn btn-primary'],
        self::STATUS_UNCONFIRMED_WRONG => ['name' => 'Not fully paid', 'class' => 'btn btn-warning'],
        self::STATUS_UNCONFIRMED_OK => ['name' => 'Paid', 'class' => 'btn btn-success'],
        self::STATUS_CONFIRMED_WRONG => ['name' => 'Not fully paid', 'class' => 'btn btn-warning'],
        self::STATUS_CONFIRMED_OK => ['name' => 'Paid', 'class' => 'btn btn-success'],
        self::STATUS_HISTORY => ['name' => 'Archived', 'class' => 'btn btn-success'],
    ];

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
