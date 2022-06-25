<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhotoboothTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('photobooth')) {
        Schema::create('photobooth', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title',255);
            $table->string('template',255);
            $table->string('public_id',255);
            $table->string('status',255);
            $table->timestamps();
        });
    }
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('photobooth');
    }
}
