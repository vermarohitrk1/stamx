<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCorporateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('corporate_coupons', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user');
            $table->integer('certify');
            $table->integer('redeemer');
            $table->string('coupon',255);
            $table->string('status',255);
            $table->decimal('price_limit',11,2);
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
        Schema::dropIfExists('corporate_coupons');
    }
}
