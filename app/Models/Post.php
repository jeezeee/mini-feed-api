<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasFormattedTimestamps;

class Post extends Model
{
    use HasFactory, HasFormattedTimestamps;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['user_id', 'content'];

    /**
     * Get the user that owns the post.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the likes for the post.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function likedBy()
    {
        return $this->belongsToMany(User::class, 'likes', 'post_id', 'user_id')->withTimestamps();
    }

    /**
     * Get the number of likes for the post.
     *
     * @return int
     */
    public function getLikesCountAttribute()
    {
        return $this->likedBy()->count(); // Count likes using the relationship
    }
}
