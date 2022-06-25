<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         if (!Schema::hasTable('books')) { 
        Schema::create('books', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->string('custom_url');
            $table->string('title');
            $table->enum('status', ['Published', 'Unpublished']);
            $table->integer('category');
            $table->text('description',65535);
            $table->string('image',255);
            $table->string('buylink',255);
            $table->string('itunes_link', 255)->nullable();
            $table->string('youtube');
            $table->enum('show_video', ['Yes', 'No']);
            $table->integer('slider')->nullable(); 
            $table->integer('trending')->default(0);
            $table->integer('featured')->nullable();
            $table->integer('favourite_read')->nullable();
             $table->float('price')->nullable();
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
        Schema::dropIfExists('books');
    }
}
