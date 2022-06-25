<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('job_title','255')->nullable();
            $table->string('job_type','255')->nullable();
            $table->string('department','255')->nullable();
            $table->string('location','255')->nullable();
            $table->text('description')->nullable();
            $table->bigInteger('salary')->nullable();
            $table->date('last_submission')->nullable();
            $table->string('job_status','255')->nullable();
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
        Schema::dropIfExists('jobs');
    }
}
