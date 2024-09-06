<?php

namespace App\Services;

use App\Http\Resources\PostResource;
use App\Http\Resources\PostResourceCollection;
use App\Models\Post;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class PostService
{
    /**
     * Retrieve paginated posts.
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getPosts()
    {
        $posts = Post::with('user', 'likedBy')->withCount('likedBy')->paginate(10);
        return new PostResourceCollection($posts);
    }

    /**
     * Create a new post.
     *
     * @param array $data
     * @return \App\Models\Post
     */
    public function createPost(array $data)
    {
        return Post::create([
            'user_id' => Auth::id(),
            'content' => $data['content'],
        ]);
    }

    /**
     * Delete a post if it belongs to the authenticated user.
     *
     * @param \App\Models\Post $post
     * @return bool
     */
    public function deletePost(Post $post)
    {
        if (Gate::denies('delete', $post)) {
            return false;
        }

        $post->delete();
        return response()->json(['message' => 'Post deleted']);
    }
}
