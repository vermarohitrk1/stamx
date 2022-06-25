<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldToPathways extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('school', 'college','mentor_type', 'catalog','branch', 'trade_category','employee', 'discharged'))
        {
        Schema::table('pathways', function (Blueprint $table) {
           
            $table->string('school',255)->nullable();;
            $table->string('college',255)->nullable();;
            $table->string('mentor_type',255)->nullable();;
            $table->string('catalog',255)->nullable();;
            $table->string('branch',255)->nullable();;
            $table->string('trade_category',255);
            $table->string('employee',255)->nullable();;
            $table->enum('discharged', ['Yes', 'No',NULL]);
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
        Schema::table('pathways', function (Blueprint $table) {
            //
        });
    }
}
