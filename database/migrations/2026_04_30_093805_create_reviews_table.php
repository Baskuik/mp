<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id('review_id');
            $table->foreignId('reviewer_id')->references('user_id')->on('users')->cascadeOnDelete();
            $table->foreignId('reviewee_id')->references('user_id')->on('users')->cascadeOnDelete();
            $table->foreignId('listing_id')->references('listing_id')->on('listings')->cascadeOnDelete();
            $table->tinyInteger('rating')->unsigned();
            $table->text('comment')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};