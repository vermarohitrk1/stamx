<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFrameToPhotoboothcountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('photoboothsharecount', function (Blueprint $table) {

            $table->integer('frame_id')->nullable()->default(null);
         
        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('photoboothcount', function (Blueprint $table) {
            //
        });
    }
}
