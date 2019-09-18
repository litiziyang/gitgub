<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    protected $fillable = [
        'name',
        'offer',
        'order_good_id',
    ];

    public function orderGood(){
        return $this->belongsTo(OrderGood::class,'id','order_good_id');
    }
}
