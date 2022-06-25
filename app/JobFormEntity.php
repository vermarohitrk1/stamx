<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class JobFormEntity
 * @package App
 */
class JobFormEntity extends Model
{
    const BASIC_INFO_SLUG = "basic_information";
    const CONTACT_DETAILS_SLUG = "contact_details";
    const EDU_EXP_SLUG = "education_experience";
    const QUESTION_SLUG = "questions";
    const ASSIGNMENT_SLUG = "assignment";
    const RESUME_SLUG = "resume_upload";
    const DEFAULT_JOB_ID = 0;

    const FIELD_GROUP_ACTION = [
        self::BASIC_INFO_SLUG => "view",
        self::CONTACT_DETAILS_SLUG => "edit",
        self::EDU_EXP_SLUG => "edit",
        self::QUESTION_SLUG => "edit",
        self::ASSIGNMENT_SLUG => "edit",
        self::RESUME_SLUG => "no_action"
    ];

    /**
     * @var string[]
     */
    protected $fillable = [
        'label',
        'status',
        'is_deletable',
        'job_id',
        'user_id',
        'slug',
        'icon'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function jobFormField(){
        return $this->hasMany(JobFormField::class, "form_id", "id");
    }

    /**
     * @return string
     */
    public function getAllFieldsLabel($job_id = ""){
        $allFormField = $this->jobFormField()->whereIn('job_id', [$job_id, self::DEFAULT_JOB_ID])->get();
        $allLabel = [];
        if(!empty($allFormField)){
            foreach ($allFormField as $_field){
                $required = ($_field->is_required == 1) ? "<sup>*</sup>" : "";
                $allLabel[] = $_field->label." ".$required;
            }
        }
        return implode(", ",$allLabel);
    }

    /**
     * @return string
     */
    public function getAction($jobpost_id = "")
    {

        $actionType = self::FIELD_GROUP_ACTION[$this->slug] ?? "";

        switch ($actionType){
            case "view":
                $action = '<a href="javascript:void(0)" class="text-muted default-base-color width-30 height-30 rounded d-inline-flex align-items-center justify-content-center action-view-button" data-url="'.route('basicinfo', ['id' => $this->id ]).'" data-ajax-popup="true" data-size="lg" data-title="'.$this->label.'" data-id="'.$this->id.'"><i class="fa fa-eye" aria-hidden="true"></i></a>';
                break;
            case "no_action":
                $action = '';
                break;
            default:
                $action = '<a href="javascript:void(0)" class="text-muted default-base-color width-30 height-30 rounded d-inline-flex align-items-center justify-content-center action-edit-button" data-id="'.$this->id.'" data-job-id="'.$jobpost_id.'"><i class="fas fa-edit"></i></a>';
                break;
        }
        return $action;
    }

    public function makeSlug($value)
    {
        return $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $value)));
    }
}
