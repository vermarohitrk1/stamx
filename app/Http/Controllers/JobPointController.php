<?php

namespace App\Http\Controllers;

use App\JobFormEntity;
use App\JobFormField;
use App\JobNotification;
use App\Timezone;
use App\Hiringstage;
use Illuminate\Http\Request;
use DataTables;
use App\JobSetting;
use Illuminate\Support\Facades\Auth;

/**
 * Class JobPointController
 * @package App\Http\Controllers
 */
class JobPointController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function appSetting()
    {
        $timezones = Timezone::get();
        $jobSettings = new JobSetting;
        $jobNotification = JobNotification::all();
        return view('jobpoint.app_setting', compact(['timezones', 'jobSettings', 'jobNotification']));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeNotificationStatus(Request $request){
        $response = ['success' => false, 'message' => ''];
        try {
            $jobNotification = JobNotification::find($request->id);
            $jobNotification->status = $request->status;
            if ($jobNotification->save()){
                $response['success'] = true;
                $response['message'] = "Notification Status updated successfully.";
            }
        }
        catch (\Exception $ex){
            $response['message'] = $ex->getMessage();
        }
        return response()->json($response);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function appSettingSave(Request $request){
        $jobSettings = new JobSetting;
        $requestData = $request->all();
        unset($requestData["_token"]);
        $response = $jobSettings->saveJobSettings($requestData);
        if($response["success"]==false){
            return back()->with('success', $response["message"]);
        }
        return back()->with('success', 'Job Point setting save successfully.');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function jobSetting(Request $request, $id = "")
    {
        $jobpost_id = encrypted_key($id, 'decrypt');
        if($jobpost_id!=""){
            $jobFormEntity = JobFormEntity::whereIn('job_id', [$jobpost_id, JobFormEntity::DEFAULT_JOB_ID])->get();
        }else{
            $jobFormEntity = JobFormEntity::where('job_id', JobFormEntity::DEFAULT_JOB_ID)->get();
        }

        if ($request->ajax()) {
            $data = Hiringstage::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $edit = route('addhiringstage') . "?id=" . $row->id;
                    $data_title = 'Edit addhiringstage';
                    if($row->is_deletable != 0){
                        $actionBtn = '<a href="#" class="edit btn btn-sm bg-success-light" data-url="' . $edit . '" data-ajax-popup="true" data-size="lg" data-title="' . $data_title . '">Edit</a>
                        <a href="javascript:void(0)" class="delete btn btn-sm bg-danger-light delete_record_model mt-1" data-url="'. route('admin.hiring.destroy', encrypted_key($row->id, 'encrypt')).'">Delete</a>';
                        return $actionBtn;
                    }
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('jobpoint.job_setting', compact(['jobFormEntity', 'jobpost_id']));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function addHiringStage(Request $request)
    {
        $hiring = new Hiringstage;
        $getHiringStatus = $hiring->getStatus();
        if ($request->id != "") {
            $hiringStageModel = Hiringstage::find($request->id);
        } else {
            $hiringStageModel = new Hiringstage;
        }
        return view('jobpoint.hiring.create', compact('getHiringStatus', 'hiringStageModel'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        if ($request->updateHiringStage != "") {
            Hiringstage::find($request->updateHiringStage)->update($request->all());
            return back()->with('success', 'Hiring Stage Updated successfully');
        } else {
            Hiringstage::create($request->all());
        }
        return back()->with('success', 'Hiring Stage created successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id = 0)
    {
        $id = encrypted_key($id, 'decrypt') ?? $id;
        if ($id == '') {
            return redirect()->back()->with('error', __('Id is mismatch.'));
        }
        $deleteHiring = Hiringstage::find($id);
        $deleteHiring->delete();
        return redirect()->back()->with('success', __('Hiring Stage deleted successfully.'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function basicinfo($id){
        try{
            $jobFormEntity = JobFormEntity::find($id);
            if(!empty($jobFormEntity)){
                return view('jobpoint.jobform.basic_info_modal', compact('jobFormEntity'));
            }
        }
        catch (\Exception $ex){
            $ex->getMessage();
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function jobFormSetting(Request $request){
        $response = ['success' => false, 'message' => ''];
        try{
            if(!empty($request->input())){
                $jobFormEntity = JobFormEntity::find($request->id);
                $jobFields = $jobFormEntity->jobFormField()->whereIn('job_id', [$request->job_id, JobFormEntity::DEFAULT_JOB_ID])->get();
                if(!empty($jobFormEntity)){
                    $job_id =  $request->job_id;
                    $view = view('jobpoint.jobform.field_setting_body', compact(['jobFormEntity', 'job_id', 'jobFields']))->render();
                    $response['success'] = true;
                    $response['message'] = 'Data Fetched Successfully.';
                    $response['html'] = $view;
                    $response['title'] = ucwords(strtolower($jobFormEntity->label));
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
    public function formFieldEdit(Request $request){
        $response = ['success' => false, 'message' => ''];
        try{
            if(!empty($request->id)){
                $jobFieldData = JobFormField::find($request->id);
                if (!empty($jobFieldData)){
                    $parent_id = $request->parent_id;
                    $job_id = $request->job_id;
                    $view = view('jobpoint.jobform.edit_custom_field_body', compact(['jobFieldData', 'parent_id', 'job_id']))->render();
                    $response['message'] = 'Field Data Fetched Successfully.';
                    $response['title'] = 'Edit Custom Field';
                    $response['button'] = 'Update';
                }
            }else{
                $jobFieldData = new JobFormField();
                $parent_id = $request->parent_id;
                $job_id = $request->job_id;
                $view = view('jobpoint.jobform.edit_custom_field_body', compact(['jobFieldData', 'parent_id', 'job_id']))->render();
                $response['message'] = 'Show Form';
                $response['title'] = 'Add Custom Field';
                $response['button'] = 'Save';
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
     */
    public function formFieldSave(Request $request){
        $response = ['success' => false, 'message' => ''];
        try {

            $objUser = Auth::user();
            $request->request->add(['user_id' => $objUser->id]);
            $options = $request->input('option_values');
            if(!empty($request->input())){
                if(!empty($request->field_id)){
                    $fieldData = JobFormField::find($request->field_id);
                    $fieldData->deleteCustomOptions();
                    if(!empty($options) && $request->type == 'radio' || $request->type == 'checkbox' || $request->type == 'select'){
                        $fieldData->saveCustomOptions($options, $fieldData->id);
                    }
                    $fieldData->update($request->input());
                    $response['message'] = "Custom field Updated successfully";
                }else{
                    if($request->job_id == null){
                       $request->request->set('job_id', '');
                    }
                    $fieldData = JobFormField::create($request->input());
                    if(!empty($options)){
                        $fieldData->saveCustomOptions($options, $fieldData->id);
                    }
                    $response['message'] = "Custom field saved successfully";
                }
                $response['success'] = true;
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
    public function formFieldUpdate(Request $request){
        $response = ['success' => false, 'message' => ''];
        try{
            if(!empty($request->input())){
                $jobFieldData = JobFormField::find($request->field_id);
                if($jobFieldData->update($request->input())){
                    if($request->status == 1 || $request->is_required == 1 ){
                        $event = "Enabled";
                    }else{
                        $event = "Disabled";
                    }
                    $response['success'] = true;
                    $response['message'] = 'Field ' .$event. '  successfully';
                }
            }
        }catch (\Exception $ex){
            $response['message'] = $ex->getMessage();
        }
        return response()->json($response);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function formFieldDelete($id){
        try{
            $jobFieldData = JobFormField::find($id);
            if($jobFieldData->delete()){
                return redirect()->back()->with('success', __('Custom Field Deleted Successfully.'));
            }
        }
        catch (\Exception $ex){
            $ex->getMessage();
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function formStatusUpdate(Request $request){
        $response = ['success' => false, 'message' => ''];
        try{
            if(!empty($request->input())){
                $jobFormData = JobFormEntity::find($request->id);
                if($jobFormData->update($request->input())){
                    $status = ($jobFormData->status == 1)?'Enabled':'Disabled';
                    $response['success'] = true;
                    $response['message'] = 'This Form Section '.$status.' Successfully';
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
     */
    public function addCustomFormSection(Request $request){
        $response = ['success' => false, 'message' => ''];
        try{
            $objUser = Auth::user();
            $request->request->add(['user_id' => $objUser->id]);
            $request->request->set('slug', $request->slug.'_'.time());
            if(!empty($request->input())){
                $saveFormSection = JobFormEntity::create($request->input());
                if($saveFormSection){
                    $response['success'] = true;
                    $response['message'] = 'Custom form section saved successfully.';
                }
            }
        }
        catch (\Exception $ex){
            $response['message'] = $ex->getMessage();
        }
        return response()->json($response);
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteCustomFormSection($id = 0){
        try{
            $id = encrypted_key($id, 'decrypt') ?? $id;
            $formSectionData = JobFormEntity::find($id);
            if($formSectionData->delete()){
                return redirect()->back()->with('success', __('Custom form section deleted successfully.'));
            }
        }
        catch (\Exception $ex){
            $ex->getMessage();
        }
    }
}
