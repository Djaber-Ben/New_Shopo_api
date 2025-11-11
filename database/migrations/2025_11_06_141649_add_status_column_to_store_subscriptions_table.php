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
    Schema::table('store_subscriptions', function (Blueprint $table) {
      $table->enum('status', ['active', 'expired', 'cancelled', 'pending'])
        ->default('pending')
        ->after('end_date');
    });
  }

  public function down()
  {
    Schema::table('store_subscriptions', function (Blueprint $table) {
      $table->dropColumn('status');
    });
  }

};
