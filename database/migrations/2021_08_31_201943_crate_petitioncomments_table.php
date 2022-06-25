<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CratePetitioncommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('petition_comments', function (Blueprint $table) {
                   $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');           
            $table->unsignedBigInteger('petition_id');   
             $table->text('comment')->nullable(); 
             $table->text('status')->nullable(); 
             $table->text('display')->nullable();
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
        Schema::dropIfExists('petition_comments');
    }
}
