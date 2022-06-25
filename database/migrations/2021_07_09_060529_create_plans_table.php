<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'plans', function (Blueprint $table){
            $table->id(); 
            $table->string('name', 100)->unique();
            $table->float('price')->default(0);
            $table->string('duration', 100);
            $table->text('description')->nullable();
			 $table->float('weekly_price')->default(0);
            $table->float('monthly_price')->default(0);
            $table->float('annually_price')->default(0);
            $table->float('setup_fee')->default(0);
			   $table->string('status',255)->nullable();
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
        Schema::dropIfExists('plans');
    }
}
