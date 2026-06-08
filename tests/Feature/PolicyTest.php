<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PolicyTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_manage_categories()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);

        $response = $this->post(route('admin.categories.store'), ['name' => 'New']);
        $response->assertStatus(302);
    }

    public function test_user_cannot_manage_categories()
    {
        $user = User::factory()->create(['role' => 'user']);
        $this->actingAs($user);

        $response = $this->post(route('admin.categories.store'), ['name' => 'New']);
        $response->assertStatus(403);
    }

    public function test_user_can_update_own_post()
    {
        $user = User::factory()->create(['role' => 'user']);
        $post = Post::factory()->create(['user_id' => $user->id]);
        $this->actingAs($user);

        $response = $this->put(route('posts.update', $post->id), [
            'title' => 'Updated',
            'body' => 'Content',
            'category_id' => 1
        ]);
        $response->assertStatus(302);
    }

    public function test_user_cannot_update_others_post()
    {
        $owner = User::factory()->create();
        $stranger = User::factory()->create(['role' => 'user']);
        $post = Post::factory()->create(['user_id' => $owner->id]);

        $this->actingAs($stranger);
        $response = $this->put(route('posts.update', $post->id), [
            'title' => 'Hacked',
            'body' => 'Hacked',
            'category_id' => 1
        ]);

        $response->assertStatus(403);
    }

    public function test_admin_can_change_role()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $target = User::factory()->create(['role' => 'user']);
        $this->actingAs($admin);

        $response = $this->post(route('admin.users.role', $target->id), ['role' => 'moderator']);
        $response->assertStatus(302);
    }
}
