<?php

namespace App\Http\Controllers;

use App\AddEvent;
use Illuminate\Http\Request;
use DataTables;

/**
 * Class AddEventController
 * @package App\Http\Controllers
 */
class AddEventController extends Controller
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function eventList(Request $request)
    {
        $eventdata = AddEvent::latest()->get();
        return Datatables::of($eventdata)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $edit = route('addevent.create') . "?id=" . $row->id;
                $data_title = 'Edit Event';
                $actionBtn = '<a href="#" class="edit btn btn-sm bg-success-light" data-url="' . $edit . '" data-ajax-popup="true" data-size="lg" data-title="' . $data_title . '">Edit</a>
                    <a href="javascript:void(0)" class="delete btn btn-sm bg-danger-light delete_record_model mt-1" data-url="' . route('admin.event.destroy', encrypted_key($row->id, 'encrypt')) . '">Delete</a>';
                return $actionBtn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function addEventCreate(Request $request)
    {
        $event = new AddEvent;
        $getEventStatus = $event->getstatus();
        if ($request->id != "") {
            $eventModel = AddEvent::find($request->id);
        } else {
            $eventModel = new AddEvent;
        }
        return view('jobpoint.addevent.create', compact('getEventStatus', 'eventModel'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        if ($request->updateEvent != "") {
            AddEvent::find($request->updateEvent)->update($request->all());
            return back()->with('success', 'Event Updated successfully');
        } else {
            AddEvent::create($request->all());
        }
        return back()->with('success', 'Event created successfully');
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
        $deleteHiring = AddEvent::find($id);
        $deleteHiring->delete();
        return redirect()->back()->with('success', __('Event deleted successfully.'));
    }
}
