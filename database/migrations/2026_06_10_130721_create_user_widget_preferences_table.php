<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_widget_preferences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
    ->constrained(table: 'users', column: 'user_id')
    ->cascadeOnDelete();
            $table->string('page');           // 'users', 'listings', etc.
            $table->string('widget');         // FQCN van de widget class
            $table->boolean('enabled')->default(true);
            $table->timestamps();

            $table->unique(['user_id', 'page', 'widget']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_widget_preferences');
    }
};