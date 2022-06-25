<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         if (!Schema::hasTable('blog_categories')) { 
        Schema::create('blog_categories', function (Blueprint $table) {
            $table->id();
                 $table->string('name',255)->nullable();
               $table->string('icon',255)->nullable();
                  $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
                 $table->tinyInteger('featured')->default(0); 
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
        Schema::dropIfExists('blog_categories');
    }
}
