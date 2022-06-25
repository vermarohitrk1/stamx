<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChoreLinkedMembers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         if (Schema::hasTable('chore_linked_members')) {
          Schema::dropIfExists('chore_linked_members');
        }
        Schema::create('chore_linked_members', function (Blueprint $table) {
            $table->bigIncrements('id');
        $table->unsignedInteger('user_id');
        $table->unsignedInteger('chore_id');
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
        Schema::dropIfExists('chore_linked_members');
    }
}
