<?php

namespace App\Services;

use App\Models\Post;
use App\Models\User;

class LikeService
{
    /**
     * Toggle the like status for a post by a given user.
     *
     * @param  \App\Models\Post  $post
     * @param  \App\Models\User  $user
     * @return string
     */
    public function toggleLike(Post $post, User $user)
    {
        if ($post->likedBy()->where('user_id', $user->id)->exists()) {
            $post->likedBy()->detach($user->id);
            return 'Post unliked';
        } else {
            $post->likedBy()->attach($user->id);
            return 'Post liked';
        }
    }
}
