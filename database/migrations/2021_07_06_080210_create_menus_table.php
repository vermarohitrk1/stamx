<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         if (!Schema::hasTable('menus')) { 
        Schema::create('menus', function (Blueprint $table) {
            $table->bigIncrements('id');
			 $table->integer('user_id');
			 $table->integer('orders');
            $table->string('title');
            $table->string('url');
            $table->integer('parent_id');
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
        Schema::dropIfExists('menus');
    }
}
