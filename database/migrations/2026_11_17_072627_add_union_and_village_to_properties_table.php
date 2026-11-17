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
        Schema::table('properties', function (Blueprint $table) {
            $table->foreignId('union_id')->nullable()->after('upazila_id')->constrained()->nullOnDelete();
            $table->foreignId('village_id')->nullable()->after('union_id')->constrained()->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropForeign(['union_id']);
            $table->dropForeign(['village_id']);
            $table->dropColumn(['union_id', 'village_id']);
        });
    }
};
