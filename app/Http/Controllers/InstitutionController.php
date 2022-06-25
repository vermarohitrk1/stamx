<?php

namespace App\Http\Controllers;
use App\Institution;
use App\User;
use DataTables;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Imports\InstitutionImport;
class InstitutionController extends Controller
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
    public function create(Request $request)
    {
        $institution=(object) null;
        
        $institution->type=$request->type??'';
     
        if(!empty($request->place) && $request->place=='recommend'){
              return view('institution.recommendform',compact('institution'));
        }else{
        return view('institution.createform',compact('institution'));
      
        }
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
    
          
            $id = !empty($request->id) ? encrypted_key($request->id, "decrypt") : 0;
       if(!empty($id)){
     
        $institutions = Institution::find($id);
        $institutions->status  = $request->status;
        $institutions->city  = $request->city;
        $institutions->state  = $request->state;
        $institutions->address  = $request->address;
        $institutions->type  = $request->type;
        $institutions->institution  = $request->institution;
                $institutions->zip = $request->postal_code;
        $institutions->lat = $request->address_lat;
        $institutions->long = $request->address_long;
        $institutions->country = $request->country;
        $institutions->update();
       $userdata = User::find($institutions->user_id);
 
        if($institutions->status == 1){
          $status = 'accepted';
        }
        if($institutions->status == null){
            $status = 'pending';
        }
        if($institutions->status == 2){
            $status = 'rejected';
        }
        $emalbody= 'Your recommendation request for '.$institutions->type .'( '. $request->institution .') has been '.$status.' by the admin.';

        $resp = \App\Utility::send_emails( $userdata->email, $userdata->name, null, $emalbody,'approves',$userdata);
        $message = 'Successfully updated';
       }else{
     
        $user = Auth::user();
        $institution = new Institution;
        $institution->institution = $request->institution;
        $institution->user_id = $user->id;
        $institution->type = $request->type;
        if(Auth::user()->type == 'admin'){
            $institution->status = 1;
        }
        $institution->address = $request->address;
        $institution->city = $request->city;
        $institution->state = $request->state;
        $institution->zip = $request->postal_code??0;
        $institution->lat = $request->address_lat??0;
        $institution->long = $request->address_long??0;
        $institution->country = $request->country??null;
        $institution->save();
        if(Auth::user()->type == 'admin'){
            $message = 'Successfully added';
        }
        else{
            $message = 'Request sent to admin successfully.';
        }
       }
       
       
       if(!empty($request->recommended)){
         $response = ['success' => true, 'message' => $message];
         return response()->json($response);
       }else{
                                
        return redirect()->back()->with('success', $message);
       }
   
}

  
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function entityindex(Request $request)
    {
        $authuser = Auth::user();
     
    //dd($authuser);
        if ($request->ajax()) { 
            $data = Institution::orderBy('id', 'DESC');
            
            if(!empty($request->filter_type)){
                $data->where('type',$request->filter_type);
            }
            
            switch ($request->filter_status) {
                case "Pending":
                    $data->where('status', null);
                    break;
                case "Accepted":
                   $data->where('status', 1);
                    break;
                case "Rejected":
                    $data->where('status', 2);
                    break;
               
                default:
                    
                    break;
            }
             if (!empty($request->keyword)) {
                $data->WhereRaw('(institution LIKE "%' . $request->keyword . '%" OR address LIKE "%' . $request->keyword . '%" OR state LIKE "%' . $request->keyword . '%")');
            }
       return Datatables::of($data)
                   
                    ->filterColumn('institution', function ($query, $keyword) use ($data) {
                        $sql = "institution like ?";
                        $query->whereRaw($sql, ["%{$keyword}%"]);
                    })
                    ->filterColumn('address', function ($query, $keyword) use ($data) {
                        $sql = "address like ?";
                        $query->whereRaw($sql, ["%{$keyword}%"]);
                    })
                ->addColumn('type', function ($data) {
                    return $data->type;
                })
                ->addColumn('institution', function ($data) {
                    return $data->institution;
                })
                ->addColumn('address', function ($data) {
                    return $data->address;
                })
                ->addColumn('city', function ($data) {
                    return $data->city;
                })
                ->addColumn('State', function ($data) {
                    return $data->state;
                })
                ->addColumn('zip', function ($data) {
                    return $data->zip;
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
                    
                $actionBtn = '<div class="actions text-center">
                       <a class="btn btn-sm bg-success-light mt-1" href="' . route('institutions.edit', encrypted_key($data->id, "encrypt")) . '" title="Edit Status" >
                           <i class="fas fa-pencil-alt"></i>
                       </a>
                         <a data-url="' . route('institutions.destroy', encrypted_key($data->id, "encrypt")) . '" href="#" class="btn btn-sm bg-danger-light delete_record_model mt-1">
                             <i class="far fa-trash-alt"></i>
                         </a>
                     </div>';
                    
              
                    return $actionBtn;
                })
                ->rawColumns(['id','institution','status','action'])
                ->make(true);     
               


        }else{
            return view('institution.entities');
        }
    }
    public function admincollegeindex(Request $request)
    {
        $authuser = Auth::user();
     
    //dd($authuser);
        if ($request->ajax()) { 
            $data = Institution::where('type','college')->orderBy('id', 'DESC');
       return Datatables::of($data)
                   
                    ->filterColumn('institution', function ($query, $keyword) use ($data) {
                        $sql = "institution like ?";
                        $query->whereRaw($sql, ["%{$keyword}%"]);
                    })
                    ->filterColumn('address', function ($query, $keyword) use ($data) {
                        $sql = "address like ?";
                        $query->whereRaw($sql, ["%{$keyword}%"]);
                    })
                ->addColumn('institution', function ($data) {
                    return $data->institution;
                })
                ->addColumn('address', function ($data) {
                    return $data->address;
                })
                ->addColumn('city', function ($data) {
                    return $data->city;
                })
                ->addColumn('State', function ($data) {
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
                       <a class="btn btn-sm bg-success-light" data-url="' . route('institutions.edit', encrypted_key($data->id, "encrypt")) . '" data-ajax-popup="true" data-size="md" data-title="Edit Status" href="#">
                           <i class="fas fa-pencil-alt"></i>
                       </a>
                         <a data-url="' . route('institutions.destroy', encrypted_key($data->id, "encrypt")) . '" href="#" class="btn btn-sm bg-danger-light delete_record_model">
                             <i class="far fa-trash-alt"></i> Delete
                         </a>
                     </div>';
                    
              
                    return $actionBtn;
                })
                ->rawColumns(['id','institution','status','action'])
                ->make(true);     
               


        }else{
            return view('institution.index');
        }
    }
    public function adminschoolindex(Request $request)
    {
        $authuser = Auth::user();
     
    //dd($authuser);
        if ($request->ajax()) { 
            $data = Institution::where('type','school')->orderBy('id', 'DESC');
       return Datatables::of($data)
                   
                    ->filterColumn('institution', function ($query, $keyword) use ($data) {
                        $sql = "institution like ?";
                        $query->whereRaw($sql, ["%{$keyword}%"]);
                    })
                    ->filterColumn('address', function ($query, $keyword) use ($data) {
                        $sql = "address like ?";
                        $query->whereRaw($sql, ["%{$keyword}%"]);
                    })
                ->addColumn('institution', function ($data) {
                    return $data->institution;
                })
                ->addColumn('address', function ($data) {
                    return $data->address;
                })
                ->addColumn('city', function ($data) {
                    return $data->city;
                })
                ->addColumn('State', function ($data) {
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
                       <a class="btn btn-sm bg-success-light" data-url="' . route('institutions.edit', encrypted_key($data->id, "encrypt")) . '" data-ajax-popup="true" data-size="md" data-title="Edit Status" href="#">
                           <i class="fas fa-pencil-alt"></i>
                       </a>
                         <a data-url="' . route('institutions.destroy', encrypted_key($data->id, "encrypt")) . '" href="#" class="btn btn-sm bg-danger-light delete_record_model">
                             <i class="far fa-trash-alt"></i> Delete
                         </a>
                     </div>';
                    
              
                    return $actionBtn;
                })
                ->rawColumns(['id','institution','status','action'])
                ->make(true);     
               


        }else{
            
      
            return view('institution.index');
        }
    }

    public function adminindex(Request $request)
    {
        $authuser = Auth::user();
     
    //dd($authuser);
        if ($request->ajax()) { 
            $data = Institution::orderBy('id', 'DESC');
       return Datatables::of($data)
                   
                    ->filterColumn('institution', function ($query, $keyword) use ($data) {
                        $sql = "institution like ?";
                        $query->whereRaw($sql, ["%{$keyword}%"]);
                    })
                    ->filterColumn('address', function ($query, $keyword) use ($data) {
                        $sql = "address like ?";
                        $query->whereRaw($sql, ["%{$keyword}%"]);
                    })
                ->addColumn('institution', function ($data) {
                    return $data->institution;
                })
                ->addColumn('address', function ($data) {
                    return $data->address;
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
                       <a class="btn btn-sm bg-success-light" href="' . route('institutions.edit', encrypted_key($data->id, "encrypt")) . '" title="Edit Status" >
                           <i class="fas fa-pencil-alt"></i>
                       </a>
                         <a data-url="' . route('institutions.destroy', encrypted_key($data->id, "encrypt")) . '" href="#" class="btn btn-sm bg-danger-light delete_record_model">
                             <i class="far fa-trash-alt"></i> Delete
                         </a>
                     </div>';
                    
              
                    return $actionBtn;
                })
                ->rawColumns(['id','institution','status','action'])
                ->make(true);     
               


        }else{
            
      
            return view('institution.index');
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
     
        $institutions = Institution::find($id);
        $institutions->status  = $request->status;
        $institutions->city  = $request->city;
        $institutions->state  = $request->state;
        $institutions->address  = $request->address;
        $institutions->type  = $request->type;
        $institutions->institution  = $request->institution;
        $institutions->update();
       $userdata = User::find($institutions->user_id);
 
        if($institutions->status == 1){
          $status = 'accepted';
        }
        if($institutions->status == null){
            $status = 'pending';
        }
        if($institutions->status == 2){
            $status = 'rejected';
        }
        $emalbody= 'Your recommendation request for '.$institutions->type .'( '. $request->institution .') has been '.$status.' by the admin.';

        $resp = \App\Utility::send_emails( $userdata->email, $userdata->name, null, $emalbody,'approves',$userdata);
       
       

    
        return redirect()->route('institutions')->with('success', __('Status updated successfully.'));
    }

   
    

    public function adminedit($id)
    {
        $id = encrypted_key($id, 'decrypt') ?? $id;
        $authuser = Auth::user();
        $institution = Institution::find($id);;
      
        return view('institution.createform', compact('institution'));
    }

    public function admindestroy($id_enc)
    {
        $objUser = Auth::user();
       
        $id = !empty($id_enc) ? encrypted_key($id_enc, "decrypt") : 0;
       // dd($id);
        if (empty($id)) {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }

        $data = Institution::find($id);
        $data->delete();
        return redirect()->back()->with('success', __('Deleted.'));
    }
    public function import_quote(Request $request) {
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
            if (!str_contains($header, 'Title')) {
                return response()->json(array(
                            'success' => false,
                            'errors' => __('1st column should be Title')
                                ), 404);
            }
        }

        if (Excel::import(new QuoteImport, $request->file('csv_file'))) {
            return redirect()->back()->with('success', __(' CSV Imported successfully.'));
        } else {
            return redirect()->back();
        }
    }

    public function import_institute(Request $request) {
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
            if (!str_contains($header, 'Institution')) {
                return response()->json(array(
                            'success' => false,
                            'errors' => __('1st column should be Institution')
                                ), 404);
            }
        }
//dd($request->file('csv_file'));
        if (Excel::import(new InstitutionImport, $request->file('csv_file'))) {
            return redirect()->back()->with('success', __(' CSV Imported successfully.'));
        } else {
            return redirect()->back();
        }
    }
}
