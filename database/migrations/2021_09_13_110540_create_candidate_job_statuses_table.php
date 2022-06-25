<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCandidateJobStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candidate_job_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('candidate_id')->nullable();
            $table->string('jobpost')->nullable();
            $table->string('status')->nullable();
            $table->string('reviews')->nullable();
            $table->string('current_stage')->nullable();
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
        Schema::dropIfExists('candidate_job_statuses');
    }
}
