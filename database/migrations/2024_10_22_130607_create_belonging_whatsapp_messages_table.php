<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBelongingWhatsappMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('belonging_whatsapp_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('belonging_id')->nullable()->constrained()->onDelete('set null');
            $table->string('phone');
            $table->text('message');
            $table->string('failure_reason')->nullable();
            $table->boolean('is_sent')->default(false);
            $table->timestamp('sent_at')->nullable();
            $table->timestamp('failed_at')->nullable();
            $table->boolean('received')->default(false);
            $table->timestamp('received_at')->nullable();
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
        Schema::dropIfExists('belonging_whatsapp_messages');
    }
}
