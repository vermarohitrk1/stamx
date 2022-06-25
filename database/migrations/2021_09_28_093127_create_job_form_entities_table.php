<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobFormEntitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_form_entities', function (Blueprint $table) {
            $table->id();
            $table->string('label');
            $table->boolean('status')->default(1);
            $table->boolean('is_deletable')->default(1);
            $table->boolean('is_addable')->default(1);
            $table->text('icon');
            $table->string('slug')->unique();
            $table->bigInteger('job_id')->default(0);
            $table->bigInteger('user_id')->default(0);
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
        Schema::dropIfExists('job_form_entities');
    }
}
