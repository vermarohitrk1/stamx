<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToProductOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_orders', function (Blueprint $table) {
            $table->string('customer_id')->nullable()->default(null);
            $table->string('cart_id')->nullable()->default(null);
            $table->string('order_note')->nullable()->default(null);
            $table->string('order_description')->nullable()->default(null);
            $table->integer('qty')->default(0);
            $table->decimal('discount',11,2)->default(0.00);
            $table->string('transfer_id')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_orders', function (Blueprint $table) {
            //
        });
    }
}
