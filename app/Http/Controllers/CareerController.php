<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Job;
use App\JobCareer;
use App\JobType;
use App\Location;
use Illuminate\Database\Seeder;
class CareerController extends Controller
{
    public function careerPage(){
        $job = new Job();
        $JobCareer = JobCareer::first();
        return view('jobpoint.career.careerpage',compact('job','JobCareer'));
    }


    public function save(Request $request){
        $response = [
            "success" => false,
            "message" => ""
        ];
        try{
            $request->validate([
                'content' => 'required',
            ]);
            $jobCareertModel = JobCareer::find($request->id);

            if(empty($jobCareertModel)){
                JobCareer::create($request->all());
            }
            else{
                $jobCareertModel->update($request->all());

            }
            $response["success"] = true;
            $response["message"] = "Job career page updated successfully";
        }
        catch (\Exception $exception){
            $response["message"] = $exception->getLine();
        }
        return response()->json($response);
    }

    public function career(){
        $job = new Job();
        $JobCareer = JobCareer::first();
        return view('jobpoint.career.career',compact('job','JobCareer'));
    }
}
