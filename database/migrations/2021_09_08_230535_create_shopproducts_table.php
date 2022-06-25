<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopproductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         if (!Schema::hasTable('shopproducts')) {
        Schema::create('shopproducts', function (Blueprint $table) {
             $table->bigIncrements('id');
            $table->integer('user_id');
            $table->string('title');
            $table->string('sku');
               $table->enum('status', ['Published','Unpublished'])->default('Published');               
            $table->string('image');
             $table->decimal('price',11,2);
             $table->decimal('special_price',11,2);
               $table->integer('quantity');
               $table->integer('stock_status');                            
            $table->string('type');                
               $table->integer('category_id');            
            $table->string('tags');                             
               $table->integer('free');       
            $table->string('description');
            $table->string('vendor');
            $table->text('refund_disclaimer');
            $table->string('shipping_options');    
               $table->integer('brand');   
                 $table->tinyInteger('rating')->default(0);
             $table->Integer('current_deal_off')->default(0);
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
        Schema::dropIfExists('shopproducts');
    }
}
