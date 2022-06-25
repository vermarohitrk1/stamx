<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table){
			$table->id();
			$table->integer('user_id')->default(0);
			$table->string('parent_id')->nullable();
			$table->string('order_id', 100)->unique();
			$table->string('name', 100)->nullable();
			$table->string('email', 100)->nullable();
			$table->string('card_number', 10)->nullable();
			$table->string('card_exp_month', 10)->nullable();
			$table->string('card_exp_year', 10)->nullable();
			$table->string('plan_name', 100);
			$table->integer('plan_id');
			$table->string('type')->nullable();
			$table->float('price');
			$table->string('price_currency', 10);
			$table->string('txn_id', 100);
			$table->string('payment_type', 100);
			$table->string('payment_status', 100);
			$table->string('customer_id')->nullable();
			$table->string('status')->nullable();
			$table->string('receipt')->nullable();
			$table->timestamps();
        }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
