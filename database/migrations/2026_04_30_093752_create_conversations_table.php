<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('conversations', function (Blueprint $table) {
<<<<<<< HEAD
            $table->id('conversation_id');
            $table->foreignId('listing_id')->references('listing_id')->on('listings')->cascadeOnDelete();
            $table->foreignId('buyer_id')->references('user_id')->on('users')->cascadeOnDelete();
            $table->foreignId('seller_id')->references('user_id')->on('users')->cascadeOnDelete();
=======
            $table->id();
            $table->foreignId('listing_id')->constrained()->cascadeOnDelete();
            $table->foreignId('buyer_id')->constrained('users', 'user_id')->cascadeOnDelete();
            $table->foreignId('seller_id')->constrained('users', 'user_id')->cascadeOnDelete();
>>>>>>> mainpage
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('conversations');
    }
};