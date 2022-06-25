<?php

use App\JobFormEntity;
use App\JobFormOption;
use Illuminate\Database\Seeder;

class GenderFieldOptionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jobFormFiled = \App\JobFormField::where('label', 'Gender')->first();
        $data = [
            [
                'field_id' => $jobFormFiled->id,
                'label' => 'Male',
            ],
            [
                'field_id' => $jobFormFiled->id,
                'label' => 'Female',
            ],
            [
                'field_id' => $jobFormFiled->id,
                'label' => 'Other',
            ],
        ];
        foreach ($data as $_data){
            JobFormOption::create($_data);
        }
    }
}
