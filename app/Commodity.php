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
        'count_stack',
    ];

    public $banners;
    public $details;
    // public $specificationArray;

    // public function getSpecificationAttribute()
    // {
    //     $specifications      = $this->specifications;
    //     $specification_array = [];
    //     foreach ($specifications as $specification) {
    //         $array             = [];
    //         $array['name']     = $specification->name;
    //         $array['quantity'] = $specification->quantity;
    //         array_push($specification_array, $array);
    //     }
    //     return $specification_array;
    // }

    // public function setSpecificationAttribute($specifications)
    // {
    //     $this->specificationArray = $specifications;
    // }

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
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function bannerImages()
    {
        return $this->morphMany(Image::class, 'image')->where('tag', 'banner');
    }

    public function detailImages()
    {
        return $this->morphMany(Image::class, 'image')->where('tag', 'detail');
    }

    public function specifications()
    {
        return $this->hasMany(Specification::class, 'commodity_id', 'id');
    }

    // public function countSpecification()
    // {
    //     $specifications = $this->specifications;
    //     $quantity       = 0;
    //     foreach ($specifications as $specification) {
    //         $quantity += $specification->quantity;
    //     }
    //     $this->count_stack = $quantity;
    //     $this->save();
    // }
}
