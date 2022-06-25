<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use App\Job;
use App\JobType;
use App\Location;
class JobCareer extends Model
{
    protected $fillable=[
            'content',
    ];



    public function  getActiveJobs(){
        $jobModel = new Job();
        $jobTypeModel = new JobType();
        $locationModel = new Location();
        $jobColleciton = Job::latest()
            ->leftJoin($jobTypeModel->getTable(), $jobModel->getTable().'.job_type', '=', $jobTypeModel->getTable().'.id')
            ->leftJoin($locationModel->getTable(), $jobModel->getTable().'.location', '=', $locationModel->getTable().'.id')
            ->select($jobModel->getTable().'.*',$jobTypeModel->getTable().'.name as job_name', $locationModel->getTable().'.address as location_address');

        $activeJobs = $jobColleciton->where('job_status','active')->get();
        return $activeJobs;
    }


}
