<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;

class PostPolicy
{
    /**
     * Determine if the given post can be deleted by the user.
     *
     * This policy checks if the user attempting to delete the post is the
     * owner of the post. Only the owner of the post is allowed to delete it.
     *
     * @param  \App\Models\User  $user  The currently authenticated user.
     * @param  \App\Models\Post  $post  The post the user wants to delete.
     * @return bool  Returns true if the user is the owner of the post, otherwise false.
     */
    public function delete(User $user, Post $post)
    {
        return $user->id === $post->user_id;
    }
}
