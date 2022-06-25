<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	
        Schema::create('addons', function (Blueprint $table) {
		$table->increments('id');
		$table->string('title',255);
		$table->string('appointments',255);
		$table->string('pins',255); 
		$table->string('directory',255);
		$table->string('description',255);
		$table->string('status',255);
		$table->string('demolink',255);
		$table->string('features',255);
		$table->string('subtitle',255);
		$table->string('addon_key',255);
		$table->string('icon',255);
		$table->string('image',255);
		$table->string('usage_status',255);
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
        Schema::dropIfExists('addons');
    }
}
