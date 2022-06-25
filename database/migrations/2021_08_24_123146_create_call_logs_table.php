<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCallLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('call_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('dept_id')->nullable();
            $table->string('phone')->nullable();
            $table->string('pfrom')->nullable();
            $table->string('direction')->nullable();
            $table->string('recordingsid')->nullable();
            $table->text('recordingurl')->nullable();
            $table->text('parentcallsid')->nullable();
            $table->string('dialcallstatus')->nullable();
            $table->tinyInteger('dialcallduration')->default(0);
            $table->text('transceriptiontext')->nullable();
            $table->tinyInteger('type')->default(0);
            $table->string('statusin')->nullable();
            $table->string('startat')->nullable();
            $table->string('endat')->nullable();
            $table->tinyInteger('survey')->default(0);
            $table->tinyInteger('record_show')->default(1);
            $table->tinyInteger('voicemail')->default(0);
            $table->tinyInteger('seen')->default(0);
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
        Schema::dropIfExists('call_logs');
    }
}
