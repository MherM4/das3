<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\InteractionController;
use Illuminate\Support\Facades\Route;


Route::middleware(['guest'])->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::get('/login', 'showLogin')->name('login');
        Route::post('/login', 'login');
        Route::get('/register', 'showRegister')->name('register');
        Route::post('/register', 'register');
    });
});

Route::middleware(['auth', 'no-cache'])->group(function () {

    Route::get('/', [PostController::class, 'index'])->name('home');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::controller(InteractionController::class)->group(function () {
        Route::post('/posts/{post}/like', 'toggleLike')->name('posts.like');
        Route::post('/posts/{post}/save', 'toggleSave')->name('posts.save');
        Route::post('/posts/{post}/comment', 'storeComment')->name('posts.comment');
        Route::get('/saved-posts', 'savedPosts')->name('posts.saved');
        Route::delete('/comments/{comment}', 'destroyComment')->name('comments.destroy');
    });

    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'showProfile')->name('profile');
        Route::get('/profile/edit', 'editProfile')->name('profile.edit');
        Route::post('/profile/update', 'updateProfile')->name('profile.update');
        Route::post('/profile/avatar/delete', 'deleteAvatar')->name('avatar.delete');
        Route::get('/profile/password', 'showPasswordForm')->name('password.edit');
        Route::post('/profile/password', 'updatePassword')->name('password.update');
        Route::get('/user/{user}/profile', 'showProfile')->name('user.profile');
    });

    Route::controller(PostController::class)->group(function () {
        Route::get('/my-posts', 'manage')->name('posts.manage');
        Route::get('/posts/create', 'create')->name('posts.create');
        Route::post('/posts-store', 'store')->name('posts.store');
        Route::get('/posts/{post}/edit', 'edit')->name('posts.edit');
        Route::put('/posts/{post}', 'update')->name('posts.update');
        Route::delete('/posts/{post}', 'destroy')->name('posts.destroy');
        Route::get('/my-trash', 'myTrash')->name('posts.trash');
        Route::post('/posts/{id}/restore', 'restore')->name('posts.restore');
        Route::delete('/posts/{id}/force-delete', 'forceDelete')->name('posts.force_delete');
    });

    Route::middleware(['role:admin'])->group(function () {
        Route::controller(AdminController::class)->group(function () {
            Route::get('/admin/dashboard', 'adminDashboard')->name('admin.dashboard');
            Route::get('/admin/users', 'adminUsers')->name('admin.users');
            Route::get('/admin/users/{user}/edit', 'editUser')->name('admin.users.edit');
            Route::put('/admin/users/{user}/update', 'updateUser')->name('admin.users.update');
            Route::post('/admin/users/{user}/block', 'toggleBlock')->name('admin.users.block');
            Route::post('/admin/users/{user}/role', 'changeRole')->name('admin.users.role');
            Route::post('/admin/users/{user}/avatar/delete', 'adminDeleteAvatar')->name('admin.users.delete_avatar');
        });
        Route::get('/admin/trash', [PostController::class, 'adminTrash'])->name('admin.trash');
    });

    Route::middleware(['role:super_admin'])->group(function () {
        Route::get('/super-admin/settings', [AdminController::class, 'superSettings'])->name('super.settings');
    });
});
