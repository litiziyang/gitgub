<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'content',
        'star',
        'user_id',
        'comment_type',
        'comment_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'user_id');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'comment');
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'image');
    }
}
