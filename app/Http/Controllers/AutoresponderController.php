<?php

namespace App\Http\Controllers;


use Illuminate\Support\Str;
use Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use App\User;
use App\Contacts;
use App\ContactFolder;
use App\Autoresponders;
use DataTables;
use Carbon\Carbon;
class AutoresponderController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $user;

    public function index(Request $request) {
        $authuser = Auth::user();
         $user=Auth::user();
        $permissions=permissions();
//  if (!in_array("manage_auto_responders",$permissions) && $user->type !="admin")  {
//            return redirect()->back()->with('error', __('Permission Denied.'));
//        } 
        
        
        if ($request->ajax() && !empty($request->blockElementsData)) {
                if (!empty($request->duration)) {
                    $tilldate = Carbon::now()->addMonth($request->duration)->toDateTimeString();
                }
                
                 $total = Autoresponders::where('user',$authuser->id);
         if (!empty($tilldate)) {
                    $total->where("created_at", ">", $tilldate);
                }
                        $total=$total->count();
           $total_inactive = Autoresponders::where('user',$authuser->id)->where("status","Inactive");
         if (!empty($tilldate)) {
                    $total_inactive->where("created_at", ">", $tilldate);
                }
                        $total_inactive=$total_inactive->count();
           $total_folder = Autoresponders::where('user',$authuser->id)->groupBy("folder");
         if (!empty($tilldate)) {
                    $total_folder->where("created_at", ">", $tilldate);
                }
                        $total_folder=$total_folder->count();
           
        
                       
        
                        return json_encode([
                    'folders' => ($total_folder),
                    'inactive' => ($total_inactive),
                    'total' => ($total),
                ]);
                
                
                
         }elseif ($request->ajax()) {
            $data = Autoresponders::select('id','folder','typeTemplate','campaign_name','custom_message','custom_sms','status','typeOnChoice')->where(['user'=>$authuser->id]);
            return Datatables::of($data)
                ->addIndexColumn()
                ->filterColumn('campaign_name', function($query, $keyword) use ($request) {
                    $query->orWhere('autoresponder.campaign_name', 'LIKE', '%' . $keyword . '%')
                   
                    ->orWhere('autoresponder.status', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('autoresponder.typeOnChoice', 'LIKE', '%' . $keyword . '%');
                })
                ->addColumn('campaign_name', function ($data) {
                    $authuser = Auth::user();
                    $success = \App\AutoresponderEmails::where('autoresponder_id',$data->id)->where('sender_id',$authuser->id)->where("status","success")->count();
           $error = \App\AutoresponderEmails::where('autoresponder_id',$data->id)->where('sender_id',$authuser->id)->where("status","error")->count();
                    return $data->campaign_name.'<br><span class="btn btn-xs bg-primary-light mt-1"><b>Total Sent:</b>'.($success+$error).'</span>&nbsp;<span class="btn btn-xs bg-success-light mt-1"><b>Successfull:</b>'.$success.'</span>&nbsp;<span class="btn btn-xs bg-danger-light mt-1"><b>Unsuccessful:</b>'.$error.'</span>';
                 }) 
                ->addColumn('template_name', function ($data) {
                    return $data->typeTemplate.'<br><span class="btn btn-sm bg-primary-light">'.ContactFolder::getfoldername($data->folder).'</span>';
                 }) 

                 ->addColumn('custom_message', function ($data) {
                      return ucfirst(substr($data->custom_message,0,20))."..";
                  })                  
                 ->addColumn('custom_sms', function ($data) {
                      return ucfirst(substr($data->custom_sms,0,20))."..";
                  })                  
                 ->addColumn('status', function ($data) {
                  return  '<span class="status">'. $data->status .'</span>';
                  })
                  ->addColumn('typeOnChoice', function ($data) {
                    return $data->typeOnChoice;
                         })
                   ->addColumn('action', function ($data) {
                    $authuser = Auth::user();
                    $actionBtn = '<div class="actions">
                                        <a  href="'. url('autoresponder/statistics/'.encrypted_key($data->id, "encrypt")).'" class="action-item px-2" data-toggle="tooltip" data-original-title="Statistics">
                                            <i class="fas fa-info"></i>
                                        </a>
                                        <a data-url="'. url('autoresponder/edit/'.$data->id).'" data-ajax-popup="true" data-size="lg" href="#" class="action-item px-2" data-toggle="tooltip" data-original-title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="javascript::void(0);" class="action-item text-danger px-2 delete_record_model" data-url="' . route('autoresponder.destroy', encrypted_key($data->id, 'encrypt')) .'" data-toggle="tooltip" data-original-title="Delete">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
										
                                    </div>';
                    
                    return $actionBtn;
                })
                ->rawColumns(["custom_message","custom_sms","status","action","campaign_name","template_name"])
                ->make(true);
                return view('contacts.autoresponder.index');
        }else{ 

        if (isset($_GET['view'])) {
            $view = 'list';
        }
      
           $total = Autoresponders::where('user',$authuser->id)->count();
           $total_inactive = Autoresponders::where('user',$authuser->id)->where("status","Inactive")->count();
           $total_folder = Autoresponders::where('user',$authuser->id)->groupBy("folder")->count();
       return view('contacts.autoresponder.index', compact( "authuser","total","total_inactive","total_folder"));
       
    }
}

    public function create() {
        $authuser = Auth::user();
         $domain_user= get_domain_user();
        $folders = ContactFolder::where('user_id', $domain_user->id)->get();
        $emailtemplates= \App\EmailTemplate::where('created_by', $authuser->id)->where('show_for','AR')->get();
        return view('contacts.autoresponder.create', compact('authuser', 'folders','emailtemplates'));
       
    }

    public function store(Request $request) {
        $user = Auth::user();
        $validation = [
            'campaign_name' => 'required',
        ];

        $validator = Validator::make(
                        $request->all(), $validation
        );

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        }
        
        if(!empty($request->id)){
        $campaign = Autoresponders::find($request->id); 
        }else{
        $campaign = new Autoresponders();
        }
        $campaign['user'] = $user->id;
        $campaign['typeTemplate'] = $request->typeTemplate;
        $campaign['campaign_name'] = $request->campaign_name;
        $campaign['custom_message'] = $request->custom_message;
        $campaign['custom_sms'] = $request->custom_sms;
        $campaign['folder'] = $request->folder;
        $campaign['typeOnChoice'] = $request->typeOnChoice;
        $campaign['day'] = $request->day ? json_encode($request->day) : NULL;
        $campaign['date'] = $request->date;
        $campaign['time'] = $request->time ? $request->time : NULL;
        $campaign['status'] = $request->status;
        $campaign['email_template_id'] = $request->email_template_id;
        $campaign->save();
        return redirect()->to('autoresponder')->with('success', __('Campaign Saved successfully.'));
    }

    public function edit(Request $request) {
        $autoresponder = Autoresponders::find($request->id);
       
        $authuser = Auth::user();
         
              $domain_user= get_domain_user();
        $folders = ContactFolder::where('user_id', $domain_user->id)->get();
         $emailtemplates= \App\EmailTemplate::where('created_by', $authuser->id)->where('show_for','AR')->get();
        return view('contacts.autoresponder.create', compact('autoresponder','authuser', 'folders','emailtemplates'));
    }
      public function statistics(Request $request,$id_encrypted = 0) {
        $user = Auth::user();
        $id = !empty($id_encrypted) ? encrypted_key($id_encrypted, 'decrypt') : 0;
        
        $authuser = Auth::user();
        if ($request->ajax()) {
            $data1 = \App\AutoresponderSms::select('mobile as cnt','message','status','created_at');
           
            $data = \App\AutoresponderEmails::select('email as cnt','message','status','created_at');
               $data->unionAll($data1);
                 $data->orderBy('created_at','DESC');
                 $data->where('autoresponder_id',$id)->where('sender_id',$authuser->id);
            if ($request->get('status') == '0' ) {
                    $data->where("status","success");
                 }
            if ($request->get('status') == '1' ) {
                    $data->where("status",'!=',"success");
                 }
              
            return Datatables::of($data)
                ->addIndexColumn()
                ->filterColumn('email', function($query, $keyword) use ($request) {
                    $query->orWhere('email', 'LIKE', '%' . $keyword . '%');
                    //$query->orWhere('mobile', 'LIKE', '%' . $keyword . '%');
                })
                ->addColumn('email', function ($data) {
                    return $data->cnt;
                 }) 
               
                 ->addColumn('message', function ($data) {
                    return  $data->message;              
                  })                  
                 ->addColumn('status', function ($data) {
                  return  '<span class="status">'. $data->status .'</span>';
                  })
                 ->addColumn('time', function ($data) {
                   return !empty($data->created_at) ? date('F d, Y h:m:s', strtotime($data->created_at)):'---';
                  })
                 
                ->rawColumns(["message","status","email"])
                ->make(true);
                return view('contacts.autoresponder.compaign_stat');
        }else{ 

        $data = Autoresponders::select('id','typeTemplate','campaign_name','custom_sms','folder','custom_message','status','typeOnChoice')->where(['user'=>$authuser->id,'id'=>$id])->first();
       $success = \App\AutoresponderEmails::where('autoresponder_id',$id)->where('sender_id',$authuser->id)->where("status","success")->count();
       $successsms = \App\AutoresponderSms::where('autoresponder_id',$id)->where('sender_id',$authuser->id)->where("status","success")->count();
           $unsuccess = \App\AutoresponderEmails::where('autoresponder_id',$id)->where('sender_id',$authuser->id)->where("status","error")->count();
           $unsuccesssms = \App\AutoresponderSms::where('autoresponder_id',$id)->where('sender_id',$authuser->id)->where("status","error")->count();
       return view('contacts.autoresponder.compaign_stat', compact( "authuser","unsuccess","success","unsuccesssms","successsms","id_encrypted","data"));
       
    }
    
    }


    public function destroy($id_enc) {
         $id = !empty($id_enc) ? encrypted_key($id_enc, "decrypt") : 0;
       // dd($id);
        if (empty($id)) {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
        $broadcast = Autoresponders::find($id);
        $broadcast->delete();
        return redirect()->to('autoresponder')->with('success', __('Campaign deleted successfully.'));
    }
   
}
