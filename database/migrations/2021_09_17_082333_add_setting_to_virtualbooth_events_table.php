<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSettingToVirtualboothEventsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('virtualbooth_events', function (Blueprint $table) {
              $table->string('gifSpeed',255)->nullable();
              $table->string('boomerangSpeed',255)->nullable();
              $table->string('backgrounds',255)->nullable();
              $table->string('logoImage',255)->nullable();
              $table->integer('logo-width')->default(0);
              $table->integer('logo-height')->default(0);
              $table->string('startImage',255)->nullable();
              $table->integer('start-width')->default(0);
              $table->integer('start-height')->default(0);
              $table->string('splashMessage',255)->nullable();
              $table->string('splashMessagePosition',255)->nullable();
              $table->string('thanksImage',255)->nullable();
              $table->integer('thanks-width')->default(0);
              $table->integer('thanks-height')->default(0);
              $table->string('thanksMessage',255)->nullable();
              $table->string('thanksMessagePosition',255)->nullable();
              $table->string('bgImage',255)->nullable();
              $table->integer('bgImage-width')->default(0);
              $table->integer('bgImage-height')->default(0);
              $table->string('bgColor',255)->nullable();
              $table->string('whitelabelurl',255)->nullable();
              $table->string('whitelabelemail',255)->nullable();
              $table->string('event-url',255)->nullable();
              $table->string('eventAction',255)->nullable();
             
        







        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('virtualbooth_events', function (Blueprint $table) {
            //
        });
    }
}
