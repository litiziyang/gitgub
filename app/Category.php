<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Category
 *
 * @property int                        $id
 * @property string                     $name        分类名称
 * @property int|null                   $category_id 父分类ID
 * @property Carbon|null                $created_at
 * @property Carbon|null                $updated_at
 * @property-read Collection|Category[] $child
 * @property-read int|null              $child_count
 * @property-read Image                 $image
 * @property-read Category|null         $parent
 * @method static \Illuminate\Database\Eloquent\Builder|Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category query()
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Category extends Model
{
    protected $fillable = [
        'name',
        'category_id',
    ];

    public function parent()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function child()
    {
        return $this->hasMany(Category::class, 'category_id', 'id');
    }

    public function image()
    {
        return $this->morphOne(Image::class, 'image');
    }
}
