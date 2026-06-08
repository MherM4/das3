<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_user_can_create_post()
    {
        $this->actingAs($this->user);
        $category = Category::factory()->create();

        $response = $this->post(route('posts.store'), [
            'title' => 'Test Post',
            'body' => 'Post body content',
            'category_id' => $category->id,
        ]);

        $this->assertDatabaseHas('posts', ['title' => 'Test Post']);
        $response->assertRedirect('/');
    }

    public function test_user_can_move_post_to_trash()
    {
        $this->actingAs($this->user);
        $post = Post::factory()->create(['user_id' => $this->user->id]);

        $this->delete(route('posts.destroy', $post->id));

        $this->assertSoftDeleted('posts', ['id' => $post->id]);
    }

    public function test_user_can_restore_post_from_trash()
    {
        $this->actingAs($this->user);
        $post = Post::factory()->create(['user_id' => $this->user->id]);
        $post->delete();

        $this->post(route('posts.restore', $post->id));

        $post->refresh();
        $this->assertDatabaseHas('posts', ['id' => $post->id, 'deleted_at' => null]);
    }

    public function test_user_can_force_delete_post_and_image()
    {
        Storage::fake('public');
        $this->actingAs($this->user);

        $post = Post::factory()->create(['user_id' => $this->user->id]);
        $post->delete();

        $this->delete(route('posts.force_delete', $post->id));

        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
    }
}
