<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\InteractionController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ChatController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

Route::middleware(['guest'])->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::get('/login', 'showLogin')->name('login');
        Route::post('/login', 'login');
        Route::get('/register', 'showRegister')->name('register');
        Route::post('/register', 'register');
    });
});

Route::get('lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'hy'])) {
        Session::put('locale', $locale);
        if (auth()->check()) {
            auth()->user()->update(['language' => $locale]);
        } else {
            cookie()->queue('user_lang', $locale, 525600);
        }
    }

    return redirect()->back();
})->name('lang.switch');

Route::middleware(['auth', 'no-cache'])->group(function () {

    Route::get('/', [PostController::class, 'index'])->name('home');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::controller(InteractionController::class)->group(function () {
        Route::post('/posts/{post}/like', 'toggleLike')->name('posts.like');
        Route::post('/posts/{post}/save', 'toggleSave')->name('posts.save');
        Route::post('/posts/{post}/comment', 'storeComment')->name('posts.comment');
        Route::get('/saved-posts', 'savedPosts')->name('posts.saved');
        Route::delete('/comments/{comment}', 'destroyComment')->name('comments.destroy');
        Route::post('/comments/{comment}/like', 'toggleCommentLike')->name('comments.like');
        Route::post('/comments/{comment}/reply', 'storeReply')->name('comments.reply');
    });

    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'myProfile')->name('profile');
        Route::get('/profile/edit', 'editProfile')->name('profile.edit');
        Route::post('/profile/update', 'updateProfile')->name('profile.update');
        Route::post('/profile/avatar/delete', 'deleteAvatar')->name('avatar.delete');
        Route::get('/profile/password', 'showPasswordForm')->name('password.edit');
        Route::post('/profile/password', 'updatePassword')->name('password.update');
        Route::get('/user/{user}/profile', 'showProfile')->name('user.profile');
        Route::post('/avatar/delete/{user}', 'deleteAvatar')->name('avatar.delete');
        Route::post('/avatar/restore/{user}', 'restoreAvatar')->name('avatar.restore');
        Route::post('/avatar/force-delete', 'forceDeleteAvatar')->name('avatar.forceDelete');
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

    Route::middleware(['role:admin'])->prefix('admin')->group(function () {
    Route::controller(AdminController::class)->prefix('users')->group(function () {
        Route::get('/', 'adminUsers')->name('admin.users');
        Route::get('/{user}/edit', 'editUser')->name('admin.users.edit');
        Route::put('/{user}/update', 'updateUser')->name('admin.users.update');
        Route::post('/{user}/block', 'toggleBlock')->name('admin.users.block');
        Route::post('/{user}/role', 'changeRole')->name('admin.users.role');
        Route::post('/{user}/avatar/delete', 'adminDeleteAvatar')->name('admin.users.delete_avatar');
    });

    Route::controller(CategoryController::class)->prefix('categories')->group(function () {
        Route::get('/', 'index')->name('admin.categories');
        Route::post('/', 'store')->name('admin.categories.store');
        Route::delete('/{category}', 'destroy')->name('categories.destroy');
    });

    Route::get('/trash', [PostController::class, 'adminTrash'])->name('admin.trash');
});

    Route::middleware(['role:super_admin'])->group(function () {
        Route::get('/super-admin/settings', [AdminController::class, 'superSettings'])->name('super.settings');
    });

   Route::controller(ChatController::class)->prefix('chat')->group(function () {
    Route::get('/', 'index')->name('chat.index');
    Route::get('/trash', 'trash')->name('chat.trash');
    Route::get('/{chat}', 'show')->name('chat.show');

    Route::post('/start/{user}', 'startChat')->name('chat.start');
    Route::delete('/{chat}/delete', 'destroy')->name('chat.destroy');
    Route::patch('/{chat}/restore', 'restore')->name('chat.restore');
    Route::delete('/{chat}/force-delete', 'forceDelete')->name('chat.forceDelete');
    Route::post('/{chat}/leave', 'leaveChat')->name('chat.leave');
    Route::post('/{chat}/set-admin/{userId}', 'setAdmin')->name('chat.set-admin');
    Route::patch('/{chat}/rename', 'updateName')->name('chat.rename');
    Route::patch('/{chat}/remove-name', 'removeName')->name('chat.remove-name');

    Route::post('/send', 'sendMessage')->name('chat.send');
    Route::put('/message/{message}', 'updateMessage')->name('chat.message.update');
    Route::delete('/message/{message}', 'destroyMessage')->name('chat.message.destroy');
});
});
