<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFaqssettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('faqssettings', function (Blueprint $table) {
            $table->IntegerIncrements('id'); 
            $table->unsignedBigInteger('user_id');             
            $table->text('url')->nullable(); 
            $table->text('website')->nullable(); 
            $table->text('title')->nullable(); 
            $table->text('subtitle')->nullable();    
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
        Schema::dropIfExists('faqssettings');
    }
}
