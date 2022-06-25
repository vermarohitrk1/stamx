<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChoreComments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         if (Schema::hasTable('chore_comments')) {
          Schema::dropIfExists('chore_comments');
        }
     
        Schema::create('chore_comments', function (Blueprint $table) {
                $table->id();
            $table->integer('chore_id')->nullable();
            $table->integer('created_by')->nullable();
            $table->string('comment')->nullable();
            $table->string('user_type')->nullable();
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
        Schema::dropIfExists('chore_comments');
    }
}