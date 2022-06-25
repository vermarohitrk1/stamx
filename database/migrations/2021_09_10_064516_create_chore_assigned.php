<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChoreAssigned extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('chore_assigned')) {
          Schema::dropIfExists('chore_assigned');
        }
        Schema::create('chore_assigned', function (Blueprint $table) {
             $table->id();
            $table->integer('user_id')->nullable();
            $table->integer('chore_id')->nullable();
            $table->date('date')->nullable();
            $table->tinyInteger('is_completed')->default(0);
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
        Schema::dropIfExists('chore_assigned');
    }
}
