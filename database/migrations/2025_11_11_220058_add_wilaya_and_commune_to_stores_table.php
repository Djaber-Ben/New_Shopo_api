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
        Schema::table('stores', function (Blueprint $table) {
            // Add wilaya and commune foreign keys
            $table->foreignId('wilaya_id')
                ->nullable()
                ->after('category_id')
                ->constrained('wilayas')
                ->nullOnDelete();

            $table->foreignId('commune_id')
                ->nullable()
                ->after('wilaya_id')
                ->constrained('communes')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('stores', function (Blueprint $table) {
            // Drop foreign keys and columns for rollback
            $table->dropForeign(['wilaya_id']);
            $table->dropForeign(['commune_id']);
            $table->dropColumn(['wilaya_id', 'commune_id']);
        });
    }
};
