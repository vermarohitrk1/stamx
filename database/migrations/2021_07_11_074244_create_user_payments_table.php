<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_payments', function (Blueprint $table) {
            $table->id();
            $table->string('order_id',255)->nullable();
            $table->string('name',255)->nullable();
            $table->string('email',255)->nullable();
            $table->string('card_number',255)->nullable();
            $table->string('card_exp_month',255)->nullable();
            $table->string('card_exp_year',255)->nullable();
            $table->string('entity_type',255)->nullable();
            $table->integer('entity_id')->nullable()->default(0);
            $table->integer('user_id')->nullable()->default(0);
            $table->string('title',255)->nullable();
             $table->float('amount',11,2)->nullable()->default(0);
             $table->float('discount',11,2)->nullable()->default(0);
            $table->string('status',255)->nullable();
            $table->string('price_currency',255)->nullable();
            $table->string('txn_id',255)->nullable();
            $table->string('payment_type',255)->nullable();
            $table->string('payment_status',255)->nullable();
            $table->string('receipt',255)->nullable();
            $table->text('other_description')->nullable();
             $table->integer('paid_to_user_id')->nullable()->default(0);
             $table->integer('qty')->default(1);
            
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
        Schema::dropIfExists('user_payments');
    }
}
