<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         if (!Schema::hasTable('exams')) { 
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
              $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
                 $table->integer('certify')->nullable()->default(0);
            $table->string('name',255)->nullable();
                 $table->integer('retakes')->nullable()->default(0);
            $table->string('description',255)->nullable();
              $table->enum('status',['Published','Unpublished'])->default('Unpublished');
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
        Schema::dropIfExists('exams');
    }
}
