<?php

namespace App\Http\Controllers;

use App\Supportticket;
use App\Supportticketmessage;
use Illuminate\Http\Request;
use App\SupportCategory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\User;
use Twilio\Jwt\ClientToken;
use Twilio\Rest\Client;
use Twilio\Jwt\TaskRouter\WorkerCapability;
use DataTables;
use Carbon\Carbon;
class SupportController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,$view = 'grid') {
        $user = Auth::user();
        $domain_owner = get_domain_user();
       if ($request->ajax() && !empty($request->blockElementsData)) {
                if (!empty($request->duration)) {
                    $tilldate = Carbon::now()->addMonth($request->duration)->toDateTimeString();
                }
                
                  $new = Supportticket::where("submitted_to_id", $user->id)->where("status", "New");
         if (!empty($tilldate)) {
                    $new->where("created_at", ">", $tilldate);
                }
                        $new=$new->count();
        $closed = Supportticket::where("submitted_to_id", $user->id)->where("status", "Closed");
         if (!empty($tilldate)) {
                    $closed->where("created_at", ">", $tilldate);
                }
                        $closed=$closed->count();
        $open = Supportticket::where("submitted_to_id", $user->id)->where("status", "!=", "Closed");
          if (!empty($tilldate)) {
                    $open->where("created_at", ">", $tilldate);
                }
                        $open=$open->count();
        $total_recieved = $closed+$open;
        $sent_new = Supportticket::where("user_id", $user->id)->where("status", "New");
         if (!empty($tilldate)) {
                    $sent_new->where("created_at", ">", $tilldate);
                }
                        $sent_new=$sent_new->count();
        $sent_closed = Supportticket::where("user_id", $user->id)->where("status", "Closed");
        if (!empty($tilldate)) {
                    $sent_closed->where("created_at", ">", $tilldate);
                }
                        $sent_closed=$sent_closed->count();
        $sent_open = Supportticket::where("user_id", $user->id)->where("status", "!=", "Closed");
          if (!empty($tilldate)) {
                    $sent_open->where("created_at", ">", $tilldate);
                }
                        $sent_open=$sent_open->count();
        $sent_total = Supportticket::where("user_id", $user->id);
        if (!empty($tilldate)) {
                    $sent_total->where("created_at", ">", $tilldate);
                }
                        $sent_total=$sent_total->count();
        
        
        
                        return json_encode([
                    'totalreceived' => $total_recieved,
                    'close' => $closed,
                    'open' => $open,
                    'new' => $new,
                    'senttotal' => $sent_total,
                    'sentclose' => $sent_closed,
                    'sentopen' => $sent_open,
                    'sentnew' => $sent_new,
                ]);
                
                
                
         }else{
        $categories = self::getcategory($domain_owner->id??1, 1);
        $title = "Support Dashboard";

        $stats['new'] = Supportticket::where("submitted_to_id", $user->id)->where("status", "New")->count();
        $stats['closed'] = Supportticket::where("submitted_to_id", $user->id)->where("status", "Closed")->count();
        $stats['open'] = Supportticket::where("submitted_to_id", $user->id)->where("status", "!=", "Closed")->count();
        $stats['total_recieved'] = $stats['closed']+$stats['open'];
        $stats['sent_new'] = Supportticket::where("user_id", $user->id)->where("status", "New")->count();
        $stats['sent_closed'] = Supportticket::where("user_id", $user->id)->where("status", "Closed")->count();
        $stats['sent_open'] = Supportticket::where("user_id", $user->id)->where("status", "!=", "Closed")->count();
        $stats['sent_total'] = Supportticket::where("user_id", $user->id)->count();
    }

