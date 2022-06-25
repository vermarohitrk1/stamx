<?php

namespace App\Http\Controllers;

use App\Candidate;
use App\CandidateFormData;
use App\CandidateJobStatus;
use App\Hiringstage;
use App\JobFormEntity;
use App\JobFormField;
use App\JobNotification;
use App\JobType;
use App\Location;
use App\JobPostContent;
use App\JobDepartment;
use App\CandidateEvent;
use App\Job;
use App\JobToDo;
use App\Utility;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * Class JobpointDashboardController
 * @package App\Http\Controllers
 */
class JobpointDashboardController extends Controller
{
    const UPLOAD_DIR = "storage/job/files";
    protected $_candidateId = null;
    /**
     * @param Request $request
     * @return Application|Factory|View
     * @throws \Throwable
     */
    public function dashboard(Request $request){
        $jobStatus = $request->get("type", Job::JOB_STATUS_ACTIVE);
        $search = $request->get('search');
        $jobModel = new Job();
        $jobTypeModel = new JobType();
        $locationModel = new Location();
        $departmentModel = new JobDepartment();

        $jobColleciton = Job::latest()
        ->leftJoin($jobTypeModel->getTable(), $jobModel->getTable().'.job_type', '=', $jobTypeModel->getTable().'.id')
        ->leftJoin($locationModel->getTable(), $jobModel->getTable().'.location', '=', $locationModel->getTable().'.id')
        ->leftJoin($departmentModel->getTable(), $jobModel->getTable().'.department', '=', $departmentModel->getTable().'.id')
        ->select($jobModel->getTable().'.*',$jobTypeModel->getTable().'.name as job_name', $locationModel->getTable().'.address as location_address',$departmentModel->getTable().'.name as department_name');
        $jobColleciton->where('job_status',$jobStatus);
        if($search!=""){
            $jobColleciton->where('job_title','LIKE','%'.$search.'%');
        }
        $job = $jobColleciton->paginate(5)->withQueryString();
        $toDoHtml = $this->getToDoUpdatedHtml();
        $candidateEvent = CandidateEvent::limit(3)->latest()->get();
        return view('jobpoint.dashboard.dashboard',compact('job','jobModel', 'jobStatus','search', 'toDoHtml', 'candidateEvent'));
    }

