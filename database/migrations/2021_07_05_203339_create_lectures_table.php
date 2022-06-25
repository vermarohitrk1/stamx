<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLecturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         if (!Schema::hasTable('lectures')) { 
        Schema::create('lectures', function (Blueprint $table) {
            $table->id();
            $table->string('title',255)->nullable();
            $table->text('content')->nullable();
            $table->enum('type',['pdf','link','text','downloads','video','aws_audio','aws_video','scorm'])->nullable();
            
            $table->text('description')->nullable();
            $table->text('scorm_provider')->nullable();
            $table->integer('indexing')->nullable()->default(0);
            $table->integer('certify')->nullable()->default(0);
            $table->integer('chapter')->nullable()->default(0);
            
            $table->timestamps();
        });
    }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lectures');
    }
}
