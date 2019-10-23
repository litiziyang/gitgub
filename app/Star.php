<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Star
 *
 * @property int            $id
 * @property int            $user_id      用户ID
 * @property int            $commodity_id 商品ID
 * @property Carbon|null    $created_at
 * @property Carbon|null    $updated_at
 * @property-read Commodity $commodity
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Star newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Star newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Star query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Star whereCommodityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Star whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Star whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Star whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Star whereUserId($value)
 * @mixin Eloquent
 */
class Star extends Model
{
    protected $fillable = [
        'user_id',
        'commodity_id',
    ];

    public function commodity()
    {
        return $this->hasOne(Commodity::class, 'id', 'commodity_id');
    }
}
