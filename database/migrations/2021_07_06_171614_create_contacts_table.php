<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         if (!Schema::hasTable('contacts')) { 
        Schema::create('contacts', function (Blueprint $table) {
              $table->bigIncrements('id');
            $table->string('type',255)->nullable();
            $table->string('fullname',255)->nullable();
            $table->enum('contact_us', array('Yes','No'))->nullable();
            $table->string('message',255)->nullable();
            $table->string('fname',255)->nullable();
            $table->string('lname',255)->nullable();
            $table->string('email',255)->nullable();
            $table->string('phone',255)->nullable();
            $table->string('folder')->nullable();
            $table->enum('sms', array('Yes','No'))->nullable();
            $table->integer('user_id')->nullable();
            $table->string('url',255)->nullable();
             $table->string('avatar',255)->nullable();
             $table->integer('domain_id')->nullable()->default(0);
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
        Schema::dropIfExists('contacts');
    }
}
