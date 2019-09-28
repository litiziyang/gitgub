<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderGood extends Model
{
    protected $fillable = [
        'commodity_id',
        'pay',
        'order_id',
        'count',
        'reward',
    ];

    public function commodity()
    {
        return $this->hasOne(Commodity::class, 'id', 'commodity_id');
    }
    public function order()
    {
        return $this->belongsTo(Order::class, 'id', 'order_id');
    }
}
