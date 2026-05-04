<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('bids', function (Blueprint $table) {
            $table->id('bid_id');
            $table->foreignId('listing_id')->references('listing_id')->on('listings')->cascadeOnDelete();
            $table->foreignId('buyer_id')->references('user_id')->on('users')->cascadeOnDelete();
            $table->decimal('amount', 10, 2);
            $table->enum('status', ['pending', 'accepted', 'declined'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bids');
    }
};