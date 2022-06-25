<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChoreMembers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
          if (Schema::hasTable('chore_members')) {
          Schema::dropIfExists('chore_members');
        }
        Schema::create('chore_members', function (Blueprint $table) {
              $table->bigIncrements('id');
        $table->unsignedInteger('user_id');
        $table->unsignedInteger('created_by');
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
        Schema::dropIfExists('chore_members');
    }
}
