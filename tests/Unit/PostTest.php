<?php

namespace Tests\Unit;

use App\Models\Post;
use App\Models\User;
use App\Models\Like;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that a post belongs to a user.
     *
     * @return void
     */
    public function test_post_belongs_to_user()
    {
        $user = User::factory()->create();

        $post = Post::factory()->create(['user_id' => $user->id]);

        $this->assertInstanceOf(User::class, $post->user);
        $this->assertEquals($user->id, $post->user->id);
    }

    /**
     * Test that a post can have many likes.
     *
     * @return void
     */
    public function test_post_has_many_likes()
    {
        $post = Post::factory()->create();

        $likes = Like::factory()->count(3)->create(['post_id' => $post->id]);

        $this->assertCount(3, $post->likedBy);

        $this->assertInstanceOf(User::class, $post->likedBy->first());
    }
}
