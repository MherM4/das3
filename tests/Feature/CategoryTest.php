<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create(['role' => 'admin']);
    }

    public function test_admin_can_view_categories()
    {
        $this->actingAs($this->admin);
        $response = $this->get(route('admin.categories'));
        $response->assertStatus(200);
    }

    public function test_admin_can_store_category()
    {
        $this->actingAs($this->admin);

        $response = $this->post(route('admin.categories.store'), [
            'name_hy' => 'Նորություններ',
            'name_en' => 'News',
        ]);

        $this->assertDatabaseHas('categories', [
            'name->hy' => 'Նորություններ',
            'name->en' => 'News',
        ]);
        $response->assertRedirect();
    }

    public function test_admin_can_delete_category()
    {
        $this->actingAs($this->admin);
        $category = Category::factory()->create();

        $response = $this->delete(route('categories.destroy', $category->id));

        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
        $response->assertRedirect();
    }
}
