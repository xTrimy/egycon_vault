<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVisitorTypeIdColumnToBelongingsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('belongings', function (Blueprint $table) {
      $table->foreignId('visitor_type_id')->nullable()->constrained()->onDelete('set null')->onUpdate('set null');
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
      $table->dropColumn('visitor_type_id');
    });
  }
}
