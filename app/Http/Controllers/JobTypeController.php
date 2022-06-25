<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\JobType;
use DataTables;

/**
 * Class JobTypeController
 * @package App\Http\Controllers
 */
class JobTypeController extends Controller
{
    public function jobTypeList()
    {
        $jobType = JobType::latest()->get();
        return Datatables::of($jobType)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $edit = route('jobtype.create') . "?id=" . $row->id;
                $data_title = 'Edit JobType';
                $actionBtn = '<a href="#" class="edit btn btn-sm bg-success-light" data-url="' . $edit . '" data-ajax-popup="true" data-size="lg" data-title="' . $data_title . '">Edit</a>
                <a href="javascript:void(0)" class="delete btn btn-sm bg-danger-light delete_record_model mt-1" data-url="' . route('admin.jobType.destroy', encrypted_key($row->id, 'encrypt')) . '">Delete</a>';
                return $actionBtn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function jobTypeCreate(Request $request)
    {
        if ($request->id != "") {
            $jobTypeModel = JobType::find($request->id);
        } else {
            $jobTypeModel = new JobType;
        }
        return view('jobpoint.jobtype.create', compact('jobTypeModel'));

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function jobTypeStore(Request $request)
    {
        if ($request->get("updateJobType") != "") {
            JobType::find($request->updateJobType)->update($request->all());
            return back()->with('success', 'JobType Updated successfully');
        } else {
            JobType::create($request->all());
        }
        return back()->with('success', 'JobType created successfully');
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
        $deletejobType = JobType::find($id);
        $deletejobType->delete();
        return redirect()->back()->with('success', __('JobType deleted successfully.'));
    }
}
