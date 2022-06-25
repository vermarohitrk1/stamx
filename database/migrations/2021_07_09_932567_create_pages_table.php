<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('custom_url')->default('publicitystunt');
            $table->string('slug');
            $table->string('page_name',255)->collation('utf8_unicode_ci');
            $table->string('image',255)->nullable();
            $table->text('page_data', 65535)->collation('utf8_unicode_ci');
            $table->enum('status', ['Published', 'Unpublished']);
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
        Schema::dropIfExists('pages');
    }
}
