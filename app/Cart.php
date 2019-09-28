<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        'commodity_id',
        'count',
        'user_id',
        'state',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'user_id');
    }

    public function commodity()
    {
        return $this->hasOne(Commodity::class, 'id', 'commodity_id');
    }
}
