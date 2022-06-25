<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CratePetitionupdatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('petition_updates', function (Blueprint $table) {
                   $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');           
            $table->unsignedBigInteger('petition_id');   
                   $table->date('date')->nullable();
             $table->text('updates')->nullable(); 
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
        Schema::dropIfExists('petition_updates');
    }
}
