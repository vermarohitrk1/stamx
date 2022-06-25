<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatInboxTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chat_inbox', function (Blueprint $table) {
            $table->id();
            $table->integer('sender_id');
            $table->integer('receiver_id');
			  $table->integer('group_id')->default(0);
            $table->text('message_text');
            $table->enum('message_type', ['text', 'attachment']);
            $table->enum('sender_seen_status', ['Yes', 'No']);
            $table->enum('receiver_seen_status', ['Yes', 'No']);
            $table->enum('sender_trash_status', ['Yes', 'No']);
            $table->dateTime('msg_sent_at')->useCurrent();
            $table->string('message_cat',255);
			
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
        Schema::dropIfExists('chat_inbox');
    }
}
