<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSyndicatepaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         if (!Schema::hasTable('syndicatepayments')) { 
        Schema::create('syndicatepayments', function (Blueprint $table) {
            $table->id();
             $table->integer('owner')->nullable()->default(0);
             $table->integer('certify')->nullable()->default(0);
              $table->float('amount',11,2)->nullable()->default(0);
               $table->integer('buyer')->nullable()->default(0);
                $table->float('owner_share',11,2)->nullable()->default(0);
                $table->float('promoter_share',11,2)->nullable()->default(0);
                $table->float('admin_share',11,2)->nullable()->default(0);
               $table->integer('promoter')->nullable()->default(0);
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
        Schema::dropIfExists('syndicatepayments');
    }
}
