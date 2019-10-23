<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Specification
 *
 * @property int            $id
 * @property int            $commodity_id 商品ID
 * @property string         $name         规格名
 * @property int            $quantity     数量
 * @property Carbon|null    $created_at
 * @property Carbon|null    $updated_at
 * @property-read Commodity $commodity
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Specification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Specification newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Specification query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Specification whereCommodityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Specification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Specification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Specification whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Specification whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Specification whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Specification extends Model
{
    protected $fillable = [
        'commodity_id',
        'name',
        'quantity',
    ];

    public function commodity()
    {
        return $this->belongsTo(Commodity::class, 'commodity_id', 'id');
    }
}
