<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssessmentresponsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
    {
       Schema::create('assessmentresponses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');   
             $table->mediumInteger('form')->comment('form ID from assesment forms');  
              $table->enum('payment', ['0','1'])->default('0')->comment('0->unpaid 1->paid');   
            $table->text('response')->nullable();              
            $table->Integer('points')->default(0);  
            $table->enum('status', ['0','1'])->default('0')->comment('1->Filled 0->Not Filled'); 
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
        Schema::dropIfExists('assessmentresponses');
    }
}
