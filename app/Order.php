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
}
