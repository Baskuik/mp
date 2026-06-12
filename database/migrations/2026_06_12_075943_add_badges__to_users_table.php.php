<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
    $table->boolean('show_badge_premium')->default(false);
    $table->boolean('show_badge_email')->default(false);
    $table->boolean('show_badge_phone')->default(false);
});
    }

    /**
     * Reverse the migrations.
     */
public function down(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn(['show_badge_premium', 'show_badge_email', 'show_badge_phone']);
    });
}
};
