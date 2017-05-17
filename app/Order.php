<?php

namespace App;

class Order extends BaseModel
{
    const STATUS_NEW = 0;
    const STATUS_UNCONFIRMED_LOWER = 1;
    const STATUS_UNCONFIRMED_EXACT = 2;
    const STATUS_CONFIRMED_LOWER = 3;
    const STATUS_CONFIRMED_EXACT = 4;
    const STATUS_HISTORY = 5;

    protected $guarded = [];

    protected $statuses = [
        self::STATUS_NEW => ['name' => 'New', 'class' => 'btn btn-primary'],
        self::STATUS_UNCONFIRMED_LOWER => ['name' => 'Not fully paid', 'class' => 'btn btn-warning'],
        self::STATUS_UNCONFIRMED_EXACT => ['name' => 'Paid', 'class' => 'btn btn-success'],
        self::STATUS_CONFIRMED_LOWER => ['name' => 'Not fully paid', 'class' => 'btn btn-warning'],
        self::STATUS_CONFIRMED_EXACT => ['name' => 'Paid', 'class' => 'btn btn-success'],
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
