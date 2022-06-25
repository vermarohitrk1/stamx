<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   if (!Schema::hasTable('users')) {     
        Schema::create('users', function (Blueprint $table) {
            $table->id();            
            $table->string('email')->unique();
            $table->string('name',100);
            $table->string('type',50)->nullable();
            $table->string('nickname',50)->nullable();
            $table->string('dob',20)->nullable();
            $table->string('gender',10)->default("Male");
            $table->string('blood_group',5)->nullable();
            $table->string('mobile',25)->nullable();
            $table->string('about',2550)->nullable();
            $table->string('address1',255)->nullable();
            $table->string('address2',255)->nullable();
            $table->string('city',50)->nullable();
            $table->string('state',50)->nullable();
            $table->integer('postal_code')->nullable();
            $table->string('country',50)->nullable();
            $table->string('avatar',255)->nullable();
            $table->integer('created_by')->default(0);
            $table->integer('is_active')->default(1);
            $table->integer('login_status')->default(0);
            $table->integer('average_rating')->default(0);
            $table->integer('profile_completion_percentage')->default(0);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->text('device_token')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
