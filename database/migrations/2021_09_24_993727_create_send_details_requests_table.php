<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSendDetailsRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('send_details_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('sender');
            $table->integer('reciver');
            $table->string('type',255);
            $table->text('overview')->nullable();
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
        Schema::dropIfExists('send_details_requests');
    }
}
