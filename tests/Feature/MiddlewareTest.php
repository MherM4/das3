<?php

namespace Tests\Feature;

use App\Models\User;
use App\Http\Middleware\PreventBackHistory;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Middleware\SetLocale;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MiddlewareTest extends TestCase
{
    use RefreshDatabase;

    public function test_prevent_back_history_adds_headers()
    {
        Route::get('/test-back', fn() => 'OK')->middleware(PreventBackHistory::class);
        $response = $this->get('/test-back');

        $header = $response->headers->get('Cache-Control');

        $this->assertStringContainsString('no-cache', $header);
        $this->assertStringContainsString('no-store', $header);
        $this->assertStringContainsString('max-age=0', $header);
        $this->assertStringContainsString('must-revalidate', $header);
    }

    public function test_role_middleware_allows_super_admin()
    {
        $user = User::factory()->create(['role' => 'super_admin']);
        $this->actingAs($user);

        Route::get('/admin-test', fn() => 'OK')->middleware([RoleMiddleware::class . ':admin']);

        $this->get('/admin-test')->assertStatus(200);
    }

    public function test_role_middleware_denies_wrong_role()
    {
        $user = User::factory()->create(['role' => 'user']);
        $this->actingAs($user);

        Route::get('/admin-test', fn() => 'OK')->middleware([RoleMiddleware::class . ':admin']);

        $this->get('/admin-test')->assertStatus(403);
    }

    public function test_set_locale_middleware_sets_app_locale_from_user()
    {
        $user = User::factory()->create(['language' => 'hy']);
        $this->actingAs($user);

        Route::get('/lang-test', function () {
            return app()->getLocale();
        })->middleware(SetLocale::class);

        $this->get('/lang-test')->assertSee('hy');
    }
}
