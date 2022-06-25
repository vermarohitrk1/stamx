<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Location;
use DataTables;

/**
 * Class LocationController
 * @package App\Http\Controllers
 */
class LocationController extends Controller
{
    public function locationList()
    {
        $departmentList = Location::latest()->get();
        return Datatables::of($departmentList)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $edit = route('location.create') . "?id=" . $row->id;
                $data_title = 'Edit Department';
                $actionBtn = '<a href="#" class="edit btn btn-sm bg-success-light" data-url="' . $edit . '" data-ajax-popup="true" data-size="lg" data-title="' . $data_title . '">Edit</a>
                <a href="javascript:void(0)" class="delete btn btn-sm bg-danger-light delete_record_model mt-1" data-url="' . route('admin.location.destroy', encrypted_key($row->id, 'encrypt')) . '">Delete</a>';
                return $actionBtn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function locationCreate(Request $request)
    {
        if ($request->id != "") {
            $locationModel = Location::find($request->id);
        } else {
            $locationModel = new Location;
        }
        return view('jobpoint.location.create', compact('locationModel'));

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        if ($request->updateLocation != "") {
            Location::find($request->updateLocation)->update($request->all());
            return back()->with('success', 'Location Updated successfully');
        } else {
            Location::create($request->all());
        }
        return back()->with('success', 'Location created successfully');
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
        $deleteDepartment = Location::find($id);
        $deleteDepartment->delete();
        return redirect()->back()->with('success', __('Location deleted successfully.'));
    }
}
