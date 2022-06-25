<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWalletTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wallet_transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('from');           
            $table->unsignedBigInteger('to');   
            $table->decimal('amount',16,2)->default('0.00'); 
            $table->text('description')->nullable();  
            $table->string('entity_type',255)->nullable();    
             $table->Integer('entity_id')->default(0)->comment(' id of entity of paid against something');               
             $table->Integer('invoice_id')->default(0)->comment(' id of invoice if paid');               
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
        Schema::dropIfExists('wallet_transactions');
    }
}
