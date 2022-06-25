<?php

use Illuminate\Database\Seeder;
use App\JobFormEntity;
use App\JobFormField;

class JobFormEntitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jobFormEntityData = [
            [
                'label' => 'Basic Information',
                'is_deletable' => 0,
                'is_addable' => 0,
                'icon' => '<i class="fas fa-user"></i>',
                'slug' => JobFormEntity::BASIC_INFO_SLUG,
                "job_form" => [
                    [
                        "label" => "First Name",
                        "type" => "text",
                        "is_required" => 1,
                        "is_deletable" => 0
                    ],
                    [
                        "label" => "Last Name",
                        "type" => "text",
                        "is_required" => 1,
                        "is_deletable" => 0
                    ],
                    [
                        "label" => "Email",
                        "type" => "email",
                        "is_required" => 1,
                        "is_deletable" => 0
                    ],
                    [
                        "label" => "Gender",
                        "type" => "radio",
                        "is_required" => 1,
                        "is_deletable" => 0
                    ],
                    [
                        "label" => "Date of birth",
                        "type" => "date",
                        "is_required" => 0,
                        "is_deletable" => 0
                    ],
                ],
            ],
            [
                'label' => 'Contact Details',
                'is_deletable' => 0,
                'is_addable' => 1,
                'icon' => '<i class="fas fa-globe"></i>',
                'slug' => JobFormEntity::CONTACT_DETAILS_SLUG,
                "job_form" => [
                    [
                        "label" => "Phone",
                        "type" => "text",
                        "is_required" => 0,
                        "is_deletable" => 1
                    ],
                    [
                        "label" => "Address",
                        "type" => "textarea",
                        "is_required" => 0,
                        "is_deletable" => 1
                    ],
                    [
                        "label" => "Linkedin",
                        "type" => "text",
                        "is_required" => 0,
                        "is_deletable" => 1
                    ],
                    [
                        "label" => "Twitter",
                        "type" => "text",
                        "is_required" => 0,
                        "is_deletable" => 1
                    ],
                ],
            ],
            [
                'label' => 'Education & Experience',
                'is_deletable' => 0,
                'is_addable' => 1,
                'icon' => '<i class="fas fa-bookmark"></i>',
                'slug' => JobFormEntity::EDU_EXP_SLUG,
                "job_form" => [
                    [
                        "label" => "Education",
                        "type" => "text",
                        "is_required" => 0,
                        "is_deletable" => 1
                    ],
                    [
                        "label" => "Work experience",
                        "type" => "text",
                        "is_required" => 0,
                        "is_deletable" => 1
                    ],
                ],
            ],
            [
                'label' => 'Questions',
                'is_deletable' => 0,
                'is_addable' => 1,
                'icon' => '<i class="fas fa-pencil-alt"></i>',
                'slug' => JobFormEntity::QUESTION_SLUG,
                "job_form" => [
                    [
                        "label" => "Write something about you...",
                        "type" => "text",
                        "is_required" => 0,
                        "is_deletable" => 1
                    ],
                    [
                        "label" => "Why you think you are good for this job?",
                        "type" => "text",
                        "is_required" => 0,
                        "is_deletable" => 1
                    ],
                ],
            ],
            [
                'label' => 'Assignment',
                'is_deletable' => 0,
                'is_addable' => 0,
                'icon' => '<i class="fas fa-file-alt"></i>',
                'slug' => JobFormEntity::ASSIGNMENT_SLUG,
                "job_form" => [
                    [
                        "label" => "Write your assignment question",
                        "type" => "text",
                        "is_required" => 0,
                        "is_deletable" => 0
                    ],
                ],
            ],
            [
                'label' => 'Resume Upload',
                'is_deletable' => 0,
                'is_addable' => 0,
                'icon' => '<i class="fas fa-paperclip"></i>',
                'slug' => JobFormEntity::RESUME_SLUG,
                "job_form" => [
                    [
                        "label" => "Upload your resume here",
                        "type" => "file",
                        "is_required" => 0,
                        "is_deletable" => 0
                    ],
                ],
            ],
        ];

        foreach($jobFormEntityData as $data){
            $jobEntityData = [];
            $jobEntityData['label'] = $data['label'];
            $jobEntityData['icon'] = $data['icon'];
            $jobEntityData['is_deletable'] = $data['is_deletable'];
            $jobEntityData['is_addable'] = $data['is_addable'];
            $jobEntityData['slug'] = $data['slug'];
            $jobEntityModel = JobFormEntity::create($jobEntityData);
            if(isset($data['job_form'])) {
                foreach ($data['job_form'] as $jobFormData) {
                    $jobFormData['form_id'] = $jobEntityModel->id;
                    JobFormField::create($jobFormData);
                }
            }
        }
    }
}
