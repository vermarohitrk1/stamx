<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStripePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         if (!Schema::hasTable('stripe_payments')) { 
        Schema::create('stripe_payments', function (Blueprint $table) {
            $table->id();
             $table->string('enroll_key',255)->nullable();
            $table->integer('item_id')->default(0);
            $table->integer('user_id')->default(0);
             $table->string('email',255)->nullable();
             $table->string('item_type',255)->nullable();
             $table->string('item_name',255)->nullable();
             $table->integer('qty')->default(1);
              $table->float('price',11,2)->default(0);
              $table->float('total_price',11,2)->default(0);              
             $table->string('payment_key',255)->nullable();
             $table->string('completed_on',255)->nullable();
             $table->string('exp_date',255)->nullable();
             
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
        Schema::dropIfExists('stripe_payments');
    }
}
