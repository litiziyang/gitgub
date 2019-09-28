<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'number',
        'user_id',
        'state',
        'transaction_id',
        'reward',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'user_id');
    }

    public function tansaction()
    {
        return $this->hasOne(Transaction::class, 'id', 'transaction_id');
    }
}
