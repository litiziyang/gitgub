<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable = [
        'target',
    ];

    public function images()
    {
        return $this->morphMany(Image::class, 'image');
    }
}
