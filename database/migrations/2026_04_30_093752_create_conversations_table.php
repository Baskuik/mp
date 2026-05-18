<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('conversations', function (Blueprint $table) {
            $table->id('conversation_id');
            $table->foreignId('listing_id')->references('listing_id')->on('listings')->cascadeOnDelete();
            $table->foreignId('buyer_id')->references('user_id')->on('users')->cascadeOnDelete();
            $table->foreignId('seller_id')->references('user_id')->on('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('conversations');
    }
};