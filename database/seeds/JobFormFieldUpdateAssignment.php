<?php

use App\JobFormEntity;
use App\JobFormField;
use Illuminate\Database\Seeder;

class JobFormFieldUpdateAssignment extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $JobFormEntity = new JobFormEntity();
        $assignmentData = $JobFormEntity->where('slug', JobFormEntity::ASSIGNMENT_SLUG)->first();
        $assignmentFieldData = $assignmentData->jobFormField()->first();
        $assignmentFieldData->type = JobFormField::ENUM_TEXTAREA;
        $assignmentFieldData->save();
    }
}
