<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\JobDepartment;
use DataTables;

/**
 * Class DepartmentController
 * @package App\Http\Controllers
 */
class DepartmentController extends Controller
{
    /**
     * @return mixed
     */
    public function departmentList(){
        $departmentList = JobDepartment::latest()->get();
        return Datatables::of($departmentList)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $edit =  route('department.create')."?id=".$row->id;
                $data_title = 'Edit Department';
                $actionBtn = '<a href="#" class="edit btn btn-sm bg-success-light" data-url="'.$edit.'" data-ajax-popup="true" data-size="lg" data-title="'.$data_title.'">Edit</a>
                <a href="javascript:void(0)" class="delete btn btn-sm bg-danger-light delete_record_model mt-1" data-url="' . route('admin.department.destroy',encrypted_key($row->id,'encrypt')) . '">Delete</a>';
                return $actionBtn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function departmentCreate(Request $request){
        $department = new JobDepartment;
        $getDepartmentStatus = $department->getstatus();
        $departmentModel = [];
        if($request->id!=""){
            $departmentModel = JobDepartment::find($request->id);
        }
        else{
            $departmentModel = new JobDepartment;
        }
        return view('jobpoint.department.create',compact('departmentModel','getDepartmentStatus'));

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request){
        if($request->updateDepartment!=""){
            JobDepartment::find($request->updateDepartment)->update($request->all());
            return back()->with('success','Department Updated successfully');
        }
        else{
            JobDepartment::create($request->all());
        }
        return back()->with('success','Department created successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse|
     */
    public function destroy($id=0) {
        $id = encrypted_key($id, 'decrypt') ?? $id;
      if ($id == '') {
          return redirect()->back()->with('error', __('Id is mismatch.'));
      }
      $deleteDepartment = JobDepartment::find($id);
      $deleteDepartment->delete();
      return redirect()->back()->with('success', __('Department deleted successfully.'));
    }
}
