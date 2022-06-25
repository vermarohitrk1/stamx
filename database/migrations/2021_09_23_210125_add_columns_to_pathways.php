<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToPathways extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pathways', function (Blueprint $table) {
            $table->string('wifi')->nullable();
            $table->string('library')->nullable();
               $table->string('home_pc')->nullable();
               $table->string('stem_industry')->nullable();
               $table->string('reading_club')->nullable();
               $table->string('pha_community')->nullable();
               $table->string('pha_community_id')->nullable();
               $table->string('company')->nullable();
               $table->string('tax_exempted')->nullable();
               $table->string('tax_certificate')->nullable();
               $table->string('business_year')->nullable();
               $table->string('grant_opportunity')->nullable();
               $table->string('mayor')->nullable();
               $table->string('military_base')->nullable();
               $table->string('probation_parole')->nullable();
               $table->string('justice_officer')->nullable();
               $table->string('sex_offender')->nullable();
               $table->string('expungement')->nullable();
              $table->integer('graduation_year')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pathways', function (Blueprint $table) {
            Schema::dropIfExists('pathways');
        });
    }
}
