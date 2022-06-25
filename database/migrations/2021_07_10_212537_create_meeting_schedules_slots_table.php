<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMeetingSchedulesSlotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meeting_schedules_slots', function (Blueprint $table) {
            $table->id();
             $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->integer('domain_id')->default(0);
             $table->integer('meeting_schedule_id')->nullable()->default(0);
             $table->date('date')->nullable();
             $table->time('start_time')->nullable();
             $table->time('end_time')->nullable();
             $table->tinyInteger('is_accomplished')->nullable()->default(0);
            $table->float('price',11,2)->nullable()->default(0);
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
        Schema::dropIfExists('meeting_schedules_slots');
    }
}
