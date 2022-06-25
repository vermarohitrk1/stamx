<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCertifyChaptersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('certify_chapters')) { 
        Schema::create('certify_chapters', function (Blueprint $table) {
            $table->id();
             $table->foreignId('certify')->nullable()->constrained('certifies')->onDelete('cascade');
            $table->string('title',255)->nullable();
            $table->text('description')->nullable();
            $table->string('type',255)->nullable();
            $table->integer('indexing')->nullable()->default(0);
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
        Schema::dropIfExists('certify_chapters');
    }
}
