<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Banner
 *
 * @property int         $id
 * @property string|null $target 点击后跳转内容
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int         $level  按等级排序的
 * @property string      $color  背景颜色
 * @property-read Image  $image
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Banner newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Banner newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Banner query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Banner whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Banner whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Banner whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Banner whereLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Banner whereTarget($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Banner whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Banner extends Model
{
    protected $fillable = [
        'target',
    ];

    public function image()
    {
        return $this->morphOne(Image::class, 'image');
    }
}
