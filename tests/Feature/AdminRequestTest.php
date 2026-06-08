<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminRequestTest extends TestCase
{
    use RefreshDatabase;

    public function test_store_category_request_validation()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);

        $response = $this->post(route('admin.categories.store'), [
            'name_hy' => '',
            'name_en' => ''
        ]);

        $response->assertSessionHasErrors(['name_hy', 'name_en']);
    }

    public function test_change_role_request_only_accepts_valid_roles()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $target = User::factory()->create(['role' => 'user']);
        $this->actingAs($admin);

        $response = $this->post(route('admin.users.role', $target->id), [
            'role' => 'super_hacker'
        ]);

        $response->assertSessionHasErrors(['role']);
    }

    public function test_update_user_email_must_be_unique()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user1 = User::factory()->create(['email' => 'one@test.com']);
        $user2 = User::factory()->create(['email' => 'two@test.com']);

        $this->actingAs($admin);

        $response = $this->put(route('admin.users.update', $user2->id), [
            'name' => 'Test Name',
            'email' => 'one@test.com'
        ]);

        $response->assertSessionHasErrors(['email']);
    }
}
