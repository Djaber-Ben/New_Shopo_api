<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('stores', function (Blueprint $table) {
            if (Schema::hasColumn('stores', 'subscription_timer')) {
                $table->renameColumn('subscription_timer', 'subscription_expires_at');
            }
        });
    }

    public function down(): void
    {
        Schema::table('stores', function (Blueprint $table) {
            if (Schema::hasColumn('stores', 'subscription_expires_at')) {
                $table->renameColumn('subscription_expires_at', 'subscription_timer');
            }
        });
    }
};
