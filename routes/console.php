<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Models\Post;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


Schedule::call(function () {
    $oldPosts = Post::onlyTrashed()->where('deleted_at', '<=', now()->subDays(30))->get();

    foreach ($oldPosts as $post) {
        foreach ($post->images as $img) {
            if (file_exists(public_path($img->image))) {
                unlink(public_path($img->image));
            }
        }
        $post->forceDelete();
    }
})->daily();
