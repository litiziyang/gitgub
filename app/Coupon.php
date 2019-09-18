<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'name',
        'expire',
        'user_id',
        'offer',
        'condition'
    ];

    public function user(){
        return $this->belongsTo(User::class,'id','user_id');
    }
}
