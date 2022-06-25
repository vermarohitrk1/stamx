<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssistanceRequestsTable extends Migration 
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		     if (!Schema::hasTable('assistance_requests')) { 
        Schema::create('assistance_requests', function (Blueprint $table) {
		$table->bigIncrements('id');
		$table->integer('assistance');
		$table->integer('user');
		$table->string('type',255);
		$table->string('certify',255);
		$table->string('gender',255);
		$table->string('date',255);
		$table->time('time');
		$table->string('status',255);
		$table->integer('action')->default('0')->comment('0=none,1=approve,2=reject');
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
        Schema::dropIfExists('assistance_requests');
    }
}
