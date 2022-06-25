<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PublicDonationOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('public_donation_orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id');
            $table->string('custom_url',100)->nullable();
            $table->string('stripe_customer');
            $table->integer('pdonation_users_id');
            $table->string('tranaction_id',150);
            $table->string('amount',50);
            $table->string('status',50);
            $table->string('monthlygift')->nullable();
            $table->timestamp('donation_date');
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
        Schema::dropIfExists('public_donation_orders');
    }
}
