<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class FormRequestTest extends TestCase
{
    use RefreshDatabase;

    public function test_store_post_request_validates_images()
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $this->actingAs($user);

        $file = UploadedFile::fake()->create('document.txt', 100);

        $response = $this->post(route('posts.store'), [
            'title' => 'Test Post',
            'body' => 'Content',
            'category_id' => $category->id,
            'images' => [$file]
        ]);

        $response->assertSessionHasErrors(['images.0']);
    }

    public function test_register_request_validates_password_confirmation()
    {
        $response = $this->post(route('register'), [
            'name' => 'John',
            'email' => 'john@example.com',
            'password' => 'password123',
            'password_confirmation' => 'different-password'
        ]);

        $response->assertSessionHasErrors(['password']);
    }

    public function test_update_profile_email_must_be_unique_to_others()
    {
        $user1 = User::factory()->create(['email' => 'one@test.com']);
        $user2 = User::factory()->create(['email' => 'two@test.com']);
        $this->actingAs($user2);

        $response = $this->post(route('profile.update'), [
            'name' => 'New Name',
            'email' => 'one@test.com'
        ]);

        $response->assertSessionHasErrors(['email']);
    }

    public function test_filter_post_request_validates_category_exists()
    {
        $this->actingAs(User::factory()->create());

        $response = $this->get('/?category_id=999');

        $response->assertSessionHasErrors(['category_id']);
    }
}
