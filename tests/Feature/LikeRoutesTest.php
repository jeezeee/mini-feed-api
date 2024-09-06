<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LikeRoutesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that an authenticated user can like a post.
     *
     * @return void
     */
    public function test_authenticated_user_can_like_post()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();

        $token = $user->createToken('API Token')->accessToken;

        $response = $this->postJson("/api/posts/{$post->id}/like", [], [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertStatus(200)
            ->assertJson(['message' => 'Post liked']);

        $this->assertDatabaseHas('likes', [
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);
    }

    /**
     * Test that an authenticated user can unlike a post.
     *
     * @return void
     */
    public function test_authenticated_user_can_unlike_post()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();

        $token = $user->createToken('API Token')->accessToken;

        $user->likes()->attach($post->id);

        $response = $this->postJson("/api/posts/{$post->id}/like", [], [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertStatus(200)
            ->assertJson(['message' => 'Post unliked']);

        $this->assertDatabaseMissing('likes', [
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);
    }

    /**
     * Test that a user cannot like a post more than once.
     *
     * @return void
     */
    public function test_user_cannot_like_post_more_than_once()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();

        $token = $user->createToken('API Token')->accessToken;

        $user->likes()->attach($post->id);

        $response = $this->postJson("/api/posts/{$post->id}/like", [], [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertStatus(200)
            ->assertJson(['message' => 'Post unliked']);
    }

    /**
     * Test that an unauthenticated user cannot like a post.
     *
     * @return void
     */
    public function test_unauthenticated_user_cannot_like_post()
    {
        $post = Post::factory()->create();

        $response = $this->postJson("/api/posts/{$post->id}/like");

        $response->assertStatus(401)
            ->assertJson(['error' => 'Unauthenticated.']);
    }
}
