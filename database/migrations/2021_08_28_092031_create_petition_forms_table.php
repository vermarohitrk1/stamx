<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePetitionFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
    {
        Schema::create('petition_forms', function (Blueprint $table) {
                   $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');           
            $table->string('title',256)->nullable();    
             $table->text('description')->nullable(); 
             $table->integer('target')->nullable();
             $table->date('end_date')->nullable();
             $table->text('agreements_url')->nullable();             
             $table->text('redirect_url')->nullable();             
             $table->Integer('folder_id')->nullable()->comment('crm folder id');  
              $table->enum('status', ['Published','Unpublished'])->default('Published');
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
        Schema::dropIfExists('petition_forms');
    }
}
