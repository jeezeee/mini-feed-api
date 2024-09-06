<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostRoutesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test viewing posts without authentication.
     *
     * @return void
     */
    public function test_can_view_posts_without_authentication()
    {
        Post::factory()->count(5)->create();

        $response = $this->getJson('/api/posts');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data',
                'current_page',
                'first_page_url',
                'last_page',
                'last_page_url',
                'next_page_url',
                'prev_page_url',
                'per_page',
                'total',
            ]);
    }

    /**
     * Test creating a post with authentication.
     *
     * @return void
     */
    public function test_can_create_post_with_authentication()
    {
        $user = User::factory()->create();

        $token = $user->createToken('API Token')->accessToken;

        $response = $this->postJson('/api/posts', [
            'content' => 'This is a new post',
        ], [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'id',
                'content',
                'user_id',
            ]);
    }
    /**
     * Test deleting a post.
     *
     * @return void
     */
    public function test_can_delete_own_post()
    {
        $user = User::factory()->create();

        $token = $user->createToken('API Token')->accessToken;

        $post = Post::factory()->create(['user_id' => $user->id]);

        $response = $this->deleteJson("/api/posts/{$post->id}", [], [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Post deleted successfully',
            ]);
    }

    /**
     * Test failing to delete someone else's post.
     *
     * @return void
     */
    public function test_cannot_delete_another_users_post()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $token = $user1->createToken('API Token')->accessToken;

        $post = Post::factory()->create(['user_id' => $user2->id]);

        $response = $this->deleteJson("/api/posts/{$post->id}", [], [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertStatus(403)
            ->assertJson([
                'error' => 'You are not authorized to delete this post.',
            ]);
    }
}
