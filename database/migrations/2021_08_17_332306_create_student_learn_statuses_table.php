<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentLearnStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_learn_statuses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('student');
            $table->integer('chapter_id');
            $table->string('study_status',255);
            $table->enum('status', ['Completed', 'Uncompleted']);
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
        Schema::dropIfExists('student_learn_statuses');
    }
}
