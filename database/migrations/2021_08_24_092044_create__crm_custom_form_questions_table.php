<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrmCustomFormQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crm_custom_form_questions', function (Blueprint $table) {
              $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');   
             $table->mediumInteger('form_id')->comment('form ID from crm custom forms');  
           $table->string('question',256)->nullable(); 
            $table->string('type',10)->nullable();    
            $table->text('options')->nullable();             
            $table->text('resource_url')->nullable();             
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
        Schema::dropIfExists('crm_custom_form_questions');
    }
}
