<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PublicPageDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('public_page_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('public_title');
            $table->text('public_subtitle')->nullable();
            $table->text('image')->nullable();
            $table->text('bgimage')->nullable();
            $table->bigInteger('user_id');
            $table->string('url');
            $table->string('custom_url')->nullable();
            $table->string('type');
            $table->text('donation_form_data')->nullable();
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
        Schema::dropIfExists('public_page_details');
    }
}
