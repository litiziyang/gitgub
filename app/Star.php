<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Star extends Model
{
    protected $fillable = [
        'user_id',
        'commodity_id',
    ];

    public function commodity(){
        return $this->hasOne(Commodity::class,'id','commodity_id');
    }
}
