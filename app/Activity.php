<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Activity
 *
 * @property int                         $id
 * @property string                      $name   活动名字
 * @property float                       $quota  满多少金额
 * @property float                       $offer  减多少
 * @property string                      $type   类型
 * @property string                      $expire 到期时间
 * @property Carbon|null                 $created_at
 * @property Carbon|null                 $updated_at
 * @property-read Collection|Commodity[] $commodities
 * @property-read int|null               $commodities_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activity newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activity newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activity query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activity whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activity whereExpire($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activity whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activity whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activity whereOffer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activity whereQuota($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activity whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activity whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Activity extends Model
{
    protected $fillable = [
        'name',
        'quota',
        'offer',
        'type',
        'expire',
    ];

    public function commodities()
    {
        return $this->belongsToMany(Commodity::class, 'activity_commodity', 'activity_id', 'commodity_id');
    }
}
