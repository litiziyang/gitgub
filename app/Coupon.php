<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Coupon
 *
 * @property int         $id
 * @property string      $name      名称
 * @property Carbon|null $expire    到期时间
 * @property int         $user_id   所属用户
 * @property int         $offer     优惠
 * @property string|null $condition 条件
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read User   $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Coupon newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Coupon newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Coupon query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Coupon whereCondition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Coupon whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Coupon whereExpire($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Coupon whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Coupon whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Coupon whereOffer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Coupon whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Coupon whereUserId($value)
 * @mixin Eloquent
 */
class Coupon extends Model
{
    protected $fillable = [
        'name',
        'expire',
        'user_id',
        'offer',
        'condition',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'user_id');
    }
}
