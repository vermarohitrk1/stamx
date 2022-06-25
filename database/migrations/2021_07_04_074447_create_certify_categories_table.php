<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCertifyCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         if (!Schema::hasTable('certify_categories')) { 
        Schema::create('certify_categories', function (Blueprint $table) {
            $table->id();
              $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('name',255)->nullable();
            $table->string('icon',255)->nullable();
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
        Schema::dropIfExists('certify_categories');
    }
}
