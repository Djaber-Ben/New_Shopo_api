<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('site_infos', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique(); // Example: site_name, logo, contact_email
            $table->text('value')->nullable(); // Value for the key
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_infos');
    }
};
