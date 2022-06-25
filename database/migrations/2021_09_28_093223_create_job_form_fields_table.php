<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\JobFormField;

class CreateJobFormFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('job_form_fields', function (Blueprint $table) {
            $jobFormField = new JobFormField();
            $table->id();
            $table->foreignId('form_id')->constrained('job_form_entities')->onUpdate('cascade')->onDelete('cascade');
            $table->string('label');
            $table->boolean('status')->default(1);
            $table->enum('type', $jobFormField->getEnumType());
            $table->boolean('is_required')->default(0);
            $table->boolean('is_deletable')->default(1);
            $table->boolean('have_option')->default(0);
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
        Schema::dropIfExists('job_form_fields');
    }
}
