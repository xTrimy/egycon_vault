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
            $table->unsignedBigInteger('added_by_id'); // Define user_id column
            $table->foreign('added_by_id')->references('id')->on('users'); // Add foreign key constraint
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
