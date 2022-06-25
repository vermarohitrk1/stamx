<?php

use App\JobFormEntity;
use App\JobFormField;
use Illuminate\Database\Seeder;

class UpdateResumeFieldTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $resumeSection = JobFormEntity::where('slug', JobFormEntity::RESUME_SLUG)->first();
        $resumeField = $resumeSection->jobFormField()->first();
        $resumeField->type = JobFormField::ENUM_FILE;
        $resumeField->save();
    }
}
