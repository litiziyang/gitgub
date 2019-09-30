<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
