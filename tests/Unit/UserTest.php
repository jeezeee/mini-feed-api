namespace Tests\Unit;
<?php

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that a user can like posts.
     *
     * @return void
     */
    public function test_user_can_like_posts()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();

        $user->likes()->attach($post->id);

        $this->assertTrue($user->likes->contains($post));

        $this->assertDatabaseHas('likes', [
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);
    }

    /**
     * Test that a post can be liked by multiple users.
     *
     * @return void
     */
    public function test_post_can_be_liked_by_multiple_users()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $post = Post::factory()->create();

        $user1->likes()->attach($post->id);
        $user2->likes()->attach($post->id);

        $this->assertDatabaseHas('likes', [
            'user_id' => $user1->id,
            'post_id' => $post->id,
        ]);
        $this->assertDatabaseHas('likes', [
            'user_id' => $user2->id,
            'post_id' => $post->id,
        ]);
    }
}
