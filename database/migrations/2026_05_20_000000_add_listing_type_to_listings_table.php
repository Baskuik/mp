<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('listings', function (Blueprint $table) {
            $table->string('listing_type')->default('fixed')->after('label');
        });

        DB::statement('ALTER TABLE listings MODIFY price DECIMAL(10,2) NULL');
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE listings MODIFY price DECIMAL(10,2) NOT NULL');

        Schema::table('listings', function (Blueprint $table) {
            $table->dropColumn('listing_type');
        });
    }
};
