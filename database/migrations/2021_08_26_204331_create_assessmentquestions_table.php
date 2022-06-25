<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssessmentquestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
    {
       Schema::create('assessmentquestions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');   
             $table->mediumInteger('form')->comment('form ID from assesment forms');  
            $table->Integer('points')->default(0);  
            $table->string('question',256)->nullable(); 
            $table->string('type',10)->nullable();    
            $table->text('options')->nullable();             
              $table->Integer('indexing')->default(0); 
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
        Schema::dropIfExists('assessmentquestions');
    }
}
