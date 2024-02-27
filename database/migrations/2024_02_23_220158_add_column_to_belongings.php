<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToBelongings extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('belongings', function (Blueprint $table) {
      $table->foreignId('added_by_id')->nullable()->constrained('users')->onDelete('set null')->onUpdate('set null');
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
      $table->dropForeign(['added_by_id']); // Drop foreign key constraint
      $table->dropColumn('added_by_id'); // Drop user_id column
    });
  }
}
