<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAutorespondersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('autoresponder', function (Blueprint $table) {
           $table->id();
            $table->integer('user')->nullable();
             $table->string('typeTemplate')->nullable();
            $table->text('custom_message')->nullable();
            $table->text('custom_sms')->nullable();
            $table->string('campaign_name')->nullable();
            $table->integer('folder')->nullable();
            $table->text('day')->nullable();
            $table->string('time')->nullable();
            $table->string('typeOnChoice');
            $table->string('date')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('autoresponder');
    }
}
