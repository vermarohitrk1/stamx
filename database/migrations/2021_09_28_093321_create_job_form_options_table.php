<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobFormOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_form_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('field_id')->constrained('job_form_fields')->onUpdate('cascade')->onDelete('cascade');
            $table->string('label');
            $table->boolean('status')->default(1);
            $table->integer('sorting')->default(0);
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
        Schema::dropIfExists('job_form_options');
    }
}
