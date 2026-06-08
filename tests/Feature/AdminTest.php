<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create(['role' => 'admin']);
    }

    public function test_non_admin_cannot_view_admin_users()
    {
        $user = User::factory()->create(['role' => 'user']);
        $this->actingAs($user);

        $response = $this->get(route('admin.users'));
        $response->assertStatus(403);
    }

    public function test_admin_can_block_a_user_and_delete_content()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();
        $user->likes()->create(['post_id' => $post->id]);

        $this->actingAs($this->admin);

        $this->post(route('admin.users.block', $user->id));

        $user->refresh();
        $this->assertTrue((bool)$user->is_blocked);
        $this->assertDatabaseMissing('likes', ['user_id' => $user->id]);
    }

    public function test_admin_can_update_user_details()
    {
        $user = User::factory()->create(['name' => 'Old Name']);

        $this->actingAs($this->admin);

        $this->put(route('admin.users.update', $user->id), [
            'name' => 'New Name',
            'email' => $user->email,
        ]);

        $this->assertDatabaseHas('users', ['id' => $user->id, 'name' => 'New Name']);
    }

    public function test_admin_can_delete_user_avatar()
    {
        Storage::fake('public');
        $user = User::factory()->create(['avatar' => 'avatars/test.jpg']);

        $this->actingAs($this->admin);
        $this->post(route('admin.users.delete_avatar', $user->id));

        $this->assertDatabaseHas('users', ['id' => $user->id, 'avatar' => null]);
    }
}
