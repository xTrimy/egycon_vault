<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSlotIdTableToBelongingsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('belongings', function (Blueprint $table) {
      $table->foreignId('slot_id')->nullable()->constrained()->onUpdate('set null')->onDelete('set null');
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
      $table->dropColumn('slot_id');
    });
  }
}
