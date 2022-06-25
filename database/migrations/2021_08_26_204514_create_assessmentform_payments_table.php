<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssessmentformPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assessmentformpayments', function (Blueprint $table) {
                   $table->bigIncrements('id');
            $table->string('order_id', 100)->unique();
            $table->string('name', 255)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('card_number', 15)->nullable();
            $table->string('card_exp_month', 10)->nullable();
            $table->string('card_exp_year', 10)->nullable();
            $table->string('form_title', 100)->nullable();
            $table->Integer('form_id');
            $table->decimal('amount',11,2);
            $table->string('price_currency', 10);
            $table->string('txn_id', 100)->nullable();
            $table->string('payment_type', 100)->nullable();
            $table->string('payment_status', 100)->nullable();
            $table->string('receipt')->nullable();
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
        Schema::dropIfExists('assessmentformpayments');
    }
}
