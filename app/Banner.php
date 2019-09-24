<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable = [
        'target',
    ];

    public function image()
    {
        return $this->morphOne(Image::class, 'image');
    }
}
