<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\OrderGood
 *
 * @property int            $id
 * @property int            $commodity_id 商品ID
 * @property float          $pay          当时价格
 * @property int            $order_id     订单ID
 * @property int            $count        数量
 * @property Carbon|null    $created_at
 * @property Carbon|null    $updated_at
 * @property-read Commodity $commodity
 * @property-read Order     $order
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderGood newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderGood newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderGood query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderGood whereCommodityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderGood whereCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderGood whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderGood whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderGood whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderGood wherePay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderGood whereUpdatedAt($value)
 * @mixin Eloquent
 */
class OrderGood extends Model
{
    protected $fillable = [
        'commodity_id',
        'pay',
        'order_id',
        'count',
        'reward',
    ];

    public function commodity()
    {
        return $this->hasOne(Commodity::class, 'id', 'commodity_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'id', 'order_id');
    }
}
