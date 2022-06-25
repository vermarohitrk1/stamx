<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductAttributeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('product_attribute')) {
        Schema::create('product_attribute', function (Blueprint $table) {
             $table->bigIncrements('id');
            $table->integer('user_id');
             $table->string('title')->nullable();
              $table->enum('status', ['Active','Inactive'])->default('Active'); 
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
        Schema::dropIfExists('product_attribute');
    }
}
