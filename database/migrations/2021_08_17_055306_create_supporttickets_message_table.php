<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupportticketsMessageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supportticketmessages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('ticket_id');   
            $table->unsignedBigInteger('user_id');   
            $table->text('message')->nullable(); 
            $table->enum('sender_type', ['Support','Customer'])->default('Customer');
              $table->string('file')->nullable();
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
        Schema::dropIfExists('supportticketmessages');
    }
}
