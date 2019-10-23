<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Address
 *
 * @property int         $id
 * @property int         $user_id     用户ID
 * @property string      $name        收获姓名
 * @property int         $phone       收获电话
 * @property string      $address     收获地址
 * @property string      $description 详细地址 门牌号
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $longitude   经度
 * @property string|null $latitude    纬度
 * @property-read User   $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Address newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Address newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Address query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Address whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Address whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Address whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Address whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Address whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Address whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Address whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Address wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Address whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Address whereUserId($value)
 * @mixin Eloquent
 */
class Address extends Model
{

    protected $fillable = [
        'name',
        'phone',
        'address',
        'description',
        'longitude',
        'latitude',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'user_id');
    }
}
