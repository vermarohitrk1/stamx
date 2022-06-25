<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstructorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         if (!Schema::hasTable('instructors')) { 
        Schema::create('instructors', function (Blueprint $table) {
            $table->id();
              $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
             $table->integer('created_by')->default(0);
             $table->integer('domain_id')->default(0);
             $table->tinyInteger('is_approved')->default(0);
             $table->tinyInteger('is_verified')->default(0);
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
        Schema::dropIfExists('instructors');
    }
}
