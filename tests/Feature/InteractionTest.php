<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InteractionTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_user_can_toggle_like_on_post()
    {
        $post = Post::factory()->create();
        $this->actingAs($this->user);

        $this->post(route('posts.like', $post->id));
        $this->assertDatabaseHas('likes', ['user_id' => $this->user->id, 'post_id' => $post->id]);

        $this->post(route('posts.like', $post->id));
        $this->assertDatabaseMissing('likes', ['user_id' => $this->user->id, 'post_id' => $post->id]);
    }

    public function test_user_can_store_comment()
    {
        $post = Post::factory()->create();
        $this->actingAs($this->user);

        $response = $this->post(route('posts.comment', $post->id), [
            'body' => 'Հիանալի պոստ է!'
        ]);

        $this->assertDatabaseHas('comments', ['body' => 'Հիանալի պոստ է!', 'user_id' => $this->user->id]);
        $response->assertStatus(302);
    }

    public function test_user_can_delete_own_comment()
    {
        $comment = Comment::factory()->create(['user_id' => $this->user->id]);
        $this->actingAs($this->user);

        $this->delete(route('comments.destroy', $comment->id));
        $this->assertDatabaseMissing('comments', ['id' => $comment->id]);
    }
}
