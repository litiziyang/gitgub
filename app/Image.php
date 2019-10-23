<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Image
 *
 * @property int         $id
 * @property string      $url 链接
 * @property string      $image_type
 * @property int         $image_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $tag 额外标记
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Image newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Image newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Image query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Image whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Image whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Image whereImageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Image whereImageType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Image whereTag($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Image whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Image whereUrl($value)
 * @mixin Eloquent
 */
class Image extends Model
{
    protected $fillable = [
        'image_type',
        'image_id',
        'url',
    ];
}
