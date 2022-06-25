<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    const TYPE_SINGLE = "Single";
    const TYPE_MULTIPLE = "Multi";
    const JOB_STATUS_NEW = "New";
    const JOB_STATUS_PROGRESS = "In progress";
    const JOB_STATUS_HIRED = "Hired";
    const DEFAULT_REVIEW = "0";
    const DEFAULT_CURRENT_STAGE = 1;

    const JOB_POST = [
        'Laravel Developer' => 'Laravel Developer',
        'PHP Developer' => 'PHP Developer',
        'Magento Developer' => 'Magento Developer',
        'React Developer' => 'React Developer',
        'Java Developer' => 'Java Developer',
    ];

    /**
     * @var string[]
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'gender',
        'dob',
        'jobpost',
        'status',
        'reviews',
        'current_stage',
        'job_application',
    ];

    /**
     * @return array
     */
    public function getJobPost($id = '')
    {
        $candidate_id = !empty($id) ? encrypted_key($id, "decrypt") : '';
        $candidateJobs = [];
        $todayDate = date('Y-m-d');
        if(!empty($candidate_id)){
            $candidateJobs = CandidateJobStatus::select('jobpost')->where('candidate_id', $candidate_id)->pluck('jobpost')->all();
        }
        $jobType = Job::where([["job_status", '=', Job::JOB_STATUS_ACTIVE], ['last_submission', '>=', $todayDate]])->get();
        $jobOptions[""] = "Choose One";
        foreach ($jobType as $type) {
            if(!empty($candidateJobs) && in_array($type->id, $candidateJobs)){
                continue;
            }
            $jobOptions[$type->id] = $type->job_title;
        }
        return $jobOptions;
    }

    /**
     * @return mixed
     */
    public function getAllJobs(){
        $jobType = Job::all();
        $jobOptions[""] = "Choose One";
        foreach ($jobType as $type) {
            $jobOptions[$type->id] = $type->job_title;
        }
        return $jobOptions;
    }

    /**
     * @return string
     */
    public function getActionMenu()
    {
        $menuBtn = '<div class="dropdown">
                        <div class="float-right" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots-vertical" viewBox="0 0 16 16">
                            <path d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
                            </svg>
                        </div>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" data-url="' . route('assign.job.form', encrypted_key($this->id, "encrypt")). '" data-ajax-popup="true" data-size="md" data-title="Assign Job" href="javascript:void()">Assign Job</a>';
                        if($this->job_application==self::TYPE_MULTIPLE){
                            $menuBtn .= '<a class="dropdown-item delete_record_model" data-url="' . route('unassign.job', ['id' => encrypted_key($this->jobpostStatus->first()->id, "encrypt"), 'candidate_id' => encrypted_key($this->id, "encrypt")]). '" href="javascript:void()">Unassigned job</a>';
                        }
            $menuBtn .= '<a class="dropdown-item" id="edit_candidate" data-url="' . route('candidate.edit', encrypted_key($this->id, "encrypt")) . '" data-ajax-popup="true" data-size="md" data-title="Edit Candidate" href="#">Edit</a>
                        <a data-url="' . route('candidate.destroy', encrypted_key($this->id, "encrypt")) . '" href="#" class="dropdown-item delete_record_model">Delete</a>
                        </div>
                </div>';
        return $menuBtn;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getJobPostLabel($id){
        $jobType = Job::find($id);
        if(!empty($jobType)){
            return $jobType->job_title;
        }
        return "";
    }

    /**
     * @param $id
     * @return string
     */
    public function getCandidateName($id){
        $candidateData = self::find($id);
        return $candidateData->first_name.' '. $candidateData->last_name;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function notes(){
        return $this->hasMany(CandidateNotes::class)->orderBy('created_at', 'desc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function jobpostStatus(){
        return $this->hasMany(CandidateJobStatus::class)->orderBy('created_at', 'desc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function events(){
        return $this->hasMany(CandidateEvent::class);
    }

    /**
     * @param $id
     * @return string
     */
    public function getCandidateNameLabel($id){
        $candidateData = Candidate::find($id);
        if(!empty($candidateData)){
            return $this->getCandidateShortName();
        }
        return "";
    }

    /**
     * @param $candidateData
     * @return string
     */
    public function getCandidateShortName(){
        $firstName = ucwords($this->first_name);
        $lastName = ucwords($this->last_name);
        return substr($firstName, 0, 1). substr($lastName,0,1);
    }

    /**
     * @return array
     */
    public function getStageOptions(){
        $hiringStage = Hiringstage::get();
        $hiringStageOption = [];
        if(!empty($hiringStage)){
            foreach ($hiringStage as $stage){
                $hiringStageOption[$stage->id] = $stage->name;
            }
            return $hiringStageOption;
        }
        return $hiringStageOption;
    }

    /**
     * @param $id
     * @return string
     */
    public function getStageLabel($id){
        $hiringStage = Hiringstage::find($id);
        if(!empty($hiringStage)){
            return $hiringStage->name;
        }
        return "";
    }

    /**
     * @return string
     */
    public function getCurrentStage(){
        $latestJob = CandidateJobStatus::where("candidate_id", $this->id)->orderBy("id", "DESC")->first();
        if(!empty($latestJob)){
            return $this->getStageLabel($latestJob->current_stage);
        }
        return "";
    }

    /**
     * @return string[]
     */
    public function getJobApplicationClass(){
        if($this->job_application == self::TYPE_SINGLE){
            $class = "badge-success";
            $attribute = "";
        }
        else{
            $class = "badge-warning text-white multiple_job";
            $attribute = "data-toggle=collapse data-target=#collapse-".$this->id." aria-expanded=true aria-controls=collapse-".$this->id."";
        }
        return [
            "class" => $class,
            "attribute" => $attribute
        ];
    }

    public function ordinal($number) {
        $ends = array('th','st','nd','rd','th','th','th','th','th','th');
        if ((($number % 100) >= 11) && (($number%100) <= 13))
            return $number. 'th';
        else
            return $number. $ends[$number % 10];
    }
}
