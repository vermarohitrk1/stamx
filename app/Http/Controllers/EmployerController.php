<?php

namespace App\Http\Controllers;
use App\Employer;
use App\User;
use DataTables;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Imports\EmployerImport;
class EmployerController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd(Auth::user()->type);
        if (Auth::user()->type == 'mentor' || Auth::user()->type == 'admin'  ) {
          
     
        $user = Auth::user();
        $employer = new Employer;
        $employer->company = $request->company;
        $employer->address = $request->address;
        $employer->city = $request->city;
        $employer->state = $request->state;
        $employer->user_id = $user->id;
      
        if(Auth::user()->type == 'admin'){
            $employer->status = 1;
        }
      
        $employer->save();
        if(Auth::user()->type == 'admin'){
            $message = 'Successfully added';
        }
        else{
            $message = 'Request sent to admin successfully.';
        }
        return redirect()->back()->with('success', $message);
    }
    else{
        return redirect()->back()->with('error', __('Permission Denied.'));
    }
}
  
  

    public function adminindex(Request $request)
    {
        $authuser = Auth::user();
     
    //dd($authuser);
        if ($request->ajax()) { 
            $data = Employer::orderBy('id', 'DESC');
       return Datatables::of($data)
                   
                    ->filterColumn('company', function ($query, $keyword) use ($data) {
                        $sql = "company like ?";
                        $query->whereRaw($sql, ["%{$keyword}%"]);
                    })
                    ->filterColumn('address', function ($query, $keyword) use ($data) {
                        $sql = "address like ?";
                        $query->whereRaw($sql, ["%{$keyword}%"]);
                    })
                ->addColumn('company', function ($data) {
                    return $data->company;
                })
                ->addColumn('address', function ($data) {
                    return $data->address;
                })
                ->addColumn('city', function ($data) {
                    return $data->city;
                })
                ->addColumn('state', function ($data) {
                    return $data->state;
                })
                ->addColumn('user', function ($data) {
                    return \App\User::find($data->user_id)->name;
                })
                ->addColumn('status', function ($data) {
                    if($data->status == 1){
                        return '<span class="accept">ACCEPTED</span>';
                    }
                    if($data->status == null){
                        return '<span class="pending">PENDING</span>';
                    }
                    if($data->status == 2){
                        return '<span class="reject">REJECTED</span>';
                    }
                })
               ->addColumn('action', function($data){
                    
                $actionBtn = '<div class="actions text-right">
                       <a class="btn btn-sm bg-success-light" data-url="' . route('employer.edit', encrypted_key($data->id, "encrypt")) . '" data-ajax-popup="true" data-size="md" data-title="Edit Status" href="#">
                           <i class="fas fa-pencil-alt"></i>
                       </a>
                         <a data-url="' . route('employer.destroy', encrypted_key($data->id, "encrypt")) . '" href="#" class="btn btn-sm bg-danger-light delete_record_model">
                             <i class="far fa-trash-alt"></i> Delete
                         </a>
                     </div>';
                    
              
                    return $actionBtn;
                })
                ->rawColumns(['id','institution','status','action'])
                ->make(true);     
               


        }else{
            return view('employer.index');
        }
    }

 
    public function adminstore(Request $request)
    {
       // dd($request);
        $id = !empty($request->id) ? encrypted_key($request->id, "decrypt") : 0;
        $validation = [
            'status' => 'required',
        ];
       $validator = Validator::make(
           $request->all(), $validation
       );

       if($validator->fails()) {
           return redirect()->back()->with('error', $validator->errors()->first());
       }
     
        $employer = Employer::find($id);
        $employer->status  = $request->status;
        $employer->city  = $request->city;
        $employer->state  = $request->state;
        $employer->address  = $request->address;
        $employer->company  = $request->company;
        $employer->update();
        $userdata = User::find($employer->user_id);
 
        if($employer->status == 1){
          $status = 'accepted';
        }
        if($employer->status == null){
            $status = 'pending';
        }
        if($employer->status == 2){
            $status = 'rejected';
        }
        $emalbody= 'Your recommendation request for company' .'( '. $request->company .') has been '.$status.' by the admin.';

        $resp = \App\Utility::send_emails(  $userdata->email, $userdata->name, null, $emalbody,'approves',$userdata);
       
       
        return redirect()->route('employer')->with('success', __('Status updated successfully.'));
    }

   
    
    public function adminedit($id)
    {
        //dd($id);
        $id = encrypted_key($id, 'decrypt') ?? $id;
        $authuser = Auth::user();
        $employer = Employer::find($id);;
    //  dd(  $employer );

        return view('employer.create', compact('employer'));
    }

    public function admindestroy($id_enc)
    {
        $objUser = Auth::user();
       
        $id = !empty($id_enc) ? encrypted_key($id_enc, "decrypt") : 0;
       // dd($id);
        if (empty($id)) {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }

        $data = Employer::find($id);
        $data->delete();
        return redirect()->back()->with('success', __('Deleted.'));
    }
    // public function import_quote(Request $request) {
    //     $rules = array('csv_file' => 'required');
    //     $validator = Validator::make($request->all(), $rules);
    //     if ($validator->fails()) {
    //         return response()->json(array(
    //              'success' => false,
    //              'errors' => $validator->getMessageBag()->toArray()
    //                ), 400);
    //     }
    //     $data = $request->all();
    //     $file = $request->csv_file;
    //     $handle = fopen($file, "r");
    //     $headerValues = fgetcsv($handle, 0, ',');
    //     $header = implode(',', $headerValues);
    //     $countheader = count($headerValues);
    //     if ($countheader < 1) {
    //         if (!str_contains($header, 'Title')) {
    //             return response()->json(array(
    //                         'success' => false,
    //                         'errors' => __('1st column should be Title')
    //                             ), 404);
    //         }
    //     }

    //     if (Excel::import(new QuoteImport, $request->file('csv_file'))) {
    //         return redirect()->back()->with('success', __(' CSV Imported successfully.'));
    //     } else {
    //         return redirect()->back();
    //     }
    // }

    public function import_employer(Request $request) {
        $rules = array('csv_file' => 'required');
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(array(
                 'success' => false,
                 'errors' => $validator->getMessageBag()->toArray()
                   ), 400);
        }
        $data = $request->all();
        $file = $request->csv_file;
        $handle = fopen($file, "r");
        $headerValues = fgetcsv($handle, 0, ',');
        $header = implode(',', $headerValues);
        $countheader = count($headerValues);
        if ($countheader < 1) {
            if (!str_contains($header, 'Employer')) {
                return response()->json(array(
                            'success' => false,
                            'errors' => __('1st column should be Institution')
                                ), 404);
            }
        }
//dd($request->file('csv_file'));
        if (Excel::import(new EmployerImport, $request->file('csv_file'))) {
            return redirect()->back()->with('success', __(' CSV Imported successfully.'));
        } else {
            return redirect()->back();
        }
    }
}
