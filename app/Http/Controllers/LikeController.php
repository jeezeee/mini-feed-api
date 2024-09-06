<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Services\LikeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    protected $likeService;

    public function __construct(LikeService $likeService)
    {
        $this->likeService = $likeService;
    }

    /**
     * Toggle the like/unlike status of a post.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $postId
     * @return \Illuminate\Http\JsonResponse
     */
    public function toggleLike(Request $request, $postId)
    {
        $post = Post::findOrFail($postId);
        $user = Auth::user();

        $message = $this->likeService->toggleLike($post, $user);

        return response()->json(['message' => $message]);
    }
}
