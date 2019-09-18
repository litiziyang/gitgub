<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    public function commodities()
    {
        return $this->belongsToMany(Commodity::class, 'activity_commodity', 'activity_id', 'commodity_id');
    }
}
