<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Commodity extends Model
{
    public function activities()
    {
        return $this->belongsToMany(Activity::class, 'activity_commodity', 'activity_id', 'commodity_id');
    }
}
