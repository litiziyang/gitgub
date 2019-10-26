<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Order
 *
 * @property int              $id
 * @property int              $number         订单编号编号
 * @property int|null         $transaction_id 交易编号
 * @property int              $user_id        用户ID
 * @property string           $state          订单状态
 * @property float            $reward         奖励金额
 * @property float            $price          价格
 * @property string           $address        地址
 * @property string           $name           名字
 * @property string           $phone          电话
 * @property string           $remarks        备注
 * @property string           $description    详细地址
 * @property string           $longitude      经度
 * @property string           $latitude       纬度
 * @property Carbon|null      $created_at
 * @property Carbon|null      $updated_at
 * @property-read Transaction $transaction
 * @property-read User        $user
 * @property-read Coupon      $coupon
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereUserId($value)
 * @mixin Eloquent
 */
class Order extends Model
{
    protected $fillable = [
        'user_id',
        'coupon_id',
        'number',
        'price',
        'name',
        'address',
        'phone',
        'description',
        'remarks',
        'longitude',
        'latitude'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class, 'id', 'transaction_id');
    }

    public function coupon()
    {
        return $this->hasOne(Coupon::class, 'coupon_id', 'id');
    }
}
