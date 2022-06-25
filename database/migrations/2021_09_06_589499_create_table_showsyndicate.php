<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableShowSyndicate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   if (!Schema::hasTable('show_syndicate')) {     
		Schema::create('show_syndicate', function (Blueprint $table) {
		$table->id();   
		$table->foreignId('user_id')->constrained('users')->onDelete('cascade');
		$table->foreignId('certify_id')->constrained('certifies')->onDelete('cascade');
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
        Schema::dropIfExists('show_syndicate');
    }
}
