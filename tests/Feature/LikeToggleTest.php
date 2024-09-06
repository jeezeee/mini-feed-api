<?php

namespace Tests\Feature;

use App\Events\PostLiked;
use App\Mail\PostLikedNotification;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class LikeToggleTest extends TestCase
{
    /**
     * Test that the PostLiked event is dispatched and listener is triggered.
     *
     * @return void
     */
    public function test_post_liked_event_and_listener_are_triggered()
    {
        Mail::fake();

        $postOwner = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $postOwner->id]);

        $liker = User::factory()->create();

        PostLiked::dispatch($post, $liker);

        Mail::assertSent(PostLikedNotification::class, function ($mail) use ($postOwner) {
            return $mail->hasTo($postOwner->email);
        });
    }
}
