<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToBelongingsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('belongings', function (Blueprint $table) {
      $table->foreignId('belonging_type_id')->nullable()->constrained()->onDelete('set null')->onUpdate('set null');
      $table->foreignId('belonging_size_id')->nullable()->constrained()->onDelete('set null')->onUpdate('set null');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('belongings', function (Blueprint $table) {
      $table->dropColumn('belonging_type_id');
      $table->dropColumn('belonging_size_id');
    });
  }
}
