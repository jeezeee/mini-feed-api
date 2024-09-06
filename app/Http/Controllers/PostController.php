<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Models\Post;
use App\Services\PostService;

class PostController extends Controller
{
    protected PostService $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    /**
     * Retrieve paginated posts.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $posts = $this->postService->getPosts();

        return response()->json($posts);
    }

    /**
     * Store a new post.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StorePostRequest $request)
    {
        $post = $this->postService->createPost($request->all());

        return response()->json($post, 201);
    }

    /**
     * Delete a post.
     *
     * @param \App\Models\Post $post
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Post $post)
    {
        $deleted = $this->postService->deletePost($post);

        if (!$deleted) {
            return response()->json(['error' => 'You are not authorized to delete this post.'], 403);
        }

        return response()->json(['message' => 'Post deleted successfully']);
    }
}
