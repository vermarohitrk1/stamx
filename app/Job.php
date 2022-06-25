<?php

namespace App;
use App\JobType;
use App\Location;
use App\Department;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    const JOB_STATUS_DRAFT = "draft";
    const JOB_STATUS_ACTIVE = "active";
    const JOB_STATUS_INACTIVE = "inactive";

    /**
     * @var string[]
     */
    protected $fillable = [
        'job_title',
        'job_type',
        'department',
        'location',
        'description',
        'salary',
        'last_submission',
        'job_status'
    ];

    /**
     * @return array
     */
    public function getJobType(){
        $jobtype = JobType::select('name', 'id')->get();
        $jobOptions = [];
        $jobOptions[""] = "Choose One";
        foreach($jobtype as $type){
            $jobOptions[$type->id] = $type->name;
        }
        return $jobOptions;
    }

    /**
     * @return array
     */
    public function getLocation(){
        $locations = Location::select('address','id')->get();
        $locationOptions = [];
        $locationOptions[""]="Choose One";
        foreach($locations as $location){
            $locationOptions[$location->id] = $location->address;
        }
        return $locationOptions;
    }

    /**
     * @return array
     */
    public function getDepartment(){
        $departments = JobDepartment::select('name','id')->where("status", "Enable")->get();
        $departmentOptions = [];
        $departmentOptions[""]="Choose One";
        foreach($departments as $department){
            $departmentOptions[$department->id] = $department->name;
        }
        return $departmentOptions;
    }

    /**
     * @return string[]
     */
    public function getJobStauts(){
        return [
            self::JOB_STATUS_DRAFT => "Draft Jobs",
            self::JOB_STATUS_ACTIVE => "Active Jobs",
            self::JOB_STATUS_INACTIVE => "Inactive Jobs",
        ];
    }

    /**
     * @param $key
     * @return mixed|string
     */
    public function getJobStatusLabel($key){
        $allStatus = $this->getJobStauts();
        return $allStatus[$key] ?? "";
    }

    /**
     * @param $jobStatus
     * @return array
     */
    public function getOptionByJobStatus($jobStatus) {
        switch($jobStatus){
            case self::JOB_STATUS_DRAFT:
                $options = $this->getDraftOptions();
                break;
            case self::JOB_STATUS_ACTIVE:
                $options = $this->getActiveOptions();
                break;
            case self::JOB_STATUS_INACTIVE:
                $options = $this->getInactiveOption();
                break;
            default:
                $options = [];
                break;
        }
        return $options;
    }

    /**
     * @return array
     */
    public function getDraftOptions(){
        $options = [];
        $options[] = [
            "label" => "Edit",
            "href" => "#",
            "class" => "dropdown-item px-4 py-2",
            "attribute" => [
                "data-url" => route('jobpoint.create',['id'=> $this->id]),
                "data-ajax-popup" => "true",
                "data-size" => "lg",
            ]
        ];
        $options[] = [
            "label" => "Edit job post",
            "href" => route('jobpost.editjobpost', [encrypted_key($this->id, "encrypt")]),
            "class" => "dropdown-item px-4 py-2",
            "attribute" => []
        ];
        $options[] = [
            "label" => "Settings",
            "href" => "#",
            "class" => "dropdown-item px-4 py-2",
            "attribute" => []
        ];
        $options[] = [
            "label" => "Publish job",
            "href" => "#",
            "class" => "dropdown-item px-4 py-2 JobStatusAction",
            "attribute" => [
                "data-id" => $this->id,
            ]
        ];

        $options[] = [
            "label" => "Delete",
            "href" => "#",
            "class" => "dropdown-item px-4 py-2 delete_record_model",
            "attribute" => [
                "data-url" => route('admin.jobpoint.destroy',encrypted_key($this->id, 'encrypt')),
            ]
        ];
        return $options;
    }

    /**
     * @return array
     */
    public function getActiveOptions(){
        $options = [];
        $options[] = [
            "label" => "Preview",
            "href" => route('job.preview', ["id" => encrypted_key($this->id, 'encrypt')]),
            "class" => "dropdown-item px-4 py-2",
            "attribute" => [
                'target' => "_blank",
            ]
        ];
        $options[] = [
            "label" => "Edit",
            "href" => "#",
            "class" => "dropdown-item px-4 py-2",
            "attribute" => [
                "data-url" => route('jobpoint.create',['id'=> $this->id]),
                "data-ajax-popup" => "true",
                "data-size" => "lg",
            ]
        ];
        $options[] = [
            "label" => "Edit job post",
            "href" => route('jobpost.editjobpost', [encrypted_key($this->id, "encrypt")]),
            "class" => "dropdown-item px-4 py-2",
            "attribute" => []
        ];
        $options[] = [
            "label" => "Settings",
            "href" => route('jobpost.jobsetting', [encrypted_key($this->id, "encrypt")]),
            "class" => "dropdown-item px-4 py-2",
            "attribute" => []
        ];
        $options[] = [
            "label" => "Sharable link",
            "href" => "#",
            "class" => "dropdown-item px-4 py-2 sharableLink",
            "attribute" => [
                "data-id" => $this->id,
                "data-url" => route('job.sharablelink',["id" => encrypted_key($this->id, 'encrypt')]),
                "data-ajax-popup" => "true",
                "data-size" => "lg",
                "data-title" => 'SharableLink',
            ]
        ];
        $options[] = [
            "label" => "Deactivate",
            "href" => "#",
            "class" => "dropdown-item px-4 py-2 Deactivate",
            "attribute" => [
                "data-id" => $this->id,
            ]
        ];
        $options[] = [
            "label" => "Delete",
            "href" => "#",
            "class" => "dropdown-item px-4 py-2 delete_record_model",
            "attribute" => [
                "data-url" => route('admin.jobpoint.destroy',encrypted_key($this->id, 'encrypt')),
            ]
        ];
        return $options;
    }

    /**
     * @return array
     */
    public function getInactiveOption(){
        $options = [];
        $options[] = [
            "label" => "Edit",
            "href" => "#",
            "class" => "dropdown-item px-4 py-2",
            "attribute" => [
                "data-url" => route('jobpoint.create',['id'=> $this->id]),
                "data-ajax-popup" => "true",
                "data-size" => "lg",
            ]
        ];
        $options[] = [
            "label" => "Edit job post",
            "href" => "#",
            "class" => "dropdown-item px-4 py-2",
            "attribute" => []
        ];
        $options[] = [
            "label" => "Settings",
            "href" => "#",
            "class" => "dropdown-item px-4 py-2",
            "attribute" => []
        ];
        $options[] = [
            "label" => "Activate",
            "href" => "#",
            "class" => "dropdown-item px-4 py-2 JobStatusAction",
            "attribute" => [
                "data-id" => $this->id,
            ]
        ];
        $options[] = [
            "label" => "Delete",
            "href" => "#",
            "class" => "dropdown-item px-4 py-2 delete_record_model",
            "attribute" => [
                "data-url" => route('admin.jobpoint.destroy',encrypted_key($this->id, 'encrypt')),
            ]
        ];
        return $options;
    }

    /**
     * @param array $attribute
     * @return string
     */
    public function getCustomAttribute(array $attribute){
        $attributeHtml = "";
        foreach($attribute as $key => $value){
            $attributeHtml .= $key.'='.$value.' ';
        }
        return $attributeHtml;
    }

    /**
     * @return bool|string
     */
    public function getJobPostLogo(){
        $jobSetting = new JobSetting();
        $companyIcon = $jobSetting->loadByKey("company_icon");
        $logo = $jobSetting->getJobImage($companyIcon);
        return $logo;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function getJobPost(){
        return $this->hasOne(JobPostContent::Class);
    }

    /**
     * @return array
     */
    public function getJobStageStatus(){
        $hiringStage = Hiringstage::get();
        $jobStages = [];
        foreach ($hiringStage as $_hiring){
            $totalCount = CandidateJobStatus::where(["jobpost" => $this->id, "current_stage" => $_hiring->id])->count();
            $label = $_hiring->name;
            $jobStages[] = [
                "label" => $label,
                "count" => $totalCount,
            ];
        }
        return $jobStages;
    }

    /**
     * @return array
     */
    public function getJobStageOverview(){
        $hiringStage = Hiringstage::get();
        $overviewData = [];
        foreach ($hiringStage as $_hiring) {
            $candidateJobStatusCollection = CandidateJobStatus::where(["jobpost" => $this->id, "current_stage" => $_hiring->id]);
            $appliedCandidate = $candidateJobStatusCollection->get();
            $candidateJobIds = [];
            foreach ($appliedCandidate as $_candidateJobStatus){
                $candidateJobIds[$_candidateJobStatus->candidate_id] = $_candidateJobStatus->id;
            }
            $candidate = Candidate::select("first_name", "last_name", "email", "id")->whereIn("id", $candidateJobStatusCollection->pluck("candidate_id"))->get();
            $overviewData[] = [
                "label" => $_hiring->name,
                "count" => $candidate->count(),
                "candidates" => $this->getCandidateDetails($candidate, $candidateJobIds),
            ];
        }
        return $overviewData;
    }

    /**
     * @return mixed
     */
    public function getJobCandidates(){
        $jobCandidateCollection = CandidateJobStatus::where(["jobpost" => $this->id]);
        $job = new Job();
        $candidateModel = new Candidate();
        $appliedCandidate = $jobCandidateCollection->get();
        $allCandidateDetails = [];
        foreach ($appliedCandidate as $_candidateJobStatus){
            $allCandidateDetails[$_candidateJobStatus->candidate_id] = $_candidateJobStatus->toArray();
        }
        $allCandidate = Candidate::whereIn($candidateModel->getTable().".id", $jobCandidateCollection->pluck("candidate_id"))
            ->leftJoin($job->getTable(), $candidateModel->getTable() . '.jobpost', '=', $job->getTable() . '.id')
            ->select($candidateModel->getTable() . '.*', $job->getTable() . '.job_title as job_name')->get();
        return [
            "all_candidate" => $allCandidate,
            "candidate_job_details" => $allCandidateDetails,
        ];
    }

    /**
     * @param $candidates
     * @return array
     */
    public function getCandidateDetails($candidates, $candidateJobIds){
        $candidateDetails = [];
        /**
         * @var Candidate $_candidates
         */
        foreach ($candidates as $_candidates){
            $candidateDetails[] = [
                "short_name" => $_candidates->getCandidateShortName(),
                "id" => $_candidates->id,
                "name" => $_candidates->first_name." ".$_candidates->last_name,
                "email" => $_candidates->email,
                "candidate_job_status_id" => $candidateJobIds[$_candidates->id] ?? 0,
            ];
        }
        return $candidateDetails;
    }

    /**
     * @return array
     */
    public function getPageStylingData(){
        $availableStyles = [];
        $availableStyles[] = [
            "label" => "Title",
            "font_size_class" => "titleFontSize",
            "font_size_value" => 50,
            "font_weight_class" => "titleFontWeight",
            "font_weight_value" => 700,
            "font_letter_spacing_class" => "titleFontLetterSpacing",
            "font_letter_spacing_value" => 1,
            "font_color_class" => "titleFontColor",
            "font_color_value" => "#000",
        ];
        $availableStyles[] = [
            "label" => "Subtitle",
            "font_size_class" => "subtitleFontSize",
            "font_size_value" => 30,
            "font_weight_class" => "subtitleFontWeight",
            "font_weight_value" => 300,
            "font_letter_spacing_class" => "subtitleFontLetterSpacing",
            "font_letter_spacing_value" => 1,
            "font_color_class" => "subtitleFontColor",
            "font_color_value" => "#000",
        ];
        $availableStyles[] = [
            "label" => "Details",
            "font_size_class" => "detailsFontSize",
            "font_size_value" => 20,
            "font_weight_class" => "detailsFontWeight",
            "font_weight_value" => 300,
            "font_letter_spacing_class" => "detailsFontLetterSpacing",
            "font_letter_spacing_value" => 1,
            "font_color_class" => "detailsFontColor",
            "font_color_value" => "#000",
        ];
        $availableStyles[] = [
            "label" => "Headings",
            "font_size_class" => "headingFontSize",
            "font_size_value" => 27,
            "font_weight_class" => "headingFontWeight",
            "font_weight_value" => 600,
            "font_letter_spacing_class" => "headingFontLetterSpacing",
            "font_letter_spacing_value" => 0,
            "font_color_class" => "headingFontColor",
            "font_color_value" => "#000",
        ];
        $availableStyles[] = [
            "label" => "Description",
            "font_size_class" => "desFontSize",
            "font_size_value" => 19,
            "font_weight_class" => "desFontWeight",
            "font_weight_value" => 300,
            "font_letter_spacing_class" => "desFontLetterSpacing",
            "font_letter_spacing_value" => 0,
            "font_color_class" => "desFontColor",
            "font_color_value" => "#000",
        ];
        return $availableStyles;
    }
}
