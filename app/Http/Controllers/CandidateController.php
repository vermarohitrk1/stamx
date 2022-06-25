<?php

namespace App\Http\Controllers;

use App\CandidateEvent;
use App\CandidateFormData;
use App\CandidateJobStatus;
use App\CandidateNotes;
use App\CandidateTimeline;
use App\Hiringstage;
use App\Job;
use App\JobFormEntity;
use App\JobNotification;
use App\Utility;
use Illuminate\Http\Request;
use App\Candidate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

/**
 * Class CandidateController
 * @package App\Http\Controllers
 */
class CandidateController extends Controller
{

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function index(Request $request)
    {
        $flag = false;
        $job = new Job();
        $candidateJobs = new CandidateJobStatus();
        $candidateModel = new Candidate();
        $candidateCollection = Candidate::latest()
            ->leftJoin($job->getTable(), $candidateModel->getTable() . '.jobpost', '=', $job->getTable() . '.id')
            ->leftJoin($candidateJobs->getTable(), $candidateModel->getTable().'.id', '=', $candidateJobs->getTable().'.candidate_id')
            ->select($candidateModel->getTable() . '.*', $candidateJobs->getTable() . '.current_stage', $candidateJobs->getTable() . '.reviews', $candidateJobs->getTable() . '.jobpost', $job->getTable() . '.job_title as job_name');
        if(!empty($request->all())){
            $request = $request->all();
            foreach ($request as $key => $value){
                if(!empty($value)){
                    $flag = true;
                    $candidateCollection = $this->filterCollection($candidateCollection, $key, $value, $candidateModel, $candidateJobs);
                }
            }
        }
        $candidate = $candidateCollection->paginate(5)->withQueryString();
        return view('admin.candidate.candidates', compact(["candidate", "candidateModel", 'flag']));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|string
     */
    public function create(Request $request)
    {

        try {
            $objUser = Auth::user();
//            if ($objUser->type != "admin") {
//                return redirect()->back()->with('error', __('Permission Denied.'));
//            }
            $timeline = new CandidateTimeline();
            $defaultStage = Hiringstage::first()->id;

            if (!empty($request)) {
                $validator = Validator::make($request->all(), [
                    'email' => 'required|unique:candidates|max:255',
                ]);
                if ($validator->fails()) {
                    return redirect()->back()
                        ->with('error', __(': A user with this email address already exists.'));
                }
                $data = $request->input();
                if (isset($data['id'])) {
                    $candidate_id = !empty($data['id']) ? encrypted_key($data['id'], "decrypt") : 0;
                    $candidate = Candidate::find($candidate_id);
                    if($candidate->update($data)){
                        $timeline->candidate_id = $candidate_id;
                        $timeline->message = "<b>".ucfirst($objUser->name)."</b> has been updated <b>".ucfirst($candidate->first_name)."</b>";
                        $timeline->save();
                    }
                    return redirect()->back()->with('success', __('Candidate Updated Successfully!'));
                } else {
                    $data['status'] = Candidate::JOB_STATUS_NEW;
                    $data['reviews'] = Candidate::DEFAULT_REVIEW;
                    $data['current_stage'] = Hiringstage::getDefaultStageId();
                    $data['job_application'] = Candidate::TYPE_SINGLE;
                    $candidateData = Candidate::create($data);
                    $latestCandidateId = $candidateData->id;
                    $data['candidate_id'] = $latestCandidateId;
                    if($jobStatus = CandidateJobStatus::create($data)){
                        if(!empty($jobStatus)){
                            $candidate = Candidate::find($latestCandidateId);
                            $emailbody = "You have successfully assigned for ". $candidate->getJobPostLabel($jobStatus->jobpost) ." Job.";
                            Utility::send_emails($candidate->email, $candidate->first_name, null, $emailbody,JobNotification::JOB_APPLIED);
                            $jobpost = $candidateData->getJobPostLabel($jobStatus->jobpost);
                            $timeline->candidate_id = $latestCandidateId;
                            $timeline->message = "<b>".ucfirst($objUser->name)."</b> has been added <b>".ucfirst($candidateData->first_name)."</b> for the Job Post: <b>". $jobpost."</b>";
                            $timeline->save();
                        }
                    }
                    return redirect()->back()->with('success', __('Candidate Saved Successfully!'));
                }
            }
        } catch (\Exception $ex) {
            return $ex->getMessage();
        }
    }

    /**
     * @param int $id_enc
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function candidateEdit($id_enc = 0)
    {
        $objUser = Auth::user();
        $candidate_id = !empty($id_enc) ? encrypted_key($id_enc, "decrypt") : 0;
//        if ($objUser->type != "admin" || empty($candidate_id)) {
//            return redirect()->back()->with('error', __('Permission Denied.'));
//        }
        $data = Candidate::find($candidate_id);
        return view('admin.candidate.candidate_form', compact('data'));

    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function form()
    {
        $data = new Candidate();
        return view('admin.candidate.candidate_form', compact('data'));
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function jobForm($id_enc = 0)
    {
        $objUser = Auth::user();
        $data = new Candidate();
        $candidate_id = !empty($id_enc) ? encrypted_key($id_enc, "decrypt") : 0;
//        if ($objUser->type != "admin" || empty($candidate_id)) {
//            return redirect()->back()->with('error', __('Permission Denied.'));
//        }
        $data = \App\Candidate::find($candidate_id);
        return view('admin.job_form', compact('data'));
    }

    /**
     * @param int $id_enc
     * @return \Illuminate\Http\RedirectResponse
     */
    public function candidateDestroy($id_enc = 0)
    {
        $objUser = Auth::user();
        $candidate_id = !empty($id_enc) ? encrypted_key($id_enc, "decrypt") : 0;
//        if ($objUser->type != "admin" || empty($candidate_id)) {
//            return redirect()->back()->with('error', __('Permission Denied.'));
//        }
        $data = \App\Candidate::find($candidate_id);
        $data->delete();
        return redirect()->back()->with('success', __('Deleted.'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|string
     */
    public function createJob(Request $request)
    {
        try {
            $objUser = Auth::user();
//            if ($objUser->type != "admin") {
//                return redirect()->back()->with('error', __('Permission Denied.'));
//            }
            $timeline = new CandidateTimeline();
            if (!empty($request)) {
                $data = $request->input();
                if (isset($data['id'])) {
                    $candidate_id = !empty($data['id']) ? encrypted_key($data['id'], "decrypt") : 0;
                    $candidateData = Candidate::find($candidate_id);
                    $data['candidate_id'] = $candidate_id;
                    $data['status'] = Candidate::JOB_STATUS_NEW;
                    $data['reviews'] = Candidate::DEFAULT_REVIEW;
                    $data['current_stage'] = Hiringstage::getDefaultStageId();
                    $model = new CandidateJobStatus();
                    if ($model->create($data)) {
                        $candidate = Candidate::find($model->candidate_id);
                        $emailbody = "You have successfully assigned for ". $candidate->getJobPostLabel($model->jobpost) ." Job.";
                        Utility::send_emails($candidate->email, $candidate->first_name, null, $emailbody,JobNotification::JOB_APPLIED);
                        $jobpost = $candidateData->getJobpostLabel($data["jobpost"]);
                        $timeline->candidate_id = $candidate_id;
                        $timeline->message = "<b>".ucfirst($objUser->name)."</b> has been added <b>".ucfirst($candidateData->first_name)."</b> for the Job Post : <b>" .$jobpost."</b>";
                        $timeline->save();
                        $model = Candidate::find($candidate_id);
                        $model->jobpost = $data['jobpost'];
                        $model->job_application = Candidate::TYPE_MULTIPLE;
                        $model->save();
                    }
                    return redirect()->back()->with('success', __('Job Assigned Successfully!'));
                }
            }
        } catch (\Exception $ex) {
            return $ex->getMessage();
        }
    }

    /**
     * @param int $id_enc
     * @return \Illuminate\Http\RedirectResponse
     */
//    public function unassignJob($id_enc = 0)
//    {
//        $objUser = Auth::user();
//        $candidate_id = !empty($id_enc) ? encrypted_key($id_enc, "decrypt") : 0;
//        if ($objUser->type != "admin" || empty($candidate_id)) {
//            return redirect()->back()->with('error', __('Permission Denied.'));
//        }
//        $timeline = new CandidateTimeline();
//        $candidateData = Candidate::find($candidate_id);
//        $data = CandidateJobStatus::where('candidate_id', $candidate_id)->orderBy('created_at', 'desc')->first();
//        if (!empty($data)) {
//            if($data->delete()){
//                $jobpost = $candidateData->getJobPostLabel($data->jobpost);
//                $timeline->candidate_id = $candidate_id;
//                $timeline->message = "<b>".ucfirst($objUser->name)."</b> has been unassigned <b>".ucfirst($candidateData->first_name)."</b> for the Job Post :<b>" .$jobpost."</b>";
//                $timeline->save();
//            }
//            $latestJobpost = CandidateJobStatus::where('candidate_id', $candidate_id)->orderBy('created_at', 'desc')->first();
//            if(!empty($latestJobpost)){ $jobpost = $latestJobpost->jobpost; }
//            $jobCount = CandidateJobStatus::where('candidate_id', $candidate_id)->count();
//            $data = Candidate::find($candidate_id);
//            if ($jobCount == 1) {
//                $data->job_application = Candidate::TYPE_SINGLE;
//            }
//            $data->jobpost = $jobpost;
//            $data->save();
//
//        } else {
//            $data = \App\Candidate::find($candidate_id);
//            $data->delete();
//        }
//        return redirect()->back()->with('success', __('Successfully unassigned the job.'));
//    }

    public function unassignJob($id = 0, $candidate_id = 0)
    {
        $objUser = Auth::user();
        $candidate_job_statuse_id = !empty($id) ? encrypted_key($id, "decrypt") : 0;
        $candidate_id = !empty($candidate_id) ? encrypted_key($candidate_id, "decrypt") : 0;
//        if ($objUser->type != "admin" || empty($candidate_job_statuse_id)) {
//            return redirect()->back()->with('error', __('Permission Denied.'));
//        }
        $timeline = new CandidateTimeline();
        $candidateData = Candidate::find($candidate_id);
        $data = CandidateJobStatus::find($candidate_job_statuse_id);
        if (!empty($data)) {
            if($data->delete()){
                $jobpost = $candidateData->getJobPostLabel($data->jobpost);
                $timeline->candidate_id = $candidate_id;
                $timeline->message = "<b>".ucfirst($objUser->name)."</b> has been unassigned <b>".ucfirst($candidateData->first_name)."</b> for the Job Post :<b>" .$jobpost."</b>";
                $timeline->save();
            }
            $latestJobpost = CandidateJobStatus::where('candidate_id', $candidate_id)->orderBy('created_at', 'desc')->first();
            if(!empty($latestJobpost)){ $jobpost = $latestJobpost->jobpost; }
            $jobCount = CandidateJobStatus::where('candidate_id', $candidate_id)->count();
            $data = Candidate::find($candidate_id);
            if ($jobCount == 1) {
                $data->job_application = Candidate::TYPE_SINGLE;
            }
            $data->jobpost = $jobpost;
            $data->save();

        } else {
            $data = \App\Candidate::find($candidate_id);
            $data->delete();
        }

        return redirect()->back()->with('success', __('Job unassigned successfully.'));
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function showDetail(Request $request)
    {
        $objUser = Auth::user();
        $candidate_id = !empty($request->id) ? encrypted_key($request->id, "decrypt") : 0;
        $jobpost_id = !empty($request->jobpost_id) ? encrypted_key($request->jobpost_id, 'decrypt') : 0;

//        if ($objUser->type != "admin" || empty($candidate_id)) {
//            return redirect()->back()->with('error', __('Permission Denied.'));
//        }
        $data = Candidate::find($candidate_id);
        $candidateJobpost = $data->jobpostStatus()->find($jobpost_id);
        if(!empty($candidateJobpost) && !empty($data)){
            $view = view('admin.candidate.candidate_modal', compact(['data','candidateJobpost']))->render();
        }
        return $modal = ['html' => $view];
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveNotes(Request $request)
    {
        $response = [
            'success' => false,
            'message' => 'Something went wrong!'
        ];
        try {
            $objUser = Auth::user();
//            if ($objUser->type != "admin") {
//                $response["message"] = "Permission Denied.";
//                return response()->json($response);
//            }
            $timeline = new CandidateTimeline();
            $candidateData = Candidate::find($request->candidate_id);
            $jobpostId = $candidateData->jobpostStatus()->where('id', $request->candidate_job_status_id)->first()->jobpost;
            if (!empty($request)) {
                $data = $request->input();
                $data['noted_by'] = $objUser->id;
                if($notesData = CandidateNotes::create($data)){
                    $jobpostId = $notesData->candidateJobStatus->jobpost;
                    $candidateName = $notesData->candidate->first_name;
                    $jobpost = $notesData->candidate->getJobPostLabel($jobpostId);
                    $timeline->candidate_id = $notesData->candidate->id;
                    $timeline->message = "<b>".ucfirst($objUser->name)."</b> has been added notes for <b>".ucfirst($candidateName)."</b> for the Job Post : <b>" .$jobpost."</b>";
                    $timeline->save();
                }
                $response["success"] = true;
                $response["message"] = "Notes Saved Successfully";
            }
        } catch (\Exception $ex) {
            $response["message"] = $ex->getMessage();
        }
        return response()->json($response);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function getNotes(Request $request){
        try{
            $candidate_id = encrypted_key($request->candidate_id, "decrypt");
            $jobpost_status_id = encrypted_key($request->jobpost_id, "decrypt");
            $response = [
                'success' => false,
                'message' => 'Something went wrong!'
            ];
            $objUser = Auth::user();
//            if ($objUser->type != "admin") {
//                $response["message"] = "Permission Denied.";
//                return response()->json($response);
//            }
            $data = Candidate::find($candidate_id);
            $jobpostNotes = $data->notes()->where('candidate_job_status_id', $jobpost_status_id)->get();
            if(!empty($data) && $jobpostNotes->count() > 0){
                $view = view('admin.candidate.candidate_notes', compact(['data', 'jobpostNotes']))->render();
                $response["success"] = true;
                $response["message"] = 'Data has been fetched successfully - count:'.$data->notes->count();
                $response['html'] = $view;
            }else{
                $empty_msg = "No Comments Available";
                $view = view('admin.candidate.candidate_empty', compact(['data', 'empty_msg']))->render();
                $response["success"] = true;
                $response["message"] = 'Nothing to Show here';
                $response['html'] = $view;
            }
        }
        catch (\Exception $ex){
            $response["message"] = $ex->getMessage();
        }
        return response()->json($response);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateNotes(Request $request){
        $response = [
            'success' => false,
            'message' => "Something went wrong",
        ];
        try{
            if(!empty($request)){
                $notes_id = encrypted_key($request->id, 'decrypt');
                $objUser = Auth::user();
//                if ($objUser->type != "admin") {
//                    $response["message"] = "Permission Denied.";
//                    return response()->json($response);
//                }
                $timeline = new CandidateTimeline();
                $notesData = CandidateNotes::find($notes_id);
                $data = $request->input();
                if($notesData->update($data)){
                    $jobpostId = $notesData->candidateJobStatus->jobpost;
                    $candidateName = $notesData->candidate->first_name;
                    $jobpost = $notesData->candidate->getJobPostLabel($jobpostId);
                    $timeline->candidate_id = $notesData->candidate->id;
                    $timeline->message = "<b>".ucfirst($objUser->name)."</b> has been updated notes for <b>".ucfirst($candidateName)."</b> for the Job Post : <b>" .$jobpost."</b>";
                    $timeline->save();
                }
                $response["success"] = true;
                $response["message"] = 'Notes has been updated successfully';
            }
        }
        catch (\Exception $ex){
            $response["message"] = $ex->getMessage();
        }
        return response()->json($response);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteNotes(Request $request){
        $response = [
            'success' => false,
            'message' => "Something went wrong",
        ];
        try{
            if(!empty($request)){
                $notes_id = encrypted_key($request->id, 'decrypt');
                $objUser = Auth::user();
//                if ($objUser->type != "admin") {
//                    $response["message"] = "Permission Denied.";
//                    return response()->json($response);
//                }
                $timeline = new CandidateTimeline();
                $notesData = CandidateNotes::find($notes_id);
                if($notesData->delete()){
                    $jobpostId = $notesData->candidateJobStatus->jobpost;
                    $candidateName = $notesData->candidate->first_name;
                    $jobpost = $notesData->candidate->getJobPostLabel($jobpostId);
                    $timeline->candidate_id = $notesData->candidate->id;
                    $timeline->message = "<b>".ucfirst($objUser->name)."</b> has been deleted notes for <b>".ucfirst($candidateName)."</b> for the Job Post : <b>" .$jobpost."</b>";
                    $timeline->save();
                }
                $response["success"] = true;
                $response["message"] = 'Notes has been Deleted successfully';
            }
        }
        catch (\Exception $ex){
            $response["message"] = $ex->getMessage();
        }
        return response()->json($response);
    }

    //    Candidate Event

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function eventForm(Request $request){
        $response = [
            'success' => false,
            'message' => "Something went wrong"
        ];
        try{
            if(!empty($request)){
                $candidateId = encrypted_key($request->candidateId, 'decrypt');
                $jobpost_id = encrypted_key($request->jobStatusId, 'decrypt');
                $data = Candidate::find($candidateId);
                $event = new CandidateEvent();
                $view = view('admin.candidate.event_form', compact(['data','event', 'jobpost_id']))->render();
                $response['success'] = true;
                $response['message'] = "Event Form";
                $response['title'] = "Create Event";
                $response['html'] = $view;
            }
        }
        catch (\Exception $ex){
            $response['message'] = $ex->getMessage();
        }
        return response()->json($response);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function disqualifyForm(Request $request){
        $response = [
            'success' => false,
            'message' => "Something went wrong"
        ];
        try{
            if(!empty($request->input())){
                $candidateId = $request->candidate_id;
                $jobpost_id = $request->jobpost_id;
                $disqualifyStageId = Hiringstage::where(['name'=>Hiringstage::DISQUALIFIED_LABEL, 'is_deletable'=> false])->first()->id;
                $view = view('admin.candidate.disqualify_form', compact(['candidateId','jobpost_id', 'disqualifyStageId']))->render();
                $response['success'] = true;
                $response['message'] = "Disqualify Form";
                $response['html'] = $view;
            }
        }
        catch (\Exception $ex){
            $response['message'] = $ex->getMessage();
        }
        return response()->json($response);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function mailForm(Request $request){
        $response = [
            'success' => false,
            'message' => "Something went wrong"
        ];
        try{
            if(!empty($request->input())){
                $candidateId = $request->candidate_id;
                $jobpost_id = $request->jobpost_id;
                $candidate = Candidate::find($candidateId);
                $candidateName = $candidate->getCandidateName($candidateId);
                $view = view('admin.candidate.mail_form', compact(['candidateId','jobpost_id']))->render();
                $response['success'] = true;
                $response['message'] = "Mail Form";
                $response['title'] = "Mail To - ".$candidateName;
                $response['html'] = $view;
            }
        }
        catch (\Exception $ex){
            $response['message'] = $ex->getMessage();
        }
        return response()->json($response);
    }

    public function sendMail(Request $request){
        $response = ['success' => false, 'message' => "Something went wrong"];
        try{
            $candidate = Candidate::find($request->candidate_id);
            $subject = $request->subject;
            $emailbody = $request->maildata;
            $sendMail = Utility::send_emails($candidate->email, $candidate->getCandidateName($candidate->id), $subject, $emailbody);
            if($sendMail){
                $response['success'] = true;
                $response['message'] = "Mail has been sent to candidate successfully.";
            }
        }
        catch (\Exception $ex){
            $response['message'] = $ex->getMessage();
        }
        return response()->json($response);
    }




    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createEvent(Request $request){
        $response = [
            'success' => false,
            'message' => "Something went wrong"
        ];
        try{

            $objUser = Auth::user();
//            if ($objUser->type != "admin") {
//                $response["message"] = "Permission Denied.";
//                return response()->json($response);
//            }
            $timeline = new CandidateTimeline();
            $data = $request->input();
            $attendees = json_encode($data['attendees']);
            $data['candidate_id'] = $request->candidate_id;
            $data['candidate_job_status_id'] = $request->candidate_job_status_id;
            $data['attendees'] = $attendees;
            $data['created_by'] = $objUser->id;
            $startDate = date_format(date_create($data['event_start_datetime']), 'Y-m-d H:i:s');
            $endDate = date_format(date_create($data['event_end_datetime']), 'Y-m-d H:i:s');
            if($data['id'] != null || $data['id'] != ""){
                $eventModel = CandidateEvent::find($data['id']);
                if(!empty($eventModel)){
                    if($eventModel->update($data)){
                        $jobpostId = $eventModel->candidateJobStatus->jobpost;
                        $candidateName = $eventModel->candidate->first_name;
                        $jobpost = $eventModel->candidate->getJobPostLabel($jobpostId);
                        $timeline->candidate_id = $eventModel->candidate->id;
                        $timeline->message = "<b>".ucfirst($objUser->name)."</b> has been updated event for <b>".ucfirst($candidateName)."</b> for the Job Post : <b>" .$jobpost."</b>";
                        $timeline->save();
                    }
                }
                $response['success'] = true;
                $response['message'] = "Event has been updated successfully";
            }else{
                $eventModel = new CandidateEvent();
                $eventModel->candidate_id = $data['candidate_id'];
                $eventModel->candidate_job_status_id = $data['candidate_job_status_id'];
                $eventModel->created_by = $data['created_by'];
                $eventModel->event_type = $data['event_type'];
                $eventModel->event_start_datetime = $startDate;
                $eventModel->event_end_datetime = $endDate;
                $eventModel->location = $data['location'];
                $eventModel->attendees = $data['attendees'];
                $eventModel->description = $data['description'];
                if($eventModel->save()){
                    $jobpostId = $eventModel->candidateJobStatus->jobpost;
                    $candidateName = $eventModel->candidate->first_name;
                    $jobpost = $eventModel->candidate->getJobPostLabel($jobpostId);
                    $timeline->candidate_id = $eventModel->candidate->id;
                    $timeline->message = "<b>".ucfirst($objUser->name)."</b> has been added event for <b>".ucfirst($candidateName)."</b> for the Job Post : <b>" .$jobpost."</b>";
                    $timeline->save();
                    $candidate = Candidate::find($data['candidate_id']);
                    $emailbody = $eventModel->description;
                    Utility::send_emails($candidate->email, $candidate->first_name, null, $emailbody,JobNotification::EVENT_CREATED);
                }
                $response['success'] = true;
                $response['message'] = "Event saved successfully";
            }
        }catch (\Exception $ex){
            $response['message'] = $ex->getMessage();
        }
        return response()->json($response);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function getEvent(Request $request){
        $response = [
            'success' => false,
            'message' => ""
        ];
        try{
            $candidateId = encrypted_key($request->candidate_id, 'decrypt');
            $jobpost_status_id = encrypted_key($request->candidate_job_id, 'decrypt');

            $eventModel = new CandidateEvent();
            $eventCollection = $eventModel->where(['candidate_id' => $candidateId,'candidate_job_status_id' => $jobpost_status_id])->orderBy('created_at', 'desc')->get();
            if(!empty($eventCollection) && $eventCollection->count() > 0){
                $view = view('admin.candidate.candidate_events', compact('eventCollection'))->render();
            }else{
                $empty_msg = "No Events Available";
                $view = view('admin.candidate.candidate_empty', compact('empty_msg'))->render();
                $response['message'] = "No Events available";
            }
            $response['success'] = true;
            $response['html'] = $view;
        }
        catch (\Exception $ex){
            $response['message'] = $ex->getMessage();
        }
        return response()->json($response);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function editEvent(Request $request){
        $response = [
            'success' => false,
            'message' => '',
        ];
        try{
            $event = CandidateEvent::find($request->id);
            $data = Candidate::find($event->candidate_id );
            if(!empty($event)){
                $view = view('admin.candidate.event_form', compact(['event', 'data']))->render();
                $response['success'] = true;
                $response['html'] = $view;
                $response['title'] = 'Edit Event';
            }
        }
        catch (\Exception $ex){
            $response['message'] = $ex->getMessage();
        }
        return response()->json($response);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteEvent(Request $request){
        $response = [
            'success' => false,
            'message' => "",
        ];
        try{
            $id = $request->id;
            $eventData = CandidateEvent::find($id);
            $objUser = Auth::user();
//            if ($objUser->type != "admin") {
//                $response["message"] = "Permission Denied.";
//                return response()->json($response);
//            }
            $timeline = new CandidateTimeline();
            if(!empty($eventData)){
                if ($eventData->delete()){
                    $jobpostId = $eventData->candidateJobStatus->jobpost;
                    $candidateName = $eventData->candidate->first_name;
                    $jobpost = $eventData->candidate->getJobPostLabel($jobpostId);
                    $timeline->candidate_id = $eventData->candidate->id;
                    $timeline->message = "<b>".ucfirst($objUser->name)."</b> has been deleted event for <b>".ucfirst($candidateName)."</b> for the Job Post : <b>" .$jobpost."</b>";
                    $timeline->save();
                    $response['success'] = true;
                    $response['message'] = "Event has been deleted successfully";
                }
            }
        }
        catch (\Exception $ex){
            $response['message'] = $ex->getMessage();
        }
        return response()->json($response);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function viewEvent(Request $request){
        $response = [
            'success' => false,
            'message' => "",
        ];
        try {
            $event = CandidateEvent::find($request->id);
            if(!empty($event)){
                $view = view('admin.candidate.event_view_modal', compact('event'))->render();
                $response['success'] = true;
                $response['message'] = "Event fetched successfully";
                $response['html'] = $view;
                $response['title'] = $event->getEventLabel($event->event_type);
            }
        }
        catch (\Exception $ex){
            $response['message'] = $ex->getMessage();
        }
        return response()->json($response);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function stageUpdate(Request $request){
        $response = ['success' => false, 'message' => ''];
        try{
            $objUser = Auth::user();
//            if ($objUser->type != "admin") {
//                $response["message"] = "Permission Denied.";
//                return response()->json($response);
//            }

            $timeline = new CandidateTimeline();
            if(!empty($request->input())){
                $candidate = new Candidate();
                $candidateJobs = CandidateJobStatus::find($request->jobpost_id);
                $candidateJobs->current_stage = $request->stage_id;
                if($candidateJobs->save()){
                    $stagename = $candidate->getStageLabel($candidateJobs->current_stage);
                    if($stagename == "Disqualified"){
                        $candidate = Candidate::find($candidateJobs->candidate_id);
                        $emailbody = "You are Disqualified.";
                        Utility::send_emails($candidate->email, $candidate->first_name, null, $emailbody,JobNotification::CANDIDATE_DISQUALIFIED);
                    }
                    $jobpostId = $candidateJobs->jobpost;
                    $candidateName = $candidateJobs->candidate->first_name;
                    $jobpost = $candidateJobs->candidate->getJobPostLabel($jobpostId);
                    $timeline->candidate_id = $candidateJobs->candidate->id;
                    $timeline->message = "<b>".ucfirst($objUser->name)."</b> has been updated the stage for <b>".ucfirst($candidateName)."</b> for the Job Post : <b>" .$jobpost."</b>";
                    $timeline->save();
                    $candidate = new Candidate();
                    $current_stage = $candidate->getStageLabel($candidateJobs->current_stage);
                    $response['success'] = true;
                    $response['message'] = "Candidate Stage has been updated successfully";
                    $response['stage'] = $current_stage;
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
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function getTimeline(Request $request){
        $response = ['success' => false, 'message' => ""];
        try{
            if(!empty($request->input())){
                $candidate_id = $request->id;
                $candidateTimeline = CandidateTimeline::where('candidate_id', $candidate_id)->limit(5)->latest()->get();
                if(!empty($candidateTimeline) && $candidateTimeline->count() > 0){
                    $view = view('admin.candidate.candidate_timeline', compact('candidateTimeline'))->render();
                    $response['success'] = true;
                    $response['message'] = 'Timeline fetched successfully';
                    $response['html'] = $view;
                }else{
                    $empty_msg = "No log available";
                    $view = view('admin.candidate.candidate_empty', compact('empty_msg'))->render();
                    $response["success"] = true;
                    $response["message"] = 'Nothing to Show here';
                    $response['html'] = $view;
                }
            }
        }
        catch (\Exception $ex){
            $response["message"] = $ex->getMessage();
        }
        return response()->json($response);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveReview(Request $request){
        $response = ['success' => true, 'message' => ''];
        try{

            $objUser = Auth::user();
//            if ($objUser->type != "admin") {
//                $response["message"] = "Permission Denied.";
//                return response()->json($response);
//            }
            $jobStatusId = $request->jobpost_id;
            $jobStatus = CandidateJobStatus::find($jobStatusId);
            $jobStatus->reviews = $request->review_points;
            if($jobStatus->save()){
                $timeline = new CandidateTimeline();
                $candidate = new Candidate();
                $candidateName = $candidate->getCandidateName($request->id);
                $timeline->candidate_id = $request->id;
                $timeline->message = "<b>".ucfirst($candidateName)."</b> has given <b> ".$request->review_points." star </b> review by <b>".ucfirst($objUser->name)."</b>";
                $timeline->save();
                $response['success'] = true;
                $response['message'] = 'Review has been updated successfully';
                $response['review'] = $jobStatus->reviews.' of 5';
            }
        }
        catch (\Exception $ex){
            $response['message'] = $ex->getMessage();
        }
        return response()->json($response);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function getQuestions(Request $request){
        $response = ['success' => true, 'message' => ''];
        try{
            $candidate_id = encrypted_key($request->candidate_id, 'decrypt');
            $job_id = encrypted_key($request->jobpost_id, 'decrypt');
            $jobFormSection = JobFormEntity::where('slug', $request->slug)->first();
            $candidateQuestionData = [];
            foreach ($jobFormSection->jobFormField as $field){
                $data = CandidateFormData::where(['candidate_id' => $candidate_id, 'job_id' => $job_id, 'field_id' => $field->id])->first();
                if($data == null){
                    continue;
                }else{
                    $candidateQuestionData[] = $data;
                }
            }
            if(count($candidateQuestionData) == 0){
                $empty_msg = "Sorry! No question answer found";
                $view = view('admin.candidate.candidate_empty', compact('empty_msg'))->render();
                $response["success"] = true;
                $response["message"] = 'Nothing to Show here';
                $response['html'] = $view;
            }else{
                $view = view('admin.candidate.candidate_questions', compact('candidateQuestionData'))->render();
                $response['success'] = true;
                $response['message'] = 'Questions and fetched successfully';
                $response['html'] = $view;
            }
        }
        catch(\Exception $ex){
            $response['message'] = $ex->getMessage();
        }
        return response()->json($response);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function getAttachment(Request $request){
        $response = ['success' => true, 'message' => ''];
        try{
            $candidate_id = encrypted_key($request->candidate_id, 'decrypt');
            $job_id = encrypted_key($request->jobpost_id, 'decrypt');
            $jobFormSection = JobFormEntity::where('slug', JobFormEntity::RESUME_SLUG)->first();
            foreach ($jobFormSection->jobFormField as $field){
                $attachment = CandidateFormData::where(['candidate_id' => $candidate_id, 'job_id' => $job_id, 'field_id' => $field->id])->first();
            }
            if(!empty($attachment)){
                $extension = pathinfo($attachment->value)['extension'];
                $view = view('admin.candidate.candidate_attachment', compact(['attachment', 'extension']))->render();
                $response['success'] = true;
                $response['message'] = 'Resume attachment fetched successfully';
                $response['html'] = $view;
            }else{
                $empty_msg = "This candidate have no attachment Thank you";
                $view = view('admin.candidate.candidate_empty', compact('empty_msg'))->render();
                $response["success"] = true;
                $response["message"] = 'Nothing to Show here';
                $response['html'] = $view;
            }
        }
        catch (\Exception $ex){
            $response['message'] = $ex->getMessage();
        }
        return response()->json($response);
    }


    /**
     * @param $collection
     * @param $attribute
     * @param $value
     * @param $candidateModel
     * @param $candidateJobs
     * @return mixed
     */
    public function filterCollection($collection, $attribute, $value, $candidateModel, $candidateJobs){
        try {
            if($attribute == 'applied_date' ){
                $date = explode('-', $value);
                $date_from = Date('Y-m-d H:i:s', strtotime($date[0]));
                $date_to = Date('Y-m-d H:i:s', strtotime($date[1]) + 86400);
                $collection->whereBetween($candidateModel->getTable().'.created_at', [$date_from, $date_to]);

            }elseif ($attribute == 'jobpost'){
                $collection->where($candidateJobs->getTable().'.jobpost', $value);

            }elseif ($attribute == 'current_stage'){
                $collection->where($candidateJobs->getTable().'.current_stage', $value);

            }elseif ($attribute == 'gender'){
                $collection->where($candidateModel->getTable().'.gender', $value);

            }
            return $collection;
        }
        catch (\Exception $ex){
            $ex->getMessage();
        }
    }

}
