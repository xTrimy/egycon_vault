<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBelongingsHistoryTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('belongings_history', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null')->onUpdate('set null');
      $table->foreignId('item_id')->nullable()->constrained('belongings')->onDelete('set null')->onUpdate('set null');
      $table->string('action_type');
      $table->timestamp('action_timestamp');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('belongings_history');
  }
}
