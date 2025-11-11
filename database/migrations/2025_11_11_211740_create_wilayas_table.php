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
        Schema::create('wilayas', function (Blueprint $table) {
            $table->id();
            $table->string('code', 10)->unique(); // e.g. DZ-01
            $table->string('number', 3);          // e.g. 01
            $table->string('name_en');            // e.g. Adrar
            $table->string('name_ar');            // e.g. أدرار
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wilayas');
    }
};
