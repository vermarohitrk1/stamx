<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactFoldersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         if (!Schema::hasTable('contact_folders')) { 
        Schema::create('contact_folders', function (Blueprint $table) {
              $table->bigIncrements('id');
            $table->integer('user_id')->nullable();
            $table->integer('domain_id')->nullable();
            $table->string('name')->nullable();
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
        Schema::dropIfExists('contact_folders');
    }
}
