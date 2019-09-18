<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Commodity extends Model
{
    protected $fillable = [
        'title',
        'category_id',
        'price',
        'reward',
        'count_sales',
        'count_comment',
        'count_view',
        'count_stock',
    ];

    public function activities()
    {
        return $this->belongsToMany(Activity::class, 'activity_commodity', 'activity_id', 'commodity_id');
    }

    public function category(){
        return $this->belongsTo(Category::class,'id','category_id');
    }
}
