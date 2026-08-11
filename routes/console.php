<?php

use App\Models\Chat;
use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Facades\Storage;

Schedule::call(function () {
    Chat::onlyTrashed()
        ->where('deleted_at', '<=', now()->subDays(3))
        ->chunkById(100, function ($chats) {
            foreach ($chats as $chat) {
                $chat->messages()->onlyTrashed()->each(function ($msg) {
                    if ($msg->file_path) {
                        Storage::disk('public')->delete($msg->file_path);
                    }
                });
                $chat->messages()->onlyTrashed()->forceDelete();
                $chat->forceDelete();
            }
        });
})->daily();
