<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVirtualboothEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('virtualbooth_events', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();;
            $table->string('event_name',255)->nullable();
            $table->string('event_image',255)->nullable();
          
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
        Schema::dropIfExists('virtualbooth_events');
    }
}
