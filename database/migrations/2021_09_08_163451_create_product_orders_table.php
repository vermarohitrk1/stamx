<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      
        Schema::create('product_orders', function (Blueprint $table) {
           $table->bigIncrements('id');
            $table->string('order_id', 100)->unique();
            $table->string('name', 255)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('card_number', 15)->nullable();
            $table->string('card_exp_month', 10)->nullable();
            $table->string('card_exp_year', 10)->nullable();
            $table->string('product_name', 100);
            $table->Integer('product_id');
            $table->decimal('amount',11,2);
            $table->string('price_currency', 10);
            $table->string('txn_id', 100);
            $table->string('payment_type', 100);
            $table->string('payment_status', 100);
            $table->string('receipt')->nullable();
            $table->enum('status', ['Pending','Shipped','Cancelled'])->default('Pending'); 
            $table->integer('user_id')->default(0);
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
        Schema::dropIfExists('product_orders');
    }
}
