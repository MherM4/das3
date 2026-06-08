<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_user_can_update_profile_info()
    {
        $this->actingAs($this->user);

        $response = $this->post(route('profile.update'), [
            'name' => 'New Name',
            'email' => 'new@example.com',
        ]);

        $this->user->refresh();
        $this->assertEquals('New Name', $this->user->name);
        $this->assertEquals('new@example.com', $this->user->email);
        $response->assertRedirect();
    }

    public function test_user_can_update_avatar()
    {
        Storage::fake('public');
        $this->actingAs($this->user);

        $file = UploadedFile::fake()->create('avatar.jpg', 500);

        $this->post(route('profile.update'), [
            'name' => $this->user->name,
            'email' => $this->user->email,
            'avatar' => $file,
        ]);

        $this->user->refresh();
        $this->assertNotNull($this->user->avatar);
        Storage::disk('public')->assertExists($this->user->avatar);
    }

    public function test_user_can_change_password()
    {
        $user = User::factory()->create(['password' => Hash::make('old-password')]);
        $this->actingAs($user);

        $response = $this->post(route('password.update'), [
            'current_password' => 'old-password',
            'new_password' => 'new-password',
            'new_password_confirmation' => 'new-password',
        ]);

        $response->assertRedirect();
        $this->assertTrue(Hash::check('new-password', $user->fresh()->password));
    }

    public function test_user_can_delete_avatar_softly()
    {
        $user = User::factory()->create(['avatar' => 'avatars/test.jpg']);
        $this->actingAs($user);

        $this->post(route('avatar.delete', $user->id));

        $user->refresh();
        $this->assertNotNull($user->avatar_deleted_at);
    }
}