        return view('support.index', compact('title', 'categories', 'stats'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function view(Request $request) {
        $user = Auth::user();
        $title = "FAQs List";
        if ($request->ajax()) {
//DB::enableQueryLog();
            $support_tickers = Supportticket::orderBy('id', 'DESC');

            //sort
            $sort = '';
            switch ($request->filter_status) {
                case "all":
                    break;
                case "New":
                    $sort = ['New'];
                    break;
                case "Closed":
                    $sort = ['Closed'];
                    break;
                case "Open":
                    $sort = ['Customer Reply', 'Support Reply','New'];
                    break;
            }
            if (!empty($sort)) {
                $support_tickers->whereIn('status', $sort);
            }
            
            switch ($request->filter_type) {
                case "sent":
                    $support_tickers->whereRaw('(user_id=' . $user->id. ') ');
                    break;
                case "recieved":
                    $support_tickers->whereRaw('( submitted_to_id=' . $user->id . ') ');
                    break;
                default:
                    $support_tickers->whereRaw('(user_id=' . $user->id . ' OR submitted_to_id=' . $user->id . ') ');
                    break;
            }

            //status
            if (!empty($request->filter_category)) {
                $support_tickers->where('category_id', $request->filter_category);
            }

            //keyword
            if (!empty($request->keyword)) {
                $support_tickers->WhereRaw('(subject LIKE "%' . $request->keyword . '%" OR ticket LIKE "%'. $request->keyword . '%" )');
            }

            $data = $support_tickers;
//            dd(DB::getQueryLog());
            
//            if (count($data) > 0) {
//                foreach ($data as $row) {
//                    $lastmessage = Supportticket::lastmessages($row->id);
//                    $row->lastmessage = !empty($lastmessage->message) ? $lastmessage->message : '';
//                }
//            }
            return Datatables::of($data)
                ->addIndexColumn()
                ->filterColumn('subject', function($query, $keyword) use ($request) {
                   // $query->WhereRaw('(subject LIKE %' . $keyword . '% OR ticket LIKE %'. $keyword . '%');
                    ;
                })
                ->orderColumn('subject', function ($query, $order) {
                   
                     $query->orderBy('subject', $order);
                 })
                ->addColumn('subject', function ($data) {
                     $sub = '<a href="'.route('support.preview',encrypted_key($data->id,'encrypt')).'"><span class="badge  badge-xs bg-danger-light">'.$data->ticket.'</span><br><span class="badge  badge-xs bg-primary-light">'.ucfirst(substr($data->subject,0,30)).'..</span></a>';
                     return $sub;
                 }) 
                ->addColumn('user', function ($data) {
                       
                       return '<h2 class="table-avatar">
                                                <a href="' . route('profile', ['id' => encrypted_key($data->user_id, 'encrypt')]) . '" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="' . $data->user->getAvatarUrl() . '" alt="Image"></a>
                                                <a href="' . route('profile', ['id' => encrypted_key($data->user_id, 'encrypt')]) . '">' . $data->user->name . '</a>
                                            </h2>';
                 }) 
                ->addColumn('category', function ($data) {
                     return $data->category->name??'No Category';
                 }) 
                ->addColumn('time', function ($data) {
                     return time_elapsed($data->created_at);
                 }) 
              
                ->addColumn('type', function ($data) {
                      
                    $status=($data->submitted_to_id==Auth::user()->id)?'Received':'Sent';
                    $class=($data->submitted_to_id==Auth::user()->id)?'warning':'info';

                 $slots= '<span class="badge  badge-xs bg-'.$class.'-light"> '.$status.'</span>';
                  
                 
                 return $slots;
                 }) 
                ->addColumn('status', function ($data) {
                     
                 $slots= '';
                  if($data->status == "Support Reply"){
                      $slots .= '<span class="badge  badge-xs bg-primary-light">Support Reply</span>';
                  }else if($data->status == "New" || $data->status == "Customer Reply"){
                      $slots .= '<span class="badge  badge-xs bg-danger-light">'.$data->status .'</span>';
                }else{
                    $slots .= '<span class="badge  badge-xs bg-success-light">Closed</span>';
                }
                 
                 return $slots;
                 }) 
              
                ->rawColumns(['subject','user','time','status','category','type'])
                ->make(true);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) {
        $user = Auth::user();
        if ($user->type != "admin") {
            $title = "New Ticket";
             $permissions=permissions();
        if(in_array("manage_help_desk",$permissions) || checkPlanModule('supporttickets')){          
                $domain_owner_id = 1;
            } else {
                $domain_owner_id = get_domain_user()->id??1;
            }
            $categories = self::getcategory($domain_owner_id);
            
           $entity_type=$request->entity_type??'';
           $entity_id=$request->entity_id??'';
           $entity_for=$request->for??'';
            return view('support.form', compact('title', 'categories','entity_type','entity_id','entity_for'));
        }
        return redirect()->back()->with('error', __('Permission Denied.'));
    }

    /*
     * All Categories List 
     */

    public function getcategory($user_id = 0, $all = null) {
        if (!empty($all)) {
            $login_user_id = Auth::user()->id;
            $array = [0, $user_id, $login_user_id];
        } elseif (!empty($user_id)) {
            $array = [0, $user_id];
        } else {
            $user_id = Auth::user()->id;
            $array = [0, $user_id];
        }
        $categories = SupportCategory::whereIn('user_id', $array)
                ->get();
        return $categories;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $user = Auth::user();
        $validation = [
            'subject' => 'required|max:200|min:20',
            'message' => 'required|max:500|min:50',
            'category' => 'required',
            'file' => 'max:20480|mimes:png,jpg,jpeg,txt,pdf,doc,docx'
        ];
        $validator = Validator::make(
                        $request->all(), $validation
        );

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $ticket = new Supportticket();
          $permissions=permissions();
        if(in_array("manage_help_desk",$permissions) || checkPlanModule('supporttickets')){          
                $domain_owner_id = 1;
            } else {
                $domain_owner_id = get_domain_user()->id??1;
            }
            
            if(!empty($request->entity_for)){
              $domain_owner_id=  $request->entity_for;
            }
            
        $ticket['submitted_to_id'] = $domain_owner_id;
        $ticket['user_id'] = $user->id;
        $ticket['category_id'] = $request->category;
        $ticket['subject'] = $request->subject;
        $ticket['entity_id'] = $request->entity_id??0;
        $ticket['entity_type'] = $request->entity_type??'';
        $ticket['ticket'] = "TK-" . time();
        $ticket->save();
        if ($ticket) {
            $data = new Supportticketmessage();
            $data['ticket_id'] = $ticket->id;
            $data['user_id'] = $user->id;
            $data['message'] = $request->message;

            if (!empty($request->file)) {
                $fileName = 'bid' . time() . "_" . $request->file->getClientOriginalName();
                $request->file->storeAs('ticketfiles', $fileName);
                $data['file'] = $fileName;
            }
            $data->save();
        }


        if ($data) {
            try {


                $submitted_to_id = $domain_owner_id;
                $submitted_to_data = \App\User::where('id', $submitted_to_id)->first();

                $ticket = Supportticket::where('id', $ticket->id)->first();

                $subject = 'New Ticket : ' . $ticket->ticket;
                $email = $submitted_to_data->email;
                $name = $submitted_to_data->name;
                $body = '<h1>Hi, There is a new ticket' . $ticket->ticket . ' from a customer.</h1>
                       <br>To view details pleas click here on this link. <br>' . route('support.preview', encrypted_key($ticket->id, 'encrypt')) . '</p>';
                //sending email
                send_email($email, $name, $subject, $body);

                //send sms
                $phone_number = $submitted_to_data->phone;
                $from_user_id = $ticket->user_id;
                $message = 'Hi, there is a new ticket: ' . $ticket->ticket . ' from a customer. Click here to see details. ' . route('support.preview', encrypted_key($ticket->id, 'encrypt'));

                //send_sms($phone_number, $from_user_id, $message);
            } catch (Exception $ex) {
                //  print_r($ex);
            }
            return redirect()->route('support.index')->with('success', __('Added successfully.'));
        }
        return redirect()->back()->with('error', __('Permission Denied.'));
    }

    //store recieved reply
    public function replystore(Request $request) {
        $user = Auth::user();
     
        $validation = [
            'message' => 'required|max:500|min:50',
            'file' => 'max:20480|mimes:png,jpg,jpeg,txt,pdf,doc,docx',
        ];
        $validator = Validator::make(
                        $request->all(), $validation
        );

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }
        $ticket = new Supportticketmessage();
        $ticket['ticket_id'] = $request->ticket_id;
        $ticket['user_id'] = $user->id;
        $ticket['message'] = $request->message;
        $ticket['sender_type'] = $request->sender_type;
        if (!empty($request->file)) {
            $fileName = 'ticket' . time() . "_" . $request->file->getClientOriginalName();
            $request->file->storeAs('ticketfiles', $fileName);
            $ticket['file'] = $fileName;
        }
        $ticket->save();
  
        //updateing status
        if ($request->sender_type == "Support") {
            $update_status = "Support Reply";
        } else {
            $update_status = "Customer Reply";
        }
        $data = Supportticket::where('id', $request->ticket_id)->first();
        $post['status'] = $update_status;
        $data->update($post);

        if ($ticket) {
            try {
                $ticket = Supportticket::where('id', $request->ticket_id)->first();
                if ($request->sender_type == "Support") {
                    //send email
                    $subject = 'Support reply on ticket : ' . $ticket->ticket;
                    $email = $ticket->user->email??'';
                    $name = $ticket->user->name??'';
                    $body = '<h1>Hi, There is a reply on ticket from support.</h1>
                                   <br>To view details please click here on this link. <br>' . route('support.preview', encrypted_key($ticket->id, 'encrypt')) . '</p>';


                    //send sms
                    $phone_number = $ticket->user->phone??'';
                    $from_user_id = $ticket->submitted_to_id;
                    $message = 'Hi, ' . ($ticket->user->name??'') . ', There is a reply from support on ticket: ' . $ticket->ticket . '. Click here to see details. ' . route('support.preview', encrypted_key($ticket->id, 'encrypt'));
                } else {

                    $submitted_to_data = \App\User::where('id', $ticket->submitted_to_id)->first();

                    //send email
                    $subject = 'Customer reply on ticket : ' . $ticket->ticket;
                    $email = $submitted_to_data->email;
                    $name = $submitted_to_data->name;
                    $body = '<h1>Hi, There is a reply on ticket from' . ($ticket->user->name??'') . '!</h1>
                                   <br>To view details pleas click here on this link. <br>' . route('support.preview', encrypted_key($ticket->id, 'encrypt')) . '</p>';

                    //send sms
                    $phone_number = $submitted_to_data->phone;
                    $from_user_id = $ticket->user_id;
                    $message = 'Hi, ' . $submitted_to_data->name . ', There is a reply from customer on ticket: ' . $ticket->ticket . '. Click here to see details. ' . route('support.preview', encrypted_key($ticket->id, 'encrypt'));
                }

                try{
                //sending email
                send_email($email, $name, $subject, $body);
                    } catch (Exception $ex) {
                    
                }

              //  send_sms($phone_number, $from_user_id, $message);
            } catch (Exception $ex) {
                //  print_r($ex);
            }

            return redirect()->back()->with('success', __('Send successfully.'));
        }
        return redirect()->back()->with('error', __('Permission Denied.'));
    }

    //close ticket
    public function close($id) {

        $user = Auth::user();
        $id = !empty($id) ? encrypted_key($id, 'decrypt') : 0;

        if (!empty($id)) {
            $data = Supportticket::where('id', $id)->first();
            $post['status'] = "Closed";
            $data->update($post);

            if ($data) {
                return redirect()->back()->with('success', __('Closed successfully.'));
            }
        }
        return redirect()->back()->with('error', __('Permission Denied.'));
    }

    //reopen ticket
    public function reopen($encrypted_id = null) {

        $user = Auth::user();
        $id = !empty($encrypted_id) ? encrypted_key($encrypted_id, 'decrypt') : 0;

        if (!empty($id)) {
            $data = Supportticket::where('id', $id)->first();
            //updateing status
            if($data->user_id==$user->id){
            $data->status = "Customer Reply";
            }else{
                 $data->status = "Support Reply";
            }
            $data->save();
            if ($data) {
                return redirect()->back()->with('success', __('Ticket is reopened successfully.'));
            }
        }
        return redirect()->back()->with('error', __('Permission Denied.'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updatesettings(Request $request) {
        $user = Auth::user();
    
            $validation = [
                'close_days' => 'required|max:30|min:1',
            ];
            $validator = Validator::make(
                            $request->all(), $validation
            );

            if ($validator->fails()) {
                return redirect()->back()->withInput()->withErrors($validator);
            }

            $id = !empty($request->id) ? encrypted_key($request->id, 'decrypt') : 0;
            if (!empty($id)) {
                $data = \App\Supportsetting::where('id', $id)->where('user_id', $user->id)->first();
                $post['close_days'] = $request->close_days;
                $data->update($post);
                if ($data) {
                    return redirect()->route('support.index')->with('success', __('Record updated successfully.'));
                }
            } else {
                $data = new \App\Supportsetting();
                $data['user_id'] = $user->id;
                $data['close_days'] = $request->close_days;
                $data->save();
                if ($data) {
                    return redirect()->route('support.index')->with('success', __('Record added successfully.'));
                }
            }
      
    }

    //preview ticket details
    public function preview($id_encrypted = 0) {
        $user = Auth::user();
        $id = !empty($id_encrypted) ? encrypted_key($id_encrypted, 'decrypt') : 0;
        if (!empty($id)) {
            $title = "Ticket Preview";
            $data = Supportticket::where('id', $id)->first();
            if (!empty($data->id)) {
                $messages = Supportticketmessage::where('ticket_id', $data->id)->get();

                return view('support.ticketpreview', compact('title', 'data', 'messages'));
            }
        }
        return redirect()->back()->with('error', __('Permission Denied.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Support  $support
     * @return \Illuminate\Http\Response
     */
    public function show(Support $support) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Support  $support
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Support $support) {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function settings() {
        $user = Auth::user();
        $permissions=permissions();
        if(in_array("manage_help_desk",$permissions) || $user->type =="admin" || checkPlanModule('supporttickets')){
            $title = "Support Closed Settings";
            $data = \App\Supportsetting::where('user_id', $user->id)->first();
            return view('support.settings', compact('title', 'data'));
        }
        return redirect()->back()->with('error', __('Permission Denied.'));
    }
    public function matchingfaqs(Request $request) {
    $html='';
        if(!empty($request->subject)){
            $data = \App\Faq::whereRaw("match(question) against('".$request->subject."')")->limit(5)->get();
            if(!empty($data) && count($data)>0){
                 $html.='<h4 class="form-control-label text-warning">You may get quick help from here.</h4><div class="bs-example col-md-12">
    <div class="accordion" id="accordionExample">';
                foreach($data as $row){
                       $html .='<div class="card  01 pagify-child">
            <div class="card-header" id="q-'.$row->id.'">
                <h2 class="mb-0">
                    <button type="button" class="btn btn-link" data-toggle="collapse" data-target="#cola-'.$row->id.'"><i class="fa fa-angle-right"></i> '.$row->question.'</button>	
                    
                </h2>
                
            </div>
            <div id="cola-'.$row->id.'" class="collapse" aria-labelledby="q-'.$row->id.'" data-parent="#accordionExample">
                <div class="card-body">
                    <p><span class="badge bade-default">Answer:</span> '.$row->answer.'</p>
                </div>
            </div>
        </div>';   
                }
                $html .='</div>
</div>';
            }
      
        }
        return $html;
    }

    //auto close ticket
    public function autoclose(Request $request) {

        $settings = \App\Supportsetting::whereRaw('close_days !=0 AND close_days !=""')->get();
        if (!empty($settings) && count($settings) > 0) {
            foreach ($settings as $setting) {
                $tickets = Supportticket::where('submitted_to_id', $setting->user_id)->where('status', '!=', 'Closed')->whereRaw('updated_at <= DATE_ADD(NOW(), INTERVAL -' . $setting->close_days . ' DAY)')->get();
                if (!empty($tickets) && count($tickets) > 0) {
                    foreach ($tickets as $ticket) {
                        $update['status'] = "Closed";
                        if ($ticket) {
                            $ticket->update($update);
                        }
                        try {
                            $subject = 'Auto Closed Ticked: ' . $ticket->ticket;
                            $email = $ticket->user->email??'';
                            $name = $ticket->user->name??'';
                            $body = '<h1>Hi, ' . ($ticket->user->name??'') . '!</h1><br><p>Its been ' . $setting->close_days . ' days! We have not gotten a reply to ticket: ' . $ticket->ticket . '
                                   <br>If you still need help, please reopen ticket number ' . $ticket->ticket . '</p>';
                            //sending email
                            send_email($email, $name, $subject, $body);


                            //send sms
                            $phone_number = $ticket->user->phone??'';
                            $from_user_id = $ticket->submitted_to_id;
                            $message = 'Hi, ' . ($ticket->user->name??'') . '!, Its been ' . $setting->close_days . ' days! We have not gotten a reply to ticket: ' . $ticket->ticket . '. If you still need help, please reopen the ticket. ';
                            send_sms($phone_number, $from_user_id, $message);
                        } catch (Exception $ex) {
                            //  print_r($ex);
                        }
                    }
                }
            }
        }
        
        
        //auto closing bids after 14 days. 
        $servicerequests = \App\ServiceRequest::where('status', 'Active')->whereRaw('updated_at <= DATE_ADD(NOW(), INTERVAL -14 DAY)')->get();
      if (!empty($servicerequests) && count($servicerequests) > 0) {
                    foreach ($servicerequests as $request) {
                       
                        try {
                           $data = \App\ServiceRequest::find($request->id);
                           $post=array();
                            $post['status'] = "unpublished";
                            $data->update($post);
                            
                             $subject = 'Sun-Published Service Request ';
                            $email = ($request->user->email??'');
                            $name = ($request->user->name??'');
                            $body = '<h1>Hi, ' . ($request->user->name??'') . '!</h1><br><p>Your one of service request was active from last 14 days, It has been closed. Login to your account to see more details.</p>';
                            //sending email
                            send_email($email, $name, $subject, $body);
                            
                            
                        } catch (Exception $ex) {

                        }
                        
                    }
        }
        
        return 1;
    }

}
