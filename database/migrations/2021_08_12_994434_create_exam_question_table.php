<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamQuestionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

                
        Schema::create('courses_questions', function (Blueprint $table) {
		$table->id();
		$table->integer('examid');
		$table->string('question',256);
		$table->string('answers');
		$table->string('correct')->nullable();
		$table->integer('indexing');
		$table->enum('required',['yes','no']);
		$table->enum('type',['multiple','single']);
		$table->timestamps();
    }
	);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
     public function down()
    {
        Schema::dropIfExists('courses_questions');
    }
}
