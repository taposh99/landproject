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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('district_id')->constrained()->cascadeOnDelete();
            $table->foreignId('upazila_id')->constrained()->cascadeOnDelete();
            $table->string('mouza_area')->nullable(); // e.g. Ghorashal, Charsindur, Danga
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');

            // Land specific details
            $table->enum('land_type', ['residential', 'commercial', 'agricultural', 'industrial'])->default('residential');
            $table->decimal('land_size', 10, 2); // Amount
            $table->enum('size_unit', ['decimal', 'katha', 'bigha', 'acre'])->default('decimal');
            $table->decimal('price', 15, 2);
            $table->enum('price_type', ['total', 'per_decimal', 'per_katha'])->default('total');
            $table->boolean('is_negotiable')->default(true);

            // Road & Location details
            $table->integer('road_width_feet')->nullable();
            $table->string('road_type')->nullable(); // paved (পাকা), brick (সোলিং), dirt (কাঁচা)
            $table->string('address')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();

            // Legal & Paperwork status
            $table->string('khatian_type')->nullable(); // CS, SA, RS, BS, City Jarip
            $table->string('daag_no')->nullable();
            $table->string('khatian_no')->nullable();
            $table->boolean('is_mutation_done')->default(false); // নামজারি / খারিজ
            $table->boolean('is_tax_updated')->default(false); // খাজনা হালনাগাদ

            // Contact
            $table->string('contact_number');
            $table->string('whatsapp_number')->nullable();

            // Status & Verification
            $table->enum('status', ['pending', 'approved', 'rejected', 'sold'])->default('pending');
            $table->boolean('is_verified')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->text('rejection_reason')->nullable();
            $table->string('featured_image')->nullable();
            $table->unsignedBigInteger('views_count')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
