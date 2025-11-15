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
        Schema::create('stores', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key (int)
            $table->foreignId('vendor_id')->constrained('users')->onDelete('cascade'); // Foreign key to vendors table
            $table->foreignId('category_id')->constrained()->onDelete('cascade'); // Foreign key to categories table
            $table->foreignId('wilaya_id')->constrained()->onDelete('cascade'); // Foreign key to wilayas table
            $table->foreignId('commune_id')->constrained()->onDelete('cascade'); // Foreign key to communes table
            $table->string('store_name'); // String column for store name
            $table->string('slug')->nullable()->unique(); // String column for slug, unique to avoid duplicates
            $table->text('description')->nullable(); // Text column for description, nullable
            $table->string('logo')->nullable(); // String column for logo path or URL, nullable
            $table->string('image')->nullable(); // String column for image path or URL, nullable
            $table->string('phone_number'); // String column for phone number, nullable
            $table->string('address'); // String column for address, nullable
            $table->string('address_url'); // String column for address url, nullable
            $table->decimal('latitude', 10, 8)->nullable(); // Decimal column for latitude, nullable
            $table->decimal('longitude', 10, 8)->nullable(); // Decimal column for longitude, nullable
            $table->enum('status', ['active', 'inactive'])->default('active'); // ENUM column for status
            $table->dateTime('subscription_timer')->nullable(); // DateTime column for subscription timer, nullable
            $table->string('whatsapp')->nullable();
            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();
            $table->string('tiktok')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stores');
    }
};
