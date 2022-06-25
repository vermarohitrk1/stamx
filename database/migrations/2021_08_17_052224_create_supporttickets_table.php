<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupportticketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
    {
        Schema::create('supporttickets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('submitted_to_id');   
            $table->unsignedBigInteger('user_id');   
            $table->Integer('category_id')->default(1);  
            $table->text('subject')->nullable(); 
            $table->enum('status', ['New','Closed','Customer Reply','Support Reply'])->default('New')->comment('Support status types');
            $table->string('ticket')->nullable();
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
        Schema::dropIfExists('supporttickets');
    }
}
