<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVirtualboothEventsFramesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('virtualbooth_events_frames', function (Blueprint $table) {
            $table->id();
            $table->integer('event_id')->nullable();;
            $table->string('image',255)->nullable();
            $table->string('type',255)->nullable();
            $table->string('status',255);
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
        Schema::dropIfExists('virtualbooth_events_frames');
    }
}
