<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Discount
 *
 * @property int            $id
 * @property string         $name          优惠名字
 * @property float          $offer         优惠金额
 * @property int            $order_good_id 订单商品快照ID
 * @property Carbon|null    $created_at
 * @property Carbon|null    $updated_at
 * @property-read OrderGood $orderGood
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Discount newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Discount newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Discount query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Discount whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Discount whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Discount whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Discount whereOffer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Discount whereOrderGoodId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Discount whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Discount extends Model
{
    protected $fillable = [
        'name',
        'offer',
        'order_good_id',
    ];

    public function orderGood()
    {
        return $this->belongsTo(OrderGood::class, 'id', 'order_good_id');
    }
}
