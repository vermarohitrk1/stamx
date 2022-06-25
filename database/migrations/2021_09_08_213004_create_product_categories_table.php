<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         if (!Schema::hasTable('product_category_types')) {
        Schema::create('product_category_types', function (Blueprint $table) {
             $table->bigIncrements('id');
            $table->integer('user_id');
            $table->string('name');
               $table->enum('status', ['Published','Unpublished'])->default('Published');
               $table->integer('parent_id')->nullable();
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
        Schema::dropIfExists('product_category_types');
    }
}