    /**
     * @param Request $request
     * @return Application|Factory|View
     */
    public function createNewJob(Request $request){
        $job = new Job();
        if($request->id!=""){
           $job = Job::find($request->id);
        }
        else{
            $job = new Job();
        }
        return view('jobpoint.dashboard.newjob.create',compact('job'));
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request){
        $requestData = $request->all();
        $requestData["job_status"] = Job::JOB_STATUS_DRAFT;
        if($request->updateJobApplication!=""){
            Job::find($request->updateJobApplication)->update($requestData);
            return back()->with('success','New Job Updated Successfully');
        }
        else{
            Job::create($requestData);
            return back()->with('success','New Job created successfully');
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function jobPointUpdate(Request $request){
        $response = [
            "success" => false,
            "message" => ""
        ];
        try{
            $requestData = $request->all();
            if($request->id!=""){
                Job::find($request->id)->update($requestData["data"]);
                $response["success"] = true;
                $response["message"] = "Job status Updated successfully";
            }
            else{
                $response["message"] = "Something went wrong";
            }
        }
        catch (\Exception $ex){
            $response["message"] = $ex->getMessage();
        }
        return response()->json($response);
    }

    /**
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy($id=0) {
        $id = encrypted_key($id, 'decrypt') ?? $id;
      if ($id == '') {
          return redirect()->back()->with('error', __('Id is mismatch.'));
      }
      $deleteHiring = Job::find($id);
      $deleteHiring->delete();
      return redirect()->back()->with('success', __('deleted successfully.'));
    }

    /**
     * @return Application|Factory|View
     */
    public function allevent(){
        $events = CandidateEvent::latest()->paginate(5)->withQueryString();
        return view('jobpoint.dashboard.event.index', compact('events'));
    }

    /**
     * @param $id
     * @return Application|Factory|View
     */
    public function jobPreview($id){
        $previewId = encrypted_key($id, 'decrypt') ?? $id;
        if(!empty( $previewId )){
            $jobModel = new Job();
            $jobTypeModel = new JobType();
            $locationModel = new Location();
            $jobCollection = Job::latest()
            ->leftJoin($jobTypeModel->getTable(), $jobModel->getTable().'.job_type', '=', $jobTypeModel->getTable().'.id')
            ->leftJoin($locationModel->getTable(), $jobModel->getTable().'.location', '=', $locationModel->getTable().'.id')
            ->select($jobModel->getTable().'.*',$jobTypeModel->getTable().'.name as job_name', $locationModel->getTable().'.address as location_address');
            $job = $jobCollection->where($jobModel->getTable().'.id',$previewId)->first();
        }
        return view('jobpoint.preview.preview',compact('job'));
    }

    /**
     * @param Request $request
     * @return Application|Factory|View
     */
    public function sharableLink(Request $request){
        $id = $request->get('id');
        $url = route('job.preview', ["id" => $id]);
        return view('jobpoint.sharablelink.create',compact('url'));
    }

    /**
     * @return Application|Factory|View
     */
    public function editJobPost($id){
        $id = encrypted_key($id, "decrypt") ?? $id;
        $job = Job::find($id);
        if(empty($job)){
            return redirect("jobpoint/dashboard")->with('error', __('Job not found.'));
        }
        return view('jobpoint.edit_job_post.edit_job_post', compact("job"));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function toDoUpdate(Request $request){
        $response = [
            "success" => false,
            "message" => ""
        ];
        try{
            $user = Auth::user();
            $userId = (!empty($user)) ? $user->id : 0;
            if($request->id!=""){
                $jobTodo = JobToDo::where(["user_id" => $userId, "id" => $request->id])->first();
                if(empty($jobTodo)){
                    $response["message"] = "To Do not found!";
                    return response()->json($response);
                }
            }
            switch ($request->type){
                case "save":
                    JobToDo::Create(["name" => $request->to_do_data["name"], "user_id" => $userId]);
                    $response["success"] = true;
                    $response["message"] = "To Do added successfully.";
                break;
                case "delete":
                    $jobTodo->delete();
                    $response["success"] = true;
                    $response["message"] = "To Do deleted successfully.";
                break;
                case "completed":
                    $jobTodo->update(["status" => JobToDo::STATUS_COMPLETED]);
                    $response["success"] = true;
                    $response["message"] = "To Do item completed successfully.";
                break;
                case "pending":
                    $jobTodo->update(["status" => JobToDo::STATUS_PENDING]);
                    $response["success"] = true;
                    $response["message"] = "To Do item added to pending.";
                break;
                case "clear":
                    $collection = JobToDo::where(["user_id" => $userId])->get(["id"]);
                    JobToDo::destroy($collection->toArray());
                    $response["success"] = true;
                    $response["message"] = "To Do clear successfully";
                break;
            }
            $toDoHtml = $this->getToDoUpdatedHtml();
            $response["to_do_html"] = $toDoHtml;
        }
        catch (\Exception $ex){
            $response["message"] = $ex->getMessage();
        } catch (\Throwable $ex) {
            $response["message"] = $ex->getMessage();
        }
        return response()->json($response);
    }

    /***
     * @return array|string
     * @throws \Throwable
     */
    private function getToDoUpdatedHtml(){
        $user = Auth::user();
        $userId = (!empty($user)) ? $user->id : 0;
        $toDoPendings = JobToDo::where(["status" => JobToDo::STATUS_PENDING, "user_id" => $userId])->OrderBy('id','DESC')->get();
        $toDoComplete = JobToDo::where(["status" => JobToDo::STATUS_COMPLETED, "user_id" => $userId])->OrderBy('id','DESC')->get();
        return view('jobpoint.todo.index',compact('toDoPendings', 'toDoComplete'))->render();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function jobPostSave(Request $request){
        $response = [
            "success" => false,
            "message" => ""
        ];
        try{
            $request->validate([
                'job_id' => 'required',
                'content' => 'required',
            ]);
            $jobPostModel = JobPostContent::find($request->job_id);
            if(empty($jobPostModel)){
                JobPostContent::create($request->all());
            }
            else{
                $jobPostModel->content = $request->all()["content"];
                $jobPostModel->save();
            }
            $response["success"] = true;
            $response["message"] = "Job post updated successfully";
        }
        catch (\Exception $exception){
            $response["message"] = $exception->getMessage();
        }
        return response()->json($response);
    }

    /**
     * @param Request $request
     * @return Application|Factory|View
     */
    public function overview(Request $request){
        $id = $request->get("id");
        $tab = $request->get("tab", "overview");
        $jobId = encrypted_key($id, "decrypt") ?? $id;
        $job = Job::find($jobId);
        return view("jobpoint.overview.overview", compact("job", "tab"));
    }

    /**
     * @param $id
     * @return Application|Factory|View
     */
    public function jobapply($id){
        $job_id = encrypted_key($id, 'decrypt');
        $jobFormSection = JobFormEntity::whereIn('job_id', [$job_id, JobFormEntity::DEFAULT_JOB_ID])->get();
        //  echo $job_id; die('end here');
        return view("jobpoint.application.form", compact(['job_id', 'jobFormSection']));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function saveApplicationForm(Request $request){
        $response = ['success' => false, 'message' => ''];
        try{
            if(!empty($request->input())){
                foreach ($request->candidate as $key => $candidateFieldValue ){
                    if($key == 1){
                        $candidateData = Candidate::where('email', $candidateFieldValue[3])->first();
                        if(!empty($candidateData)){
                            $candidateJobs = $candidateData->jobpostStatus()->get()->pluck('jobpost')->toArray();
                            if(in_array($request->job_id, $candidateJobs)){
                                $response['success'] =  false;
                                $response['message'] =  "Job already assigned to applicant";
                                return response()->json($response);
                            }else{
                                $this->_candidateId = $candidateData->id;
                                $data = [];
                                (isset($candidateFieldValue[1])) ? $data['first_name'] = $candidateFieldValue[1]: '' ;
                                (isset($candidateFieldValue[2])) ? $data['last_name'] = $candidateFieldValue[2]: '' ;
                                (isset($candidateFieldValue[3])) ? $data['email'] = $candidateFieldValue[3]: '' ;
                                (isset($candidateFieldValue[4])) ? $data['gender'] = strtolower($candidateFieldValue[4]): '' ;
                                (isset($candidateFieldValue[5])) ? $data['dob'] = $candidateFieldValue[5]: '' ;
                                (isset($request->job_id)) ? $data['jobpost'] = $request->job_id: '' ;
                                $data['status'] = Candidate::JOB_STATUS_NEW;
                                $data['reviews'] = Candidate::DEFAULT_REVIEW;
                                $data['current_stage'] = Hiringstage::getDefaultStageId();
                                $data['job_application'] = Candidate::TYPE_MULTIPLE;
                                $candidate = Candidate::find($this->_candidateId);
                                $candidate->update($data);
                            }
                        }else{
                            $data = [];
                            (isset($candidateFieldValue[1])) ? $data['first_name'] = $candidateFieldValue[1]: '' ;
                            (isset($candidateFieldValue[2])) ? $data['last_name'] = $candidateFieldValue[2]: '' ;
                            (isset($candidateFieldValue[3])) ? $data['email'] = $candidateFieldValue[3]: '' ;
                            (isset($candidateFieldValue[4])) ? $data['gender'] = strtolower($candidateFieldValue[4]): '' ;
                            (isset($candidateFieldValue[5])) ? $data['dob'] = $candidateFieldValue[5]: '' ;
                            (isset($request->job_id)) ? $data['jobpost'] = $request->job_id: '' ;
                            $data['status'] = Candidate::JOB_STATUS_NEW;
                            $data['reviews'] = Candidate::DEFAULT_REVIEW;
                            $data['current_stage'] = Hiringstage::getDefaultStageId();
                            $data['job_application'] = Candidate::TYPE_SINGLE;
                            $newCandidate = Candidate::create($data);
                            if($newCandidate){
                                $this->_candidateId = $newCandidate->id;
                            }
                        }
                        $candidateJobStatus = new CandidateJobStatus();
                        $candidateJobStatus->jobpost = $request->job_id;
                        $candidateJobStatus->status = Candidate::JOB_STATUS_NEW;;
                        $candidateJobStatus->reviews = Candidate::DEFAULT_REVIEW;
                        $candidateJobStatus->current_stage = Hiringstage::getDefaultStageId();
                        $candidateJobStatus->candidate_id  = $this->_candidateId;
                        if($candidateJobStatus->save()){
                            $candidate = Candidate::find($candidateJobStatus->candidate_id);
                            $emailbody = "You have successfully assigned for ". $candidate->getJobPostLabel($candidateJobStatus->jobpost) ." Job.";
                            Utility::send_emails($candidate->email, $candidate->first_name, null, $emailbody,JobNotification::JOB_APPLIED);
                        }

                    }
                    else{
                        foreach ($candidateFieldValue as $fieldId => $fieldValue){
                            $formData = [];
                            $formData['candidate_id'] = $this->_candidateId;
                            $formData['job_id'] = $request->job_id;
                            $formData['field_id'] = $fieldId;
                            $formData['field_type'] = JobFormField::find($fieldId)->type;
                            $formData['label'] = JobFormField::find($fieldId)->label;
                            $formData['value'] = $fieldValue;
                            if(is_object($fieldValue)){
                                $fileData = Request()->allFiles();
                                foreach ($fileData["candidate"] as $eachFormKey => $value){
                                    foreach ($value as $eachFieldKey => $eachValue){
                                        if($fieldId==$eachFieldKey){
                                            $destinationPath = self::UPLOAD_DIR;
                                            $fileName = time()."_".$eachValue->getClientOriginalName();
                                            $eachValue->move($destinationPath, $fileName);
                                            $formData['value'] = $fileName;
                                        }
                                    }
                                }
                            }
                            if(CandidateFormData::create($formData)){
                                $response['success'] = true;
                                $response['message'] = 'Data Saved Successfully';
                            }
                        }
                    }
                }
            }
        }
        catch(\Exception $ex){
            $response['message'] = $ex->getMessage();
        }
        return response()->json($response);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws \Throwable
     */
    public function previewApplicationForm(Request $request){
        $response = ['success' => false, 'message' => ''];
        try{
            if(!empty($request->input())){
                  $candidateData =  $request->candidate;
                  $jobFormField = new JobFormField();
                  $view = view('jobpoint.application.form_preview', compact(['candidateData', 'jobFormField']))->render();
                  $response['success'] = true;
                  $response['html'] = $view;
            }
        }
        catch (\Exception $ex){
            $response['html'] = $ex->getMessage();
        }
        return response()->json($response);
    }
}
