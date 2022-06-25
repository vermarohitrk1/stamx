<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamsreportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         if (!Schema::hasTable('examsreports')) { 
        Schema::create('examsreports', function (Blueprint $table) {
            $table->id();
             $table->foreignId('user')->nullable()->constrained('users')->onDelete('cascade');
            $table->integer('certify')->default(0)->nullable();
            $table->integer('exam')->default(0)->nullable();
            $table->integer('student')->default(0)->nullable();
            $table->integer('score')->default(0)->nullable();
            $table->integer('correctlyAnswered')->default(0)->nullable();
            $table->integer('totalQuestions')->default(0)->nullable();
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
        Schema::dropIfExists('examsreports');
    }
}
