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
        Schema::create('offline_payments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('family_name');
            $table->bigInteger('ccp_number');
            $table->integer('cle');
            $table->bigInteger('rip');
            $table->string('address');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offline_payments');
    }
};