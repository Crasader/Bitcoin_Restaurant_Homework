<?php

namespace App;

class Transaction extends BaseModel
{
    protected $guarded = [];

    public function order() {
        return $this->belongsTo(Order::class, 'address', 'address');
    }
}
