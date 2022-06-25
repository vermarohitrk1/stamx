<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Crypt;
use App\Pathway;
use App\Employer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DataTables;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\User;
use App\Mail\EmailTest;
use Illuminate\Support\Facades\Mail;
use App\Mail\Quotes;
use  App\SMS;
use  App\EMAIL;
use App\Quote;
use App\PathwayInvitation;
use App\Task;
use Carbon\Carbon;

class PathwayController extends Controller
{

  
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $view = 'grid') {
        if (Auth::user()->type != 'mentor') {
            return redirect()->back()->with('error', __('Permission Denied.'));
        } 
      
    
        $authuser = Auth::user();
       
        if ($request->ajax() && !empty($request->blockElementsData)) {
                if (!empty($request->duration)) {
                    $tilldate = Carbon::now()->addMonth($request->duration)->toDateTimeString();
                }
              
               $pathway =  Pathway::where('user_id', $authuser->id);
                       if (!empty($tilldate)) {
                    $pathway->where("created_at", ">", $tilldate);
                }
                        $pathwayids=$pathway->pluck('id')->toArray();
                        $pathway=$pathway->count();
               
         $inv = PathwayInvitation::where('user_id', $authuser->id)->with('pathway');
            if (!empty($tilldate)) {
                    $inv->where("created_at", ">", $tilldate);
                }
                $inv=$inv->count();
                
         $member = PathwayInvitation::whereIn('pathway_id', $pathwayids)->where('status',1);
            if (!empty($tilldate)) {
                    $member->where("created_at", ">", $tilldate);
                }
                $member=$member->count();
                      
         $tasks = Task::whereIn('pathway_id',$pathwayids);
         if (!empty($tilldate)) {
                    $tasks->where("created_at", ">", $tilldate);
                }
        $tasks=$tasks->count();
 
     
       
                        return json_encode([
                    'invitation' => $inv,
                    'member' => $member,
                    'pathway' => $pathway,
                    'task' => $tasks,
                ]);
                
                
                
         }elseif ($request->ajax()) { 
            $data = Pathway::select('*')->where('user_id', $authuser->id)->orderBy('id', 'DESC');
       //  dd( $data );
            return Datatables::of($data)
              //  ->addIndexColumn()
                ->filterColumn('type', function ($query, $keyword) use ($request) {
                    $sql = "type like ?";
                    $query->whereRaw($sql, ["%{$keyword}%"]);
                })
                
                ->addColumn('type', function ($data) {
                    return $data->type;
                })
                ->addColumn('mentor_type', function ($data) {
                    return $data->mentor_type;
                   
                })
                ->addColumn('timeline', function ($data) {
                    return  date('M d, Y', strtotime($data->timeline));
                })
                ->addColumn('dollar', function ($data) {
                    return format_price($data->dollar_value);
                })
               
                ->addColumn('reminder_type', function ($data) {
                    if($data->reminder_type == 'NULL'){
                       return '<span>-</span>';
                    }
                    else{
                        return $data->reminder_type;
                    }
                   
                })
                ->addColumn('invite', function($data){
                    
                    $actionBtn = '<div class="actions text-right">
                                           <a class="btn btn-sm bg-success-light" data-url="' . route('pathway.invite', encrypted_key($data->id, "encrypt")) . '" data-ajax-popup="true" data-size="md" data-title="Invite mentor" href="#">
                                             <i class="fa fa-user-plus"></i>
                                             Invite
                                         </a>
                                         </div>';
                 
           
                 return $actionBtn;
             })
              ->addColumn('action', function($data){
                    
                       $actionBtn = '<div class="actions text-right">
                                             <a class="btn btn-sm bg-success-light" data-title="Edit Category" href="'.url("pathway/show/".encrypted_key($data->id,'encrypt')).'">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a class="btn btn-sm bg-success-light" data-title="Edit Category" href="'.url("pathway/edit/".encrypted_key($data->id,'encrypt')).'">
                                                    <i class="fas fa-pencil-alt"></i>
                                                    
                                                </a>
                                                <a data-url="' . route('pathway.destroy', encrypted_key($data->id, 'encrypt')) . '" href="#" class="btn btn-sm bg-danger-light delete_record_model">
                                                    <i class="far fa-trash-alt"></i> 
                                                </a>
                                            </div>';
                    
              
                    return $actionBtn;
                })
                ->rawColumns(['action','type','certify','reminder_type','timeline','invite'])
                ->make(true);     
               


        }else{
            
            $pathway =  Pathway::where('user_id', $authuser->id)->orderBy('id', 'DESC')->get();
  //  dd($pathway);
            return view('pathways.index', compact("pathway"));
        }
    
    }
    public function invite($id) {
        if (Auth::user()->type != 'mentor') {
            return redirect()->back()->with('error', __('Permission Denied.'));
        } 
        $id = encrypted_key($id, 'decrypt') ?? $id;
        $domain_user= get_domain_user();
        $pathway = Pathway::find($id);
        //dd($pathway);
        $authuser = Auth::user();
       // $categories = $this->getcategory();
		//return view('pathways.create',compact('categories','authuser'));
        $mentor = \App\User::where('type','mentor')->where('created_by',$domain_user->id??Auth::user()->id)->orderBy('id', 'DESC')->get();
       // dd( $mentor);
        return view('pathways.invite')->with(['pathway'=>$pathway,'mentor'=>$mentor]);
    }

    public function create() {
//        try{
//        $url = 'https://api.bls.gov/publicAPI/v2/timeseries/data/';
//            $method = 'POST';
//            $query = array(
//            'seriesid'  => array('APU0000701111'),
//            'startyear' => '2019',
//            'endyear'   => '2021'
//            );
//            $pd = json_encode($query);
//            $contentType = 'Content-Type: application/json';
//            $contentLength = 'Content-Length: ' . strlen($pd);
//            $result = file_get_contents(
//            $url, null, stream_context_create(
//            array(
//            'http' => array(
//            'method' => $method,
//            'header' => $contentType . "\r\n" . $contentLength . "\r\n",
//            'content' => $pd
//            ),
//            )
//            )
//            );
//            //var_dump($http_response_header);
//            $result=!empty($result) ? json_decode($result):'';
////              echo '<pre>';
////        print_r($result);
////        exit;
//            $stem_industry=!empty($result->Results->series[0]->data) ? $result->Results->series[0]->data:'';
//        } catch (Exception $e){
//            $stem_industry='';
//        }
      $stem_industry='';
        $bls_industries = \App\BlsIndustry::selectRaw("CONCAT(name,' (NAICS ',code,')') as custom")->get()->toArray();
        if(!empty($bls_industries)){
            $stem_industry = array_column($bls_industries, 'custom');
        }
      
        if (Auth::user()->type != 'mentor') {
            return redirect()->back()->with('error', __('Permission Denied.'));
        } 
        $authuser = Auth::user();
       // $categories = $this->getcategory();
       $cat_id = \App\CertifyCategory::select('id','name')->where('name','Trade')->first();
       $apprentice_cat_id = \App\CertifyCategory::select('id','name')->where('name','Apprenticeship')->first();
		//return view('pathways.create',compact('categories','authuser'));
        $certify = \App\Certify::orderBy('id', 'DESC')->get();
        $data =  \App\Certify::orderBy('id', 'DESC')->where('category',$cat_id->id)->get();//\App\CertifyCategory::select('id','name')->get();
        $apprenticeship =  \App\Certify::orderBy('id', 'DESC')->where('category',$apprentice_cat_id->id)->get();
        $employer = \App\Employer::select('*')->where('status',1)->get();
        $institution =  \App\Institution::select('id','institution','type')->where('status',1)->get();
        //dd( $institution);
       
        
        return view('pathways.create')->with(['stem_industry'=>$stem_industry,'certify'=>$certify,'data'=>$data,'institution'=>$institution,'employer'=>$employer,'apprenticeship'=>$apprenticeship]);
    }



    public function store(Request $request) {
    //  dd($request);
        $validation = [
             'mentor_type' => 'required',
             'type' => 'required',
             'timeline' => 'required',
             'send_reminder' => 'required',
         
        ];
        $validator = Validator::make(
            $request->all(), $validation
        );

        if($validator->fails())
        {
            return redirect()->back()->with('error', $validator->errors()->first());
        }
      //  dd($request->certify);
        $user = Auth::user();

        if($request->mentor_type == 'student'){
            $reminder = 'NULL';
        }

        $p = Pathway::where('user_id',$user->id)->where('type',$request->type)->where('mentor_type',$request->mentor_type)->count();
        if($p > 0){
            return redirect()->back()->with('error', __('Pathway type already selected.'));	
        }else{
        if($request->send_reminder == 'No'){
              $reminder = 'NULL';
        }else{
            $reminder = $request->reminder_type;
        }
 if (!empty($request->hasFile('tax_certificate'))) {
            $folderPath = "storage/pathways/";
             if (!file_exists($folderPath)) {
File::isDirectory($folderPath) or File::makeDirectory($folderPath, 0777, true, true);
                }
             
                $fileName = 'bid' . time() . "_" . $request->tax_certificate->getClientOriginalName();
               $res= $request->tax_certificate->storeAs('pathways', $fileName);
                $tax_certificate= $fileName;
               
                
        } else {
            $tax_certificate = '';
        }
      
        $pathway = new Pathway;
        $pathway->user_id = $user->id;
        $pathway->type = $request->type;
        $pathway->certify = json_encode($request->certify);
        $pathway->timeline = $request->timeline;
        $pathway->send_reminder = $request->send_reminder;
        $pathway->reminder_type = $reminder;
        $pathway->mentor_type = $request->mentor_type;
        $pathway->wifi = $request->wifi??'';
        $pathway->library = $request->library??'';
        $pathway->home_pc = $request->home_pc??'';
        $pathway->stem_industry = $request->stem_industry??'';
        $pathway->reading_club = $request->reading_club??'';
        $pathway->pha_community = $request->pha_community??'';
        $pathway->pha_community_id = $request->pha_community_id??'';
        $pathway->graduation_year = $request->graduation_year??'';
        $pathway->company = $request->company??'';
        $pathway->tax_exempted = $request->tax_exempted??'';
        $pathway->business_year = $request->business_year??'';
        $pathway->grant_opportunity = $request->grant_opportunity??'';
        $pathway->mayor = $request->mayor??'';
        $pathway->military_base = $request->military_base??'';
        $pathway->probation_parole = $request->probation_parole??'';
        $pathway->justice_officer = $request->justice_officer??'';
        $pathway->sex_offender = $request->sex_offender??'';
        $pathway->expungement = $request->expungement??'';

        $pathway->tax_certificate = $tax_certificate??'';
        if($request->mentor_type == 'student'){
           $pathway->level = $request->level;
            if($request->level == 'K-12'){
           
                $pathway->school = json_encode($request->school);
               // $pathway->catalog = $request->catalog;
                $pathway->gradelevel = $request->gradeLevel;
            }
            if($request->level == 'military'){
                $pathway->branch = $request->branch;
            }
            if($request->level == 'vocational'){
                $pathway->trade_category = $request->trade_category;
             }
             if($request->level == 'college'){
                $pathway->college = json_encode($request->college);
             }
        }
        elseif($request->mentor_type == 'employee'){
            $pathway->employee = $request->employee;
            $pathway->catalog = $request->catalog;
        }
        elseif($request->mentor_type == 'volunteer' || $request->mentor_type == 'justice' ){
            $pathway->catalog = $request->catalog;
        }
        elseif($request->mentor_type == 'veteran'){
            $pathway->discharged = $request->discharged;
            $pathway->branch = $request->branch;
            $pathway->trade_category = $request->trade_category;
        }
        
        
        $dollarresult = \App\SiteSettings::select('value')->where('name', 'pathways_dollar_value')->where('user_id', 1)->first();
            $dollarresponse= !empty($dollarresult->value) ? json_decode($dollarresult->value,true):array();
          $dollaramount=0;
        if(!empty($dollarresponse['ENABLE_DOLLAR_VALUE']) && $dollarresponse['ENABLE_DOLLAR_VALUE']=='on'){
           $allfields=$request->all();
           foreach ($allfields as $i=>$row){;
               $dollaramount +=!empty($dollarresponse[$i]) ? $dollarresponse[$i]:0;
           }
            
        }
        
            $pathway->dollar_value = $dollaramount;
        $pathway->save();

        $user = Auth::user();
        $rolescheck = \App\Role::whereRole($user->type)->first();
        if($rolescheck->role == 'mentor'  ){
            if(checkPlanModule('points')){
                $checkPoint = \Ansezz\Gamify\Point::find(3);
                if(isset($checkPoint) && $checkPoint != null ){
                    if($checkPoint->allow_duplicate == 0){
                        $createPoint = $user->achievePoint($checkPoint);
                    }else{
                        $addPoint = DB::table('pointables')->where('pointable_id', $user->id)->where('point_id', $checkPoint->id)->get();
                        if($addPoint == null){
                            $createPoint = $user->achievePoint($checkPoint);
                        }
                    }
                }   
            }
        }
         return redirect()->route('pathway.get')->with('success', __('Pathway added successfully.'));
    }
    }

    public function edit($id) {
        if (Auth::user()->type != 'mentor') {
            return redirect()->back()->with('error', __('Permission Denied.'));
        } 
    	$id = encrypted_key($id, 'decrypt') ?? $id;
	   $authuser = Auth::user();
     //  $categories = $this->getcategory();
       $pathway = Pathway::find($id);
      // dd($pathway->type);
      $apprentice_cat_id = \App\CertifyCategory::select('id','name')->where('name','Apprenticeship')->first();
      $apprenticeship =  \App\Certify::orderBy('id', 'DESC')->where('category',$apprentice_cat_id->id)->get();
      $certify = \App\Certify::orderBy('id', 'DESC')->get();
      $data =  \App\CertifyCategory::select('id','name')->get();
      $employer = \App\Employer::select('*')->where('status',1)->get();
      $institution =  \App\Institution::select('id','institution','type')->where('status',1)->get();
     // dd( $pathway);
      return view('pathways.edit', compact('pathway','certify','data','employer','institution','apprenticeship'));
    }
    public function show($id) {
        if (Auth::user()->type == 'admin'  ) {
            return redirect()->back()->with('error', __('Permission Denied.'));
        } 
    	$id = encrypted_key($id, 'decrypt') ?? $id;
	   $authuser = Auth::user();
       $pathway = Pathway::find($id);
       $tasks = Task::where('pathway_id',$id)->with('category')->get();
     //  dd( $tasks);
       $pathwayinvi = PathwayInvitation::where('pathway_id',$id)->where('status',1)->get();
       $mentors = array();
       foreach($pathwayinvi as $key => $inviteuser){
            $mentors[$key] = $inviteuser->user_id;
       }
    

       $mentor = \App\User::where('type','mentor')->whereIn('id',$mentors)->orderBy('id', 'DESC')->get();
     //  dd( $mentor);
  
       return view('pathways.show')->with(['pathway'=>$pathway,'mentor'=>$mentor,'tasks'=>$tasks,'id'=>$id]);
    }
    public function timelineshow($id) {
        $timeline = array();
        $timelineData = array();
        $folderPath = "storage/task/icon";
        $folderPathavatar = "storage/app";
        $url  = url()->full();
        if (Auth::user()->type == 'admin') {
            return redirect()->back()->with('error', __('Permission Denied.'));
        } 
    	$id = encrypted_key($id, 'decrypt') ?? $id;
	   $authuser = Auth::user();
       $pathway = Pathway::find($id);
       $tasks = Task::where('pathway_id',$id)->with(['category','comments'])->get();
    //dd($tasks);
       $pathwayinvi = PathwayInvitation::where('pathway_id',$id)->where('status',1)->get();
       $mentors = array();
       foreach($pathwayinvi as $key => $inviteuser){
            $mentors[$key] = $inviteuser->user_id;
            $mentor = \App\User::where('type','mentor')->where('id',$inviteuser->user_id)->orderBy('id', 'DESC')->first();
           
            $timeline['name']= $mentor->name;
            $timeline['type']= 'mentor';
            $timeline['icon']= env('APP_URL').'/'.$folderPathavatar.'/'.$mentor->avatar;
            $timeline['created_at']= $inviteuser->created_at->toDateTimeString();
            $timelineData[] = $timeline;
     
        }
    //   $mentor = \App\User::where('type','mentor')->whereIn('id',$mentors)->orderBy('id', 'DESC')->get();
     // dd( $mentor);
    
    //  dd( env('APP_URL') );
    $timelineupcoming =array();
        $timelineupcoming['name']= 'upcoming';
        $timelineupcoming['icon']=  env('APP_URL').'/'.$folderPath.'/comment1.png';
        $timelineupcoming['created_at']= date("Y-m-d H:i:s");
  
      //dd($timelineData);
      foreach( $tasks as $key => $value){
        $timeline['name']= $value->name;
        $timeline['desc']= $value->description;
        $timeline['type']= 'task';
        $timeline['userurl']= env('APP_URL').'/'.$folderPathavatar.'/'.\App\User::find($value->user_id)->avatar;
        $timeline['icon']=  env('APP_URL').'/'.$folderPath.'/'.$value->category->icon;
        $timeline['created_at']= $value->created_at->toDateTimeString();
        $timelineData[] = $timeline;

        foreach( $value->comments as $key => $value){
            $digits = 1;
          //  $id= rand(pow(10, $digits-1), pow(10, $digits)-1);
            $id= $key+1;
            if($id>7){
                $id= rand(pow(10, $digits-1), pow(10, $digits)-1);
            }
            $id= rand(pow(10, $digits-1), pow(10, $digits)-1);
            $name = 'comment'.$id.'.png';
            $timeline['type']= 'comment';
            $timeline['userurl']=  env('APP_URL').'/'.$folderPathavatar.'/'.\App\User::find($value->created_by)->avatar;
            $timeline['name'] =\App\User::find($value->created_by)->name;
            $timeline['desc']= $value->comment;
            $timeline['icon']= env('APP_URL').'/'.$folderPath.'/'.$name;
            $timeline['created_at']= $value->created_at->toDateTimeString();
            $timelineData[] = $timeline;
    
        }

    }
 
    usort($timelineData, 'self::date_compare');
      //$finaltimeline = array_chunk($timelineData,6);
     // dd($timelineData);
       return view('pathways.timelineshow')->with(['timelineData'=>$timelineData]);
    }
    function date_compare($element1, $element2) {
        //  dd($element1);
          $datetime1 = strtotime($element1['created_at']);
          $datetime2 = strtotime($element2['created_at']);
          return   $datetime2 - $datetime1;
      } 
    public function updateinvitation(Request $request) {
        if( $request->mentor_id != null){
            $id = !empty($request->id) ? encrypted_key($request->id, "decrypt") : 0;
            $pathway = Pathway::find($id);
          
           foreach($request->mentor_id as $key => $invitation){
            $pathinvitation = new PathwayInvitation;
            $pathinvitation->pathway_id = $id;
            $pathinvitation->user_id = $invitation;
            $pathinvitation->status = 0;
            $pathinvitation->seen = 1;
            $pathinvitation->save();
         
///add in donation
            $user = \App\User::find($invitation);
         $data= array(
                    'email' => $user->email,
                    'fname' => $user->name,
                    'phone' => $user->phone,
                );

        
                 $userdata= $user;   
                 $emalbody=[
                    'note'=>'Invitation received successfully!',
                 ];
           
                 $resp = \App\Utility::send_emails($userdata->email, $userdata->name, null, $emalbody,'invitation_received',$userdata);
                
                
         
                
            $response= \App\Contacts::create_contact($data, 'Pathway');
           }
     
            // $pathway->update();
             return redirect()->route('pathway.get')->with('success', __('Pathway updated successfully.'));
        
            
        }
    }
    public function update(Request $request) {
      // dd($request);
        $validation = [
            'mentor_type' => 'required',
            'type' => 'required',
            'timeline' => 'required',
            'send_reminder' => 'required',
        
       ];
       $validator = Validator::make(
           $request->all(), $validation
       );

       if($validator->fails())
       {
           return redirect()->back()->with('error', $validator->errors()->first());
       }
        $user = Auth::user();
        if($request->send_reminder == 'No'){
            $reminder = 'NULL';
        }else{
          $reminder = $request->reminder_type;
        }
        
        if (!empty($request->hasFile('tax_certificate'))) {
            $folderPath = "storage/pathways/";
             if (!file_exists($folderPath)) {
File::isDirectory($folderPath) or File::makeDirectory($folderPath, 0777, true, true);
                }
             
                $fileName = 'bid' . time() . "_" . $request->tax_certificate->getClientOriginalName();
               $res= $request->tax_certificate->storeAs('pathways', $fileName);
                $tax_certificate= $fileName;
               
                
        } else {
            $tax_certificate = '';
        }
        
       $pathway = Pathway::find($request->id);
       $pathway->type  = $request->type;
       $pathway->certify   = json_encode($request->certify);
       $pathway->timeline   = $request->timeline;
       $pathway->send_reminder   = $request->send_reminder;
       $pathway->reminder_type  = $reminder;
       $pathway->mentor_type = $request->mentor_type;
           $pathway->wifi = $request->wifi??'';
        $pathway->library = $request->library??'';
        $pathway->home_pc = $request->home_pc??'';
        $pathway->stem_industry = $request->stem_industry??'';
        $pathway->reading_club = $request->reading_club??'';
        $pathway->pha_community = $request->pha_community??'';
        $pathway->pha_community_id = $request->pha_community_id??'';
        $pathway->graduation_year = $request->graduation_year??'';
        $pathway->company = $request->company??'';
        $pathway->tax_exempted = $request->tax_exempted??'';
        $pathway->business_year = $request->business_year??'';
        $pathway->grant_opportunity = $request->grant_opportunity??'';
        $pathway->mayor = $request->mayor??'';
        $pathway->military_base = $request->military_base??'';
        $pathway->probation_parole = $request->probation_parole??'';
        $pathway->justice_officer = $request->justice_officer??'';
        $pathway->sex_offender = $request->sex_offender??'';
        $pathway->expungement = $request->expungement??'';

        $pathway->tax_certificate = $tax_certificate??'';
       if($request->mentor_type == 'student'){
        $pathway->level = $request->level;
         if($request->level == 'K-12'){
        
             $pathway->school = json_encode($request->school);
            // $pathway->catalog = $request->catalog;
             $pathway->gradelevel = $request->gradeLevel;
         }
         if($request->level == 'military'){
             $pathway->branch = $request->branch;
         }
         if($request->level == 'vocational'){
             $pathway->trade_category = $request->trade_category;
          }
          if($request->level == 'college'){
             $pathway->college = json_encode($request->college);
          }
     }
     elseif($request->mentor_type == 'employee'){
         $pathway->employee = $request->employee;
         $pathway->catalog = $request->catalog;
     }
     elseif($request->mentor_type == 'volunteer' || $request->mentor_type == 'justice' ){
         $pathway->catalog = $request->catalog;
     }
     elseif($request->mentor_type == 'veteran'){
         $pathway->discharged = $request->discharged;
         $pathway->branch = $request->branch;
         $pathway->trade_category = $request->trade_category;
     }
        $pathway->update();
        return redirect()->route('pathway.get')->with('success', __('Pathway updated successfully.'));
    }

    public function destroy($id_enc) {
        
        $objUser = Auth::user();
       
        $id = !empty($id_enc) ? encrypted_key($id_enc, "decrypt") : 0;
       // dd($id);
        if (empty($id)) {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }

        $data = Pathway::find($id);
        $data->delete();
        return redirect()->back()->with('success', __('Deleted.'));
        
    }
    //==============sms==============
    public function SendReminderPerDay()
    {
        $sms=new SMS();
        $sms->sendRemindersPerDay();
       // $this->info('Success! Check your messages.');
    }
    public function SendReminderPerMonth()
    {
        $sms=new SMS();
        $sms->sendRemindersPerMonth();
      //  $this->info('Success! Check your messages.');
    }
    public function SendReminderPerWeek()
    {
        $sms=new SMS();
        $sms->sendRemindersPerWeek();
      //  $this->info('Success! Check your messages.');
    }
