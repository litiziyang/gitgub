<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Record
 *
 * @property int            $id
 * @property int            $user_id      用户ID
 * @property int            $commodity_id 商品ID
 * @property Carbon|null    $created_at
 * @property Carbon|null    $updated_at
 * @property-read Commodity $commodity
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Record newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Record newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Record query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Record whereCommodityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Record whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Record whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Record whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Record whereUserId($value)
 * @mixin Eloquent
 */
class Record extends Model
{
    protected $fillable = [
        'user_id',
        'commodity_id'
    ];

    public function commodity()
    {
        return $this->hasOne(Commodity::class, 'id', 'commodity_id');
    }
}
