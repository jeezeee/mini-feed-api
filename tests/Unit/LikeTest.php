<?php

namespace Tests\Unit;

use App\Models\Post;
use App\Models\User;
use App\Models\Like;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LikeTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that a like belongs to a user.
     *
     * @return void
     */
    public function test_like_belongs_to_user()
    {
        $user = User::factory()->create();

        $like = Like::factory()->create(['user_id' => $user->id]);

        $this->assertInstanceOf(User::class, $like->user);
        $this->assertEquals($user->id, $like->user->id);
    }

    /**
     * Test that a like belongs to a post.
     *
     * @return void
     */
    public function test_like_belongs_to_post()
    {
        $post = Post::factory()->create();

        $like = Like::factory()->create(['post_id' => $post->id]);

        $this->assertInstanceOf(Post::class, $like->post);
        $this->assertEquals($post->id, $like->post->id);
    }
}
