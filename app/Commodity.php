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

    public $banners;
    public $details;

    public function setBannersAttribute($banners)
    {
        $this->banners = $banners;
    }

    public function setdetailsAttribute($details)
    {
        $this->details = $details;
    }

    public function activities()
    {
        return $this->belongsToMany(Activity::class, 'activity_commodity', 'activity_id', 'commodity_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'id', 'category_id');
    }

    public function bannerImages()
    {
        return $this->morphMany(Image::class, 'image');
    }

    public function detailsImages()
    {
        return $this->morphMany(Image::class, 'image');
    }
}