//===============mail=================
    public function SendReminderMailPerDay()
    {
        $mail=new EMAIL();
        $mail->sendRemindersPerDay();
       // $this->info('Success! Check your messages.');
    }
    public function SendReminderMailPerMonth()
    {
        $mail=new EMAIL();
        $mail->sendRemindersPerMonth();
        //$this->info('Success! Check your messages.');
    }
    public function SendReminderMailPerWeek()
    {
        $mail=new EMAIL();
        $mail->sendRemindersPerWeek();
        //$this->info('Success! Check your messages.');
    }
    public static function sendEmail($testemail=null) {
        $testemail = 'pulkittyagi229@gmail.com';
        $response=array();

        
         if(!empty($testemail)){
              $mailTo =$testemail;
               // send email
                 try
                 {
                    $resp= Mail::to($mailTo)->send(new \App\Mail\Quotes());
                 //  dd(  $resp);
                     $response['success']= empty($resp) ? "Email sent successfully":$resp;
        return $response;
                 }
                 catch(\Exception $e)
                 {
                     $error = __('E-Mail has been not sent due to SMTP configuration');
                     $response['error']=$error;
        return $response;
                 }
             
          }else{   
     
                $mailTo =$subscriber->email;// $subscriber->email;
              
                 $content->mailto =$mailTo;
                 // send email
                 try
                 {
                    $resp= Mail::to($mailTo)->send(new \App\Mail\Quotes());
                 
                 }
                 catch(\Exception $e)
                 {
                     $error = __('E-Mail has been not sent due to SMTP configuration');
                 }
          }
 
    }

    public function pathwayInvited(Request $request, $view = 'grid') {
        if (Auth::user()->type != 'mentor') {
            return redirect()->back()->with('error', __('Permission Denied.'));
        } 


        $authuser = Auth::user();
      
     // dd($invit_Id);
        if ($request->ajax()) { 
            $authuser = Auth::user();
            $data = PathwayInvitation::where('user_id', $authuser->id)->with('pathway');
             return Datatables::of($data)
               // ->addIndexColumn()
               
                ->addColumn('type', function ($data) {
                    if($data->pathway){
                        return $data->pathway->type;
                    }
                   
                })
                ->addColumn('mentor_type', function ($data) {
                    return $data->pathway->mentor_type;
                   
                })
                ->addColumn('timeline', function ($data) {
                    return date('M d, Y', strtotime($data->pathway->timeline));
                })
               
                ->addColumn('reminder_type', function ($data) {
                    if($data->pathway->reminder_type == 'NULL'){
                       return '<span>-</span>';
                    }
                    else{
                        return $data->pathway->reminder_type;
                    }
                   
                })
                ->addColumn('status', function($data){
                    if($data->status == 0){
                        return '<span class="pending">pending</span>';
                    }
                    if($data->status == 1){
                        return '<span class="accept">accepted</span>';
                    }
                    if($data->status == 2){
                        return '<span class="reject">rejected</span>';
                    }
                   
                 
           
             })
              ->addColumn('action', function($data){
                if($data->status == 1){
                       
                       $actionBtn = '<div class="actions text-right">
                                             <a class="btn btn-sm bg-success-light" data-title="Edit Category" href="'.url("pathway/show/".encrypted_key($data->pathway->id,'encrypt')).'">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a class="btn btn-sm bg-success-light" data-url="' . route('pathway.status', encrypted_key($data->id, "encrypt")) . '" data-ajax-popup="true" data-size="md" data-title="Change Status" href="#">
                                                <i class="fas fa-unlock-alt"></i>
                                                
                                            </a>
                                              
                                            </div>';
                }else{
                    $actionBtn = '<div class="actions text-right">
                    <a class="btn btn-sm bg-success-light" data-url="' . route('pathway.status', encrypted_key($data->id, "encrypt")) . '" data-ajax-popup="true" data-size="md" data-title="Change Status" href="#">
                    <i class="fas fa-unlock-alt"></i>
                    
                </a>
                    <a data-url="' . route('pathway.invitationdestroy', encrypted_key($data->id, 'encrypt')) . '" href="#" class="btn btn-sm bg-danger-light delete_record_model">
                           <i class="far fa-trash-alt"></i> 
                       </a>
                   </div>';

                }
                    
              
                    return $actionBtn;
                })
                ->rawColumns(['action','type','certify','reminder_type','timeline','status','mentor_type'])
                ->make(true);     
               


        }else{
            
            $pathway =  Pathway::where('user_id', $authuser->id)->orderBy('id', 'DESC')->get();
  //  dd($pathway);
            return view('pathways.index', compact("pathway"));
        }
    
    }

    public function status($id) {
        if (Auth::user()->type != 'mentor') {
            return redirect()->back()->with('error', __('Permission Denied.'));
        } 
        $id = encrypted_key($id, 'decrypt') ?? $id;
        
        
        return view('pathways.status')->with('id',$id);
    }

    public function updatestatus(Request $request) {
        //dd($request);
        if( $request->id != null){
           // $id = !empty($request->id) ? encrypted_key($request->id, "decrypt") : 0;
            $pathinvitation = PathwayInvitation::find($request->id);
             $pathinvitation->status = $request->status;
             $pathinvitation->save();
         

           
     
            // $pathway->update();
             return redirect()->route('pathway.get')->with('success', __('Pathway updated successfully.'));
        
            
        }
    }
    public function invitationdestroy($id_enc) {
        
        $objUser = Auth::user();
       
        $id = !empty($id_enc) ? encrypted_key($id_enc, "decrypt") : 0;
       // dd($id);
        if (empty($id)) {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }

        $data = PathwayInvitation::find($id);
      //  dd( $data);
        $data->delete();
        return redirect()->back()->with('success', __('Deleted.'));
        
    }

    public function showtask($id) {
       
       
	 
       $data = Task::select('*')->where('pathway_id', $id)->with('category')->orderBy('id', 'DESC');
       return Datatables::of($data)
       ->addIndexColumn()
       ->filterColumn('name', function ($query, $keyword) use ($data) {
           $sql = "name like ?";
           $query->whereRaw($sql, ["%{$keyword}%"]);
       })
       
       ->addColumn('name', function ($data) {
           return $data->name;
       })
      
       ->addColumn('type', function ($data) {
           if($data->category != null){
            return $data->category->name;
           }
           else{
               return  'not available';
           }
           
       })
       ->addColumn('due_date', function ($data) {
        return date('M d, Y', strtotime($data->due_date));
    })
    ->addColumn('created_by', function ($data) {
        return \App\User::find($data->user_id)->name;
    })
      
       ->addColumn('action', function($data){
        $actionBtn ='';
        $authId = Auth::user()->id;
           $actionBtn .= '<a class="btn btn-sm bg-success-light" href="'. route('task.showtask', encrypted_key($data->id, 'encrypt')) .'"  >
           <i class="fa fa-comment" aria-hidden="true"></i>
           </a>';
           if( $authId == $data->user_id ){
            $actionBtn .= '  <a class="btn btn-sm bg-success-light" data-url="' . route('task.edit', encrypted_key($data->id, "encrypt")) . '" data-ajax-popup="true" data-size="md" data-title="Edit Task" href="#">
            <i class="fas fa-pencil-alt"></i>
            
        </a>
        <a data-url="' . route('task.destroy', encrypted_key($data->id, 'encrypt')) . '" href="#" class="btn btn-sm bg-danger-light delete_record_model">
            <i class="far fa-trash-alt"></i> 
        </a>';
           }
        
        
  
        return $actionBtn;
    })
    
       ->rawColumns(['action','created_by','due_date','type','name'])
       ->make(true);   
    }

    // public function showmentor($id) {
       
    
    //     $authuser = Auth::user();
    //     $data = PathwayInvitation::select('*')->where('pathway_id', $id)->orderBy('id', 'DESC')->with('user');
    //     return Datatables::of($data)
    //     ->addIndexColumn()
    //     ->filterColumn('name', function ($query, $keyword) use ($data) {
    //         $sql = "name like ?";
    //         $query->whereRaw($sql, ["%{$keyword}%"]);
    //     })
        
    //     ->addColumn('name', function ($data) {
    //         return $data->name;
    //     })
       
    //     ->addColumn('type', function ($data) {
    //         return $data->type;
    //     })
    //     ->addColumn('due_date', function ($data) {
    //      return $data->due_date;
    //  })
    //  ->addColumn('created_by', function ($data) {
    //      return \App\User::find($data->user_id)->name;
    //  })
       
    //     ->addColumn('action', function($data){
            
    //         $actionBtn = '<a class="btn btn-sm bg-success-light" data-url="'. route('task.showtask', encrypted_key($data->id, 'encrypt')) .'" data-ajax-popup="true" data-size="md" data-title="Task Detail" href="#">
    //         <i class="fa fa-comment" aria-hidden="true"></i>
    //         </a>';
         
   
    //      return $actionBtn;
    //  })
     
    //     ->rawColumns(['action','created_by','due_date','type','name'])
    //     ->make(true);   
    //  }

    public function change_status(Request $request) {
        //  dd($request);
          $user = Auth::user();
          $path = PathwayInvitation::where('user_id',$user->id)->update(['seen'=> 0]);
    
               return response()->json(
                              [
                                  'success' => true,
                                  'html' => 'success',
                              ]
              );
          
      }
}
