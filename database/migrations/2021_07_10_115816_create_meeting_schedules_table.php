<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMeetingSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meeting_schedules', function (Blueprint $table) {
            $table->id();
             $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->integer('domain_id')->default(0);
            $table->string('title',255)->nullable();
             $table->integer('service_type_id')->nullable()->default(0);
             $table->integer('service_id')->nullable()->default(0);
            $table->float('price',11,2)->nullable()->default(0);
            $table->text('price_description')->nullable();
            $table->text('description')->nullable();
             $table->enum('status',['Active','InActive'])->default('Active');
             
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
        Schema::dropIfExists('meeting_schedules');
    }
}
