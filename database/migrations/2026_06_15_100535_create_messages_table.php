<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up()
{
    Schema::create('chats', function (Blueprint $table) {
        $table->id();
        $table->string('name')->nullable();
        $table->boolean('is_group')->default(false);
        $table->foreignId('creator_id')->constrained('users');
        $table->timestamps();
        $table->softDeletes();
    });

    Schema::create('chat_user', function (Blueprint $table) {
        $table->id();
        $table->foreignId('chat_id')->constrained()->onDelete('cascade');
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->string('role')->default('member');
        $table->timestamps();
    });

    Schema::create('messages', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->foreignId('chat_id')->constrained()->onDelete('cascade');
        $table->text('content')->nullable();
        $table->string('file_path')->nullable();
        $table->string('type')->default('text');
        $table->boolean('is_edited')->default(false);
        $table->timestamp('read_at')->nullable();
        $table->softDeletes();
        $table->timestamps();
    });
}
public function down()
{
    Schema::dropIfExists('messages');
    Schema::dropIfExists('chat_user');
    Schema::dropIfExists('chats');
}
};
