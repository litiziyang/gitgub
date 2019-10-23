<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Commodity
 *
 * @property int                             $id
 * @property string                          $title         标题
 * @property int                             $category_id   分类ID
 * @property float                           $price         价格
 * @property float                           $reward        奖励金
 * @property int                             $count_sales   销量
 * @property int                             $count_comment 评论数量
 * @property int                             $count_view    浏览数量
 * @property int                             $count_stack   库存数量
 * @property Carbon|null                     $created_at
 * @property Carbon|null                     $updated_at
 * @property-read Collection|Activity[]      $activities
 * @property-read int|null                   $activities_count
 * @property-read Collection|Image[]         $bannerImages
 * @property-read int|null                   $banner_images_count
 * @property-read Category                   $category
 * @property-read Collection|Image[]         $detailImages
 * @property-read int|null                   $detail_images_count
 * @property-write mixed                     $banners
 * @property-write mixed                     $details
 * @property-read Collection|Specification[] $specifications
 * @property-read int|null                   $specifications_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Commodity newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Commodity newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Commodity query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Commodity whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Commodity whereCountComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Commodity whereCountSales($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Commodity whereCountStack($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Commodity whereCountView($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Commodity whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Commodity whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Commodity wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Commodity whereReward($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Commodity whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Commodity whereUpdatedAt($value)
 * @mixin Eloquent
 */
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
