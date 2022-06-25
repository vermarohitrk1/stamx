<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToPetitionFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('petition_forms', function (Blueprint $table) {
              $table->text('tags')->nullable();   
              $table->text('alert')->nullable();   
              $table->text('image')->nullable();   
                $table->integer('dummy')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('petition_forms', function (Blueprint $table) {
            //
        });
    }
}
