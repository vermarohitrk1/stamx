<?php

use App\JobFormField;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeEnumValueToJobFormFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       DB::statement("ALTER TABLE `job_form_fields` MODIFY COLUMN type ENUM('text', 'email', 'number', 'textarea', 'date', 'radio', 'checkbox', 'select', 'file')");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE `job_form_fields` CHANGE `type` `type` ENUM('text', 'email', 'number', 'textarea', 'date', 'radio', 'checkbox', 'select')");
    }
}
