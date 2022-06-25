<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssessmentformsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
    {
       Schema::create('assessmentforms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');           
            $table->string('title',256)->nullable();    
            $table->string('type',10)->nullable();    
            $table->decimal('amount',11,2)->default('0.00'); 
            $table->enum('amount_status', ['0','1'])->default('0')->comment('0->unpaid 1->paid');
            $table->text('description')->nullable();             
             $table->Integer('category')->default(1)->comment('1= Un-Categorized, from assesment categories');  
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
        Schema::dropIfExists('assessmentforms');
    }
}
