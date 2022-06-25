<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypeToPhotoboothTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('photobooth')) {
        Schema::table('photobooth', function (Blueprint $table) {
            $table->string('type',255)->nullable();
          
         
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
        Schema::table('photobooth', function (Blueprint $table) {
            //
        });
    }
}
