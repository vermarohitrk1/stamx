<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PublicDonationUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('public_donation_users', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->bigInteger('user_id');
        $table->string('stripe_customer',100);
        $table->string('custom_url',100)->nullable();
        $table->string('fname',100);
        $table->string('lname',100);
        $table->string('email',100);
        $table->string('address');
        $table->integer('state');
        $table->string('city',100);
        $table->string('zip',100);
        $table->string('country',100);
        $table->string('monthlygift',100)->nullable();
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
        Schema::dropIfExists('public_donation_users');
    }
}
