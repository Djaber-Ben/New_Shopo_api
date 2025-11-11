<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   */
  public function up()
  {
    Schema::table('subscription_plans', function (Blueprint $table) {
      // Remove old incorrect columns if they exist
      if (Schema::hasColumn('subscription_plans', 'max_products')) {
        $table->dropColumn('max_products');
      }
      if (Schema::hasColumn('subscription_plans', 'max_stores')) {
        $table->dropColumn('max_stores');
      }
      if (Schema::hasColumn('subscription_plans', 'is_active')) {
        $table->dropColumn('is_active');
      }

      // Add correct new columns if missing
      if (!Schema::hasColumn('subscription_plans', 'is_trial')) {
        $table->boolean('is_trial')->default(false)->after('duration_days');
      }
      if (!Schema::hasColumn('subscription_plans', 'status')) {
        $table->enum('status', ['active', 'inactive'])->default('active')->after('is_trial');
      }
    });
  }

  public function down()
  {
    Schema::table('subscription_plans', function (Blueprint $table) {
      $table->dropColumn(['is_trial', 'status']);
    });
  }

};
