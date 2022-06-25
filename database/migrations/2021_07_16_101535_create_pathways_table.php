<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePathwaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pathways', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('type',255);
            $table->string('certify',255);
            $table->date('timeline');
            $table->enum('send_reminder', ['Yes', 'No']);
            $table->enum('reminder_type', ['Daily', 'Weekly', 'Monthly','NULL']);
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
        Schema::dropIfExists('pathways');
    }
}
