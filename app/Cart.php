<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Cart
 *
 * @property int            $id
 * @property int            $commodity_id 商品ID
 * @property int            $count        数量
 * @property int            $user_id      用户ID
 * @property string         $state        状态
 * @property Carbon|null    $created_at
 * @property Carbon|null    $updated_at
 * @property string         $title        冗余字段 - 标题
 * @property string         $price        冗余字段 - 价格
 * @property-read Commodity $commodity
 * @property-read User      $user
 * @property-read Image     $image
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Cart newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Cart newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Cart query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Cart whereCommodityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Cart whereCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Cart whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Cart whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Cart wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Cart whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Cart whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Cart whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Cart whereUserId($value)
 * @mixin Eloquent
 */
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

    public function image()
    {
        return $this->morphOne(Image::class, 'image');
    }
}
