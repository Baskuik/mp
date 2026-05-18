<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('messages', function (Blueprint $table) {
<<<<<<< HEAD:database/migrations/2026_04_30_093753_create_messages_table.php
            $table->id('message_id');
            $table->foreignId('conversation_id')->references('conversation_id')->on('conversations')->cascadeOnDelete();
            $table->foreignId('sender_id')->references('user_id')->on('users')->cascadeOnDelete();
=======
            $table->id();
            $table->foreignId('conversation_id')->constrained()->cascadeOnDelete();
            $table->foreignId('sender_id')->constrained('users', 'user_id')->cascadeOnDelete();
>>>>>>> mainpage:database/migrations/2026_04_30_093752_create_messages_table.php
            $table->text('body');
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};