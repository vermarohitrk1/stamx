<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIvrSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ivr_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->text('twilio_mp3')->nullable();
            $table->text('twilio_text')->nullable();
            $table->tinyInteger('greetings')->default(0)->comment('0:tts,1:mp3');
            $table->text('greetings_mp3')->nullable();
            $table->tinyInteger('ivr')->default(0)->comment('0:tts,1:mp3');
            $table->text('ivr_text')->nullable();
            $table->text('ivr_mp3')->nullable();
            $table->tinyInteger('voicemail')->default(0)->comment('0:tts,1:mp3');
            $table->text('voicemail_text')->nullable();
            $table->text('voicemail_mp3')->nullable();
            $table->string('twilio_number')->default();
            $table->string('sid');
            $table->string('twilio_voice')->default(0)->comment('0:man,1:woman,2:alice');
            $table->tinyInteger('transfer_call')->default(0)->comment('0:webphone,1:forward,2:voicemails');
            $table->text('incomingcall_mp3')->nullable();
            $table->tinyInteger('caller_wait_time')->default(0);
            $table->string('support')->nullable();
            $table->string('sales')->nullable();
            $table->integer('notification')->nullable();
            $table->string('email')->nullable();
            $table->string('mobile')->nullable();
            $table->text('email_template')->nullable();
            $table->text('sms_template')->nullable();
            $table->tinyInteger('out_of_hour')->default(0);
            $table->tinyInteger('out_of_hour_type')->default(0);
            $table->text('out_of_hour_text')->nullable();
            $table->text('out_of_hour_mp3')->nullable();
            $table->text('sunday')->nullable();
            $table->text('monday')->nullable();
            $table->text('tuesday')->nullable();
            $table->text('wednesday')->nullable();
            $table->text('thursday')->nullable();
            $table->text('friday')->nullable();
            $table->text('saturday')->nullable();
            $table->string('timezone')->nullable();
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
        Schema::dropIfExists('ivr_settings');
    }
}
