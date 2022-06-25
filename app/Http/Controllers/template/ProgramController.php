<?php

namespace App\Http\Controllers\template;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use DataTables;
use App\User;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use App\Imports\AuditImport;
class ProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index()
    // {
    //     $user = Auth::user();
    //     $data = \App\Programable_question::orderBy('id', 'ASC')->get();
     
    //      return view('admin.template.program.apply_form')->with('data',$data);
    // }
    // public function __construct() {
       
    //     if (Auth::user()->type == 'admin') {
    //         return redirect()->back()->with('error', __('Permission Denied.'));
    //     } 
    // }
    public function index(Request $request)
    {
        if (Auth::user()->type != 'mentor') {
            return redirect()->back()->with('error', __('Permission Denied.'));
        } 
        $user = Auth::user();
      //  dd(Auth::user());
        $data = \App\Program::where('user_id', $user->id)->orderBy('id', 'DESC')->get();
        $authorize = \App\ProgramApproval::where('user_id', $user->id)->first();
     //   dd($authorize);
        if($authorize != null && $authorize->status == 1){
            $apply_p = 1;
        }
        else{
            $apply_p = 0;
        }
        if ($request->ajax()) {
            $data = \App\Program::select('id','title','category_id')->where('user_id', $user->id)->orderBy('id', 'DESC');
           
             return Datatables::of($data)
                           // ->addIndexColumn()
                            ->filterColumn('title', function ($query, $keyword) use ($request) {
                                $sql = "title like ?";
                                $query->whereRaw($sql, ["%{$keyword}%"]);
                            })
                            ->addColumn('title', function ($data) {
                               return $data->title;
                            })
                            ->addColumn('category_id', function ($data) {
                                $programCategory = \App\ProgramCategory::find($data->category_id);
                                if($programCategory){
                                    return  $programCategory->name;
                                }else{
                                    return '-';
                                }
                            
                             })
                            
                            // ->addColumn('status', function ($data) {
                            //      if($data->status == 0){
                            //       $status = '<span class="badge  badge-xs bg-primary-light">Pending</span>';
                            //      }
                            //      else if($data->status == 1){
                            //          $status = '<span class="badge  badge-xs bg-success-light">Accepted</span>';
                            //      }
                            //      else{
                            //          $status = '<span class="badge badge-xs bg-danger-light">Rejected</span>';
                            //      }
                            //     return  $status;
                            //  })
                            ->addColumn('action', function($data) {
                                $user = Auth::user();
                                if ($data->role != "admin") {
                                    $actionBtn = '<div class="actions text-right">
                                                <a class="btn btn-sm bg-success-light"  href="' . route('program.show', encrypted_key($data->id, "encrypt")) . '">
                                                <i class="far fa-eye"></i> </a>
                                                <a class="btn btn-sm bg-success-light" href="' . route('program.edit', encrypted_key($data->id, "encrypt")) . '">
                                                <i class="fas fa-pencil-alt"></i></a>
                                                <a data-url="' . route('program.destroy', encrypted_key($data->id, "encrypt")) . '" class="btn btn-sm bg-danger-light delete_record_model">
                                                    <i class="far fa-trash-alt"></i>
                                                </a>
                                            </div>';
                                } else {
                                    $actionBtn = '';
                                }
  
                                return $actionBtn;
                            })
                            ->rawColumns(['title','action', 'status'])
                            ->make(true);
            
        } else {
     //dd($apply_p);
            return view('admin.template.program.listing')->with(['data'=>$data,'apply_p'=>$apply_p] );
        }
        
      
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::user()->type != 'mentor') {
            return redirect()->back()->with('error', __('Permission Denied.'));
        } 
        $user = Auth::user();
        $data = \App\Programable_question::orderBy('id', 'ASC')->get();
        $program_category = \App\ProgramCategory::orderBy('id', 'ASC')->get();
         
              return view('admin.template.program.apply_form')->with(['data'=>$data,'program_category'=>$program_category]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request);
        if (Auth::user()->type != 'mentor') {
            return redirect()->back()->with('error', __('Permission Denied.'));
        } 
        $cleanup = $request->except('_token','csrf-token','title','category_id','id','price');
        //dd($cleanup);
       $data =  json_encode($cleanup);
    // dd($request->state);
     if($request->state == null){
       $states= null;
     }else{
       $states = json_encode($request->state);
     }
      $id = $request->id;
       if($id == null){
        $user = Auth::user();
        $approval = new \App\Program();
        $approval['user_id'] = $user->id;
        $approval['title'] = $request->title;
        $approval['price'] = $request->price;
        $approval['company'] = $request->company;
        $approval['state'] = $states;
        $approval['category_id'] = $request->category_id;
        $approval['data'] = $data;
        $approval['status'] = 0;
        $approval->save();

       }
       else{
        $approval = \App\Program::find($id);
        $approval->title = $request->title;
        $approval->price = $request->price;
        $approval->company = $request->company;
        $approval->category_id = $request->category_id;

        $approval->state = $states;
        $approval->data = $data;
        
        $approval->update();

       }
        

         return redirect()->route('program.list')->with('success', __('Form submit successfully.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    function checkDateFormat($date)
{
  // match the format of the date
  if (preg_match ("/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/", $date, $parts))
  {

    // check whether the date is valid or not
    if (checkdate($parts[2],$parts[3],$parts[1])) {
      return true;
    } else {
      return false;
    }

  } else {
    return false;
  }
}
    public function show($id)
    {
        if (Auth::user()->type != 'mentor') {
            return redirect()->back()->with('error', __('Permission Denied.'));
        } 
        $id = !empty($id) ? encrypted_key($id, "decrypt") : 0;
       // dd( $id );
       $erordate = 0 ;
        $data = \App\Program::where('id',$id)->with('user')->first();
        $quedata = \App\Programable_question::get();
        $statecount = 0;
     
        if(!empty($data->state)){
            $state = json_decode($data->state, true);
            $statecount = count($state);
        }
        
       $graph_data = json_decode($data->audit_report, true);
       
       
       $graphic = array();
       $graphicData = array();
       $graphictable=array();
     // dd($graph_data);
      if($graph_data != null){
       if (array_key_exists("date", $graph_data)) {
     $datesadsdsds =    $this->checkDateFormat( $graph_data['date']);
     if($datesadsdsds == true){
            $graphictable[0]['date'] =   $graph_data['date'] ;
//            $graphictable[0]['city'] = $graph_data['city'];
            $graphictable[0]['participants'] = $graph_data['participants'];
            $graphictable[0]['male_participants'] = $graph_data['male_participants']??0;
            $graphictable[0]['female_participants'] = $graph_data['female_participants']??0;
            $graphictable[0]['other_participants'] = $graph_data['other_participants']??0;
            $graphictable[0]['participant_cost'] = $graph_data['participant_cost']??0;
            $graphictable[0]['state'] = $graph_data['state'];
            $graphictable[0]['method'] = $graph_data['method'];
//            $graphictable[0]['framework'] = $graph_data['framework'];
            


            $graphic['x'] =    preg_replace("/\s+/", "", strval($graph_data['date']))  ;
            $graphic['y'] = $graph_data['participants'];
            $graphicData[0] =  $graphic;

     }
     else{
      $erordate = 1;
     }
          
           

       }
       else{

      
     
        foreach($graph_data  as $key => $graph){
            $datesadsdsds =   $this->checkDateFormat( preg_replace("/\s+/", "", strval($graph['date'])) );
     if($datesadsdsds == true){
      
       $graphictable[$key]['date'] = preg_replace("/\s+/", "", strval($graph['date']))  ;
//            $graphictable[$key]['city'] = $graph['city'];
            $graphictable[$key]['participants'] = $graph['participants'];
              $graphictable[$key]['male_participants'] = $graph['male_participants']??0;
            $graphictable[$key]['female_participants'] = $graph['female_participants']??0;
            $graphictable[$key]['other_participants'] = $graph['other_participants']??0;
            $graphictable[$key]['participant_cost'] = $graph['participant_cost']??0;
            $graphictable[$key]['state'] = $graph['state'];
            $graphictable[$key]['method'] = $graph['method'];
//            $graphictable[$key]['framework'] = $graph['framework'];
            


            $graphic['x'] =    preg_replace("/\s+/", "", strval($graph['date']))  ;
            $graphic['y'] = $graph['participants'];
            $graphicData[$key] =  $graphic;

     }
     else{
      $erordate = 1;
     }
       
           
           }
       }
    }
   
   //dd( $graphictable);
        $questions = array();
        foreach($quedata as $key => $question){
            $inc = $question->id;
          $questions['question_'.$inc] = $question->question; 
        }
    // dd($erordate);
        return view('admin.template.program.fetch_data')->with(['erordate'=>$erordate,'data'=> $data, 'questions'=>$questions, 'graph_data'=>$graphicData,'graphictable'=>$graphictable,'statecount'=>$statecount]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id_enc = 0) {
        if (Auth::user()->type != 'mentor') {
            return redirect()->back()->with('error', __('Permission Denied.'));
        } 
        $objUser = Auth::user();
        $role_id = !empty($id_enc) ? encrypted_key($id_enc, "decrypt") : 0;
      //  dd($role_id);
        // if (empty($role_id)) {
        //     return redirect()->back()->with('error', __('Permission Denied.'));
        // }
        $quedata = \App\Programable_question::get();
        $program_category = \App\ProgramCategory::orderBy('id', 'ASC')->get();

        $questions = array();
        $ques = array();
        foreach($quedata as $key => $question){
            $inc = $question->id;
            $ques['type']= $question->type;
            $ques['question']= $question->question;
            $ques['value']= $question->value;
            $questions['question_'.$inc] = $ques; 
        }
        $data = \App\Program::find($role_id);
     //  dd($data);
        return view('admin.template.program.program_edit_form')->with(['data'=>$data,'questions'=>$questions,'program_category'=>$program_category]);
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
        $objUser = Auth::user();
        $apply_id = !empty($id) ? encrypted_key($id, "decrypt") : 0;
        $data = \App\Program::where('id',$apply_id);
        $data->delete();
        return redirect()->back()->with('success', __('Deleted.'));
    }

    
    public function auditRequest( $id) {
       // dd($id);
       $user_id = get_domain_user()->id;
      // $user_id = Auth::user()->id;
      // dd($user_id);
       $user_setting = DB::table('website_setting')->where('user_id', $user_id)->where('name', 'payment_settings')->first();
 
       $payment = json_decode($user_setting->value,true);
              return view('admin.template.program.apply_audit')->with(['id'=>$id,'payment'=>$payment]);
   
    }
    public function adminProgramlisting(Request $request) {
        
        // $data = \App\ProgramApproval::orderBy('id', 'ASC')->get();
           // dd($data);
           if (Auth::user()->type != 'admin') {
            return redirect()->back()->with('error', __('Permission Denied.'));
        } 
           if ($request->ajax()) {
              $data = \App\Program::orderBy('id', 'ASC');
             //dd($data);
               return Datatables::of($data)
                              ->addIndexColumn()
                              ->addColumn('user_id', function ($data) {
                                  $user = User::find($data->user_id);
                                 return  $user->email;
                              })
                              ->filterColumn('title', function ($query, $keyword) use ($request) {
                                $sql = "title like ?";
                                $query->whereRaw($sql, ["%{$keyword}%"]);
                            })
                              ->addColumn('title', function ($data) {
                               return  $data->title;
                            })
                            ->addColumn('category_id', function ($data) {
                                $programCategory = \App\ProgramCategory::find($data->category_id);
                                if($programCategory){
                                    return  $programCategory->name;
                                }else{
                                    return '-';
                                }
                            
                             })
                              ->addColumn('action', function($data) {
                                  $user = Auth::user();
                                  if ($data->role != "admin") {
                                      $actionBtn = '<div class="actions text-right">
                                                  <a class="btn btn-sm bg-success-light"  href="' . route('adminProgramlisting.show', encrypted_key($data->id, "encrypt")) . '">
                                                  <i class="far fa-eye"></i>
                                                  </a>
                                                  <a class="btn btn-sm bg-success-light" href="' . route('adminProgramlisting.edit', encrypted_key($data->id, "encrypt")) . '">
                                                      <i class="fas fa-pencil-alt"></i>
                                                  </a>
                                                  <a data-url="' . route('adminProgramlisting.destroy', encrypted_key($data->id, "encrypt")) . '" href="#" class="btn btn-sm bg-danger-light delete_record_model">
                                                      <i class="far fa-trash-alt"></i> 
                                                  </a>
                                              </div>';
                                  } else {
                                      $actionBtn = '';
                                  }
    
                                  return $actionBtn;
                              })
                              ->rawColumns(['action', 'status'])
                              ->make(true);
              
          } else {
       
             return view('admin.template.program.admin.approval_listing');
          }
              
           }
           //edit Program by admin
  public function adminProgramlistingEdit($id_enc = 0) {
    $objUser = Auth::user();
    $role_id = !empty($id_enc) ? encrypted_key($id_enc, "decrypt") : 0;
    
    if ($objUser->type != "admin" || empty($role_id)) {
        return redirect()->back()->with('error', __('Permission Denied.'));
    }
    $quedata = \App\Programable_question::get();
    $questions = array();
    $ques = array();
    foreach($quedata as $key => $question){
        $inc = $key+1;
        $ques['type']= $question->type;
        $ques['question']= $question->question;
        $ques['value']= $question->value;
        $questions['question_'.$inc] = $ques; 
    }
    
    $data = \App\Program::find($role_id);
    $program_category = \App\ProgramCategory::orderBy('id', 'ASC')->get();

    return view('admin.template.program.admin.program_edit_form')->with(['data'=>$data,'questions'=>$questions,'program_category'=> $program_category]);
}

public function adminProgramlistingShow ($id) {
    if (Auth::user()->type != 'admin') {
        return redirect()->back()->with('error', __('Permission Denied.'));
    }
        $id = !empty($id) ? encrypted_key($id, "decrypt") : 0;
        $data = \App\Program::where('id',$id)->with('user')->first();
        $quedata = \App\Programable_question::get();
        $questions = array();
        foreach($quedata as $key => $question){
            $inc = $key+1;
          $questions['question_'.$inc] = $question->question; 
        }
     //   dd($data);
        return view('admin.template.program.admin.approval_listing_show')->with(['data'=> $data, 'questions'=>$questions]);

            
           }
           public function adminProgramlisting_change_status(Request $request) {
            $cleanup = $request->except('_token','csrf-token','title','category_id','id');
            //dd($cleanup);
           $datas =  json_encode($cleanup);
        $id = $request->id;
       // $user_id = !empty($id) ? encrypted_key($id, "decrypt") : 0;
        //dd($id);
      
        $approval = \App\Program::find($id);
        $approval->title = $request->title;
        $approval->category_id = $request->category_id;
        $approval->data = $datas;
        
        $approval->update();

         return redirect()->route('adminProgramlisting')->with('success', __('Status Update successfully.'));
    }

    public function adminProgramlisting_destroy($id_enc = 0) {
    $objUser = Auth::user();
    $apply_id = !empty($id_enc) ? encrypted_key($id_enc, "decrypt") : 0;
    if ($objUser->type != "admin" || empty($apply_id)) {
        return redirect()->back()->with('error', __('Permission Denied.'));
    }

    $data = \App\Program::where('id',$apply_id);
    //dd($data);
    $data->delete();
    return redirect()->back()->with('success', __('Deleted.'));
}


public function create_pay(Request $request){
    //dd( $request);
    $user_id = get_domain_user()->id;
  
   
        $user = get_domain_user();
    //dd($user_id,$user);
    $today = date("Y-m-d");
//dd($request);
        $amount = $request->amount;
    
    if(!empty($request->success_message)){
        $success_message = $request->success_message;
    }else{
        $success_message ="You have successfully paid .";
    }
    if(!empty($request->error_message)){
        $error_message = $request->error_message;
    }else{
        $error_message ="There was an error charging your card, please try again.";
    }
    if($amount > 0) {
        $user_name = $request->name;
        $user_email = $request->email;
        if ($user_id) {
            $user_setting = DB::table('website_setting')->where('user_id', $user_id)->where('name','payment_settings')->first();
            $payment = json_decode($user_setting->value,true);
            $stripe_secret_key = $payment['STRIPE_SECRET'];
        }
        $stripe = new \Stripe\StripeClient($stripe_secret_key);

        try {
            $customer = $stripe->customers->create([
                "description" => "User pay for Program ",
                "name" => $user_name,
                "email" => $user_email
            ]);
        } catch (\Exception $e) {

            return response()->json(array(
                'success' => true,
                'message' => $e->getMessage()
            ), 200);
        }

        $card = $this->stripecard($customer->id, $request->token);
        $charge = $this->stripecharges($customer, $amount, "pay from " . $request->name . ".");
//dd( $charge);
       
        $id = !empty($request->program_id) ? encrypted_key($request->program_id, "decrypt") : 0;
        if ($charge->status == "succeeded") {

            $approval = \App\Program::find($id);
            $approval->status = 1;
            $approval->update();
              return response()->json(array(
                    'success' => true,
                    'message'=>$success_message
                ), 200);
            
        }
    }else{
        return response()->json(array(
            'error' => false,
            'message'=>"Please enter Valid details"
        ), 400);
    }



}
public function stripecard($customerId, $token) {
    $user_id = get_domain_user()->id;
    $custom_url = User::where('id', $user_id)->first();
    if ($user_id) {
        $user_setting = DB::table('website_setting')->where('user_id', $user_id)->where('name','payment_settings')->first();
        $payment = json_decode($user_setting->value,true);
        $stripe_secret_key = $payment['STRIPE_SECRET'];
    }
    \Stripe\Stripe::setApiKey($stripe_secret_key);
    $card ="";
    try{
        $card = \Stripe\Customer::createSource(
            $customerId,
            [
                'source' => $token,
            ]
        );
    }catch(\Exception $e){
        return response()->json(array(
            'success' => false,
            'message'=>$e->getMessage()
        ), 400);
    }
    return $card;
}
public function stripecharges($customer, $amount, $description, $seller = NULL) {
  //  $user_id = get_domain_id();
    $user_id = get_domain_user()->id;
    $custom_url = User::where('id', $user_id)->first();
    if ($user_id) {
        $user_setting = DB::table('website_setting')->where('user_id', $user_id)->where('name','payment_settings')->first();
        $payment = json_decode($user_setting->value,true);
        $stripe_secret_key = $payment['STRIPE_SECRET'];
    }
    $charge = "";
    \Stripe\Stripe::setApiKey($stripe_secret_key);
    try{
        $charge = \Stripe\Charge::create([
            "amount" => $amount * 100,
            "currency" => "usd",
            "customer" => $customer,
            "description" => $description
        ]);

    }catch(\Exception $e){
        return response()->json(array(
            'success' => false,
            'message'=>$e->getMessage()
        ), 400);
    }

    return $charge;
}

public function import_audit(Request $request) {
   // dd($request);
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
   //dd($request->file('csv_file'));
//dd(Excel::toArray(new AuditImport, $request->file('csv_file'))[0]);
    if (Excel::toArray(new AuditImport, $request->file('csv_file'))[0]) {
        $data = json_encode(Excel::toArray(new AuditImport, $request->file('csv_file'))[0]);
        $approval = \App\Program::find($request->id);

        $upload = 0;
        foreach(json_decode($data,true) as $key => $orginal){

if (array_key_exists("other_participants",$orginal) && array_key_exists("female_participants",$orginal) && array_key_exists("male_participants",$orginal) && array_key_exists("participant_cost",$orginal) && array_key_exists("city",$orginal) && array_key_exists("state",$orginal) && array_key_exists("participants",$orginal) && array_key_exists("date",$orginal) && array_key_exists("method",$orginal) && array_key_exists("framework",$orginal) ){
   
    $upload = 1;
}
else{
   
return redirect()->back()->with('error', __('please check the csv format'));
//
}
        }
      // dd( $upload );
        $approval->audit_report = $data;
        $approval->update();
//dd(  $approval);
        return redirect()->back()->with('success', __(' CSV Imported successfully.'));
    } else {
        return redirect()->back();
    }
}

public function updateaudit($id) {
    
    return view('admin.template.program.apply_manually_audit')->with(['id'=>$id]);
}
public function updateauditreport(Request $request) {
    $objUser = Auth::user();
    $id = !empty($request->id) ? encrypted_key($request->id, "decrypt") : 0;

    if ($objUser->type == "admin") {
        return redirect()->back()->with('error', __('Permission Denied.'));
    }
    $validate = [];
    $validate = [
//        'city' => 'required',
        'state' => 'required',
//        'participant' => 'required',
        'date' => 'required',
        'method' => 'required',
//        'framework' => 'required',
    ];
    $validator = Validator::make(
                    $request->all(), $validate
    );
    //dd($validator);
    if ($validator->fails()) {
        return redirect()->back()->with('error', $validator->errors());
    }
    $data = array();
    $newdata = array();
//    $data['city'] = $request->city;
    $data['state'] = $request->state;
//    $data['funds'] = $request->total_funds;
    $data['participant_cost'] = $request->participant_cost;
    $data['male_participants'] = $request->male_participant;
    $data['female_participants'] = $request->female_participant;
    $data['other_participants'] = $request->other_participant;
    $data['participants'] = ($request->male_participant??0)+($request->female_participant??0)+($request->other_participant??0);
    $data['date'] = $request->date;
    $data['method'] = $request->method;
//    $data['framework'] = $request->framework;

    $approval = \App\Program::find($id);
    $olddata= json_decode($approval->audit_report,true);
   //dd(  $olddata);
    if(!empty($olddata)){
        if (array_key_exists("state",$olddata)){

       // if(count($olddata) > 1){
        array_push($newdata, $olddata);
array_push($newdata, $data);
        }
        
        else{
            array_push($olddata, $data);
            $newdata = $olddata;
        }
    }
    else{
        $newdata = $data;
    }
    
//dd($newdata);
     $approval->audit_report = $newdata;
     $approval->update();
     return redirect()->back()->with('success', __('Data added successfully.'));
    
}
    
}
