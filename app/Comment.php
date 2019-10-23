<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Comment
 *
 * @property int                       $id
 * @property string                    $content 内容
 * @property string                    $star    星级
 * @property int                       $user_id 用户ID
 * @property string                    $comment_type
 * @property int                       $comment_id
 * @property Carbon|null               $created_at
 * @property Carbon|null               $updated_at
 * @property-read Collection|Comment[] $comments
 * @property-read int|null             $comments_count
 * @property-read Collection|Image[]   $images
 * @property-read int|null             $images_count
 * @property-read User                 $user
 * @method static \Illuminate\Database\Eloquent\Builder|Comment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Comment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Comment query()
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereCommentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereCommentType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereStar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereUserId($value)
 * @mixin Eloquent
 */
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
