<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('twilio_number')->nullable();
            $table->integer('num_price')->nullable();
            $table->string('stripe_pub_key')->nullable();
            $table->string('stripe_sec_key')->nullable();
            $table->string('stripe_plan')->nullable();
            $table->string('auth_token')->nullable();
            $table->string('account_sid')->nullable();
            $table->string('twiml_app_sid')->nullable();
            $table->string('twilio_voice')->nullable(); 
            $table->boolean('transfer_call')->default('0')->comment('0= web phone, 1=forward, 2=voicemail');          
            $table->boolean('greetings')->default('0')->comment('0= tts,1= mp3');
            $table->string('greetings_tts',255)->nullable();
            $table->string('greetings_mp3',255)->nullable();
            $table->boolean('voicemail')->default('0')->comment('0= tts,1= mp3');
            $table->string('voicemail_tts',255)->nullable()->default('Please leave a message at the beep. Press the star key when finished');
            $table->string('voicemail_mp3',255)->nullable();
            $table->text('hold_music',255)->nullable();
            $table->text('incomingcall_mp3',255)->nullable(); 
            $table->text('forward_number',255)->nullable();
            $table->boolean('call_record')->default('0')->comment('0= false, 1=true');       
            $table->string('survey_number')->nullable();             
            $table->float('topup_price')->nullable();
            $table->float('minutes')->default('0')->nullable();
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
        Schema::dropIfExists('user_settings');
    }
}
