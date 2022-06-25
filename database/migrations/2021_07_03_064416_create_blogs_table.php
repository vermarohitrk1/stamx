<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         if (!Schema::hasTable('blogs')) { 
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
             $table->integer('domain_id')->default(0);
             $table->string('title',255)->nullable();
             $table->integer('category')->default(0);
             $table->enum('status',['Published','Unpublished'])->default('Published');
               $table->text('article')->nullable();
               $table->string('image',255)->nullable();
               $table->string('video',255)->nullable();
               $table->string('tags',255)->nullable();
               $table->string('expiry_status',255)->nullable();
               $table->date('expiry_date')->nullable();
               $table->date('prepublish_date')->nullable();
             $table->tinyInteger('dont_miss')->default(0);
                 $table->tinyInteger('editor_picked')->default(0); 
                 $table->tinyInteger('featured')->default(0); 
            $table->string('youtube',255)->nullable();
              $table->integer('view_count')->nullable();
             $table->integer('most_popular')->nullable();
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
        Schema::dropIfExists('blogs');
    }
}
