<?php

namespace App\Http\Controllers;

use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;
use Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use App\Contacts;
use App\ContactFolder;
use App\ContactsUnsubscriber;
use App\User;
use DataTables;

use Twilio\TwiML\VoiceResponse;
use Twilio\Jwt\ClientToken;
use Twilio\Rest\Client;
use Twilio\Jwt\TaskRouter\WorkerCapability;
use GuzzleHttp\ClientInterface;
use Carbon\Carbon;
class ContactController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $user;
    public function connection_index(Request $request) {
       
        $authuser = Auth::user();
        $domain_id = get_domain_id();
         $user = Auth::user();
//        if (!in_array("manage_contacts", permissions()) && $user->type !="admin" && !checkPlanModule('contacts')) {
//            return redirect()->back()->with('error', __('Permission Denied.'));
//        }
         
         
         if ($request->ajax() && !empty($request->blockElementsData)) {
                if (!empty($request->duration)) {
                    $tilldate = Carbon::now()->addMonth($request->duration)->toDateTimeString();
                }
                
                $contacts = Contacts::where('domain_id', $domain_id);
         if (!empty($tilldate)) {
                    $contacts->where("created_at", ">", $tilldate);
                }
                        $contacts=$contacts->count();  
                        
                $number = \App\ContactFolder::where('domain_id', $domain_id)->where('name', 'Newsletters')->first();
              if( isset($number->id)){
                $subscribers = Contacts::where('domain_id', $domain_id)->where("folder", $number->id);
        if (!empty($tilldate)) {
                    $subscribers->where("created_at", ">", $tilldate);
                }
                        $subscribers=$subscribers->count();

              }
              else{
                $subscribers = Contacts::where('domain_id', $domain_id)->where("folder", 0);
         if (!empty($tilldate)) {
                    $subscribers->where("created_at", ">", $tilldate);
                }
                        $subscribers=$subscribers->count();

              }
                $unsubscribers = ContactsUnsubscriber::where('domain_id', $domain_id);
          if (!empty($tilldate)) {
                    $unsubscribers->where("created_at", ">", $tilldate);
                }
                        $unsubscribers=$unsubscribers->count();
                    
                        return json_encode([
                    'contacts' => $contacts,
                    'subscribers' => $subscribers,
                    'unsubscribers' => $unsubscribers,
                ]);
                
                
                
         }elseif($request->ajax()) {
            
            $data = Contacts::where('domain_id', $domain_id);
            if(!empty($request->search['value'])){
                $search=$request->search['value']??'';
                 $data->WhereRaw('contacts.fname LIKE "%'.$search.'%" '
                         . 'OR contacts.lname LIKE "%'.$search.'%" '
                         . 'OR contacts.email LIKE "%'.$search.'%" '
                         . 'OR contacts.phone LIKE "%'.$search.'%" '
                         . 'OR contacts.folder LIKE "%'.$search.'%"');
            }
            return Datatables::of($data)
                ->addIndexColumn()
                    ->orderColumn('name', function ($query, $order) {
                     $query->orderBy('id', $order);
                 })
                    ->orderColumn('email', function ($query, $order) {
                     $query->orderBy('email', $order);
                 })
                    ->orderColumn('type', function ($query, $order) {
                     $query->orderBy('type', $order);
                 })
                    ->orderColumn('folder', function ($query, $order) {
                     $query->orderBy('folder', $order);
                 })
                ->filterColumn('fname', function($query, $keyword) use ($request) {
                    $query->WhereRaw('contacts.fname LIKE "%'.$keyword.'%"')
//                    ->orWhere('contacts.lname', 'LIKE', '%' . $keyword . '%')
//                    ->orWhere('contacts.email', 'LIKE', '%' . $keyword . '%')
//                    ->orWhere('contacts.phone', 'LIKE', '%' . $keyword . '%')
//                    ->orWhere('contacts.folder', 'LIKE', '%' . $keyword . '%')
//                    ->orWhere('contacts.type', 'LIKE', '%' . $keyword . '%')
//                    ->orWhere('contacts.sms', 'LIKE', '%' . $keyword . '%')
                    ;
                })
                ->addColumn('name', function ($data) {
                     return '<h2 class="table-avatar">
                                                <a href="#" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="' . $data->getAvatarUrl() . '" alt="Image"></a>
                                                <a href="#">' . $data->fname." ".$data->lname. '</a>
                                            </h2>';
                 }) 
                 
                 ->addColumn('email', function ($data) {
                  return $data->email;
                  })
                  ->addColumn('phone', function ($data) {
                    return mobileNumberFormat($data->phone);
                         })
                 ->addColumn('folder', function ($data) {
                    return is_numeric($data->folder)?\App\ContactFolder::getfoldername($data->folder):$data->folder;
                                 })     
                 ->addColumn('type', function ($data) {
                      return $data->type;
                             }) 
                 ->addColumn('sms', function ($data) {
                       return $data->sms;
                            })
                                 
              ->addColumn('action', function($data){
                    $actionBtn = '<div class="actions text-right">
                                                <a class="btn btn-sm bg-primary-light mt-1" data-title="View Contact" data-ajax-popup="true" data-size="md" data-url="'.route("contact.view",encrypted_key($data->id,'encrypt')).'" href="#">
                                                    <i class="fas fa-eye"></i>
                                                  
                                                </a>
                                                <a class="btn btn-sm bg-success-light mt-1" data-title="Edit " href="'.url("contacts/edit/".encrypted_key($data->id,'encrypt')).'">
                                                    <i class="fas fa-pencil-alt"></i>
                                                 
                                                </a>
                                                <a data-url="' . route('contact.destroy',encrypted_key($data->id,'encrypt')) . '" href="#" class=" mt-1 btn btn-sm bg-danger-light delete_record_model">
                                                    <i class="far fa-trash-alt"></i> 
                                                </a>
                                            </div>';
                    
                   
                return $actionBtn;
            })
                ->rawColumns(['action','name'])
                ->make(true);
        }else{ 
               $userdata = Contacts::where('domain_id', $domain_id)->paginate(10);

                $contacts = Contacts::where('domain_id', $domain_id)->count();              
                $number = \App\ContactFolder::where('domain_id', $domain_id)->where('name', 'Newsletters')->first();
              if( isset($number->id)){
                $subscribers = Contacts::where('domain_id', $domain_id)->where("folder", $number->id)->count();

              }
              else{
                $subscribers = Contacts::where('domain_id', $domain_id)->where("folder", 0)->count();

              }
                $unsubscribers = ContactsUnsubscriber::where('domain_id', $domain_id)->count();
                return view('contacts.index', compact('userdata','contacts','subscribers','unsubscribers'));
    }

    }
    public function unsubscriber_index(Request $request) {
         $authuser = Auth::user();
        $domain_id = get_domain_id();
        if ($request->ajax()) {
            $data = ContactsUnsubscriber::where('domain_id', $domain_id)->orderByDesc('id');
            return Datatables::of($data)
                ->addIndexColumn()
                ->filterColumn('fname', function($query, $keyword) use ($request) {
                    $query->orWhere('contacts.fname', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('contacts.lname', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('contacts.email', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('contacts.phone', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('contacts.folder', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('contacts.type', 'LIKE', '%' . $keyword . '%')
                    ;
                })
                ->addColumn('name', function ($data) {
                     return '<h2 class="table-avatar">
                                                <a href="#" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="' . $data->getAvatarUrl() . '" alt="Image"></a>
                                                <a href="#">' . $data->fname." ".$data->lname. '</a>
                                            </h2>';
                 }) 
                 
                 ->addColumn('email', function ($data) {
                  return $data->email;
                  })
                  ->addColumn('phone', function ($data) {
                    return $data->phone;
                         })
                 ->addColumn('folder', function ($data) {
                   return is_numeric($data->folder)?\App\ContactFolder::getfoldername($data->folder):$data->folder;
                                 })     
                 ->addColumn('type', function ($data) {
                      return $data->type;
                             }) 
                
                                 
            
                ->rawColumns(['action','name'])
                ->make(true);
        }else{ 
       
              return view('contacts.unsubscribers');
    }
    }

    public function connection_create() {
        $authuser = Auth::user();
        $domain_id= get_domain_id();
         $domain_user= get_domain_user();
        $folders = ContactFolder::where('user_id', $domain_user->id)->get();
        return view('contacts.create', compact('authuser', 'folders'));
    }

    public function connection_store(Request $request) {
        $user = Auth::user();
         $domain_id= get_domain_id();
        $validation = [
            'fname' => 'required',
            'lname' => 'required',
        ];

        $validator = Validator::make(
                        $request->all(), $validation
        );

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        }
        if(!empty($request->email)){
          if(empty(check_email_is_valid($request->email))){
                return redirect()->back()->with('error', 'Invalid email provided');
                }
        }
        $image='';
        if (!empty($request->image)) {
                $base64_encode = $request->image;
                $folderPath = "storage/contact/";
                if (!file_exists($folderPath)) {
File::isDirectory($folderPath) or File::makeDirectory($folderPath, 0777, true, true);
                }
                $image_parts = explode(";base64,", $base64_encode);
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_type = $image_type_aux[1];
                $image_base64 = base64_decode($image_parts[1]);
                $image = "contact". uniqid() . '.'.$image_type;;
                $file = $folderPath.$image;
                file_put_contents($file, $image_base64);
              }
        $contact = new Contacts();
        $contact['user_id'] = $user->id;
        $contact['domain_id'] = $domain_id;
        $contact['fname'] = $request->fname;
        $contact['lname'] = $request->lname;
        $contact['phone'] = $request->phone;
        $contact['email'] = $request->email;
        $contact['email_subscription'] = !empty($request->email_subscription)?json_encode($request->email_subscription):'';
        $contact['sms_subscription'] = !empty($request->sms_subscription)?json_encode($request->sms_subscription):'';;
      
        $contact['type'] = $request->type;
        $contact['folder'] = $request->folder;
        $contact['avatar'] = $image;
        $contact->save();
        return redirect()->to('contacts')->with('success', __('Contact Created successfully.'));
    }
 public function connections_view(Request $request, $id=0) {
        $user = Auth::user();
       $id = encrypted_key($id, 'decrypt') ?? $id;
        if ($id == '') {
            return redirect()->back()->with('error', __('Id is mismatch.'));
        } 
       
            
        $contact = Contacts::find($id);
        $authuser = Auth::user();
        $domain_id= get_domain_id();
        $domain_usesr= get_domain_user();
         $folders = ContactFolder::where('domain_id', $domain_id)->get();
         
            $twilio_settings=\App\SiteSettings::getValByName('twilio_key');             
        $accountSid = $twilio_settings['twilio_account_sid']??"";     
        $authToken = $twilio_settings['twilio_auth_token']??"";
       $callnumber=$twilio_settings['twilio_number']??"";
        $appSid ="";/// User::userSettingsInfo($domain_usesr->id, 'twiml_app_sid');
        $capability = new ClientToken($accountSid, $authToken);
        $capability->allowClientOutgoing($appSid);
        $token = $capability->generateToken(); 
      
        return view('contacts.details', compact('authuser','contact','folders','callnumber','token'));
        
    }
    public function connections_edit($id=0) {
        $domain_id= get_domain_id();
          $id = encrypted_key($id, 'decrypt') ?? $id;
        if ($id == '') {
            return redirect()->back()->with('error', __('Id is mismatch.'));
        } 
        $contact = Contacts::find($id);
         $domain_user= get_domain_user();
        $folders = ContactFolder::where('user_id', $domain_user->id)->get();
        return view('contacts.edit', compact('contact', 'folders'));
    }

    public function connections_update(Request $request) {
         if(!empty($request->email)){
          if(empty(check_email_is_valid($request->email))){
                return redirect()->back()->with('error', 'Invalid email provided');
                }
        }
        $image='';
         $domain_id= get_domain_id();
        if (!empty($request->image)) {
                $base64_encode = $request->image;
                $folderPath = "storage/contact/";
                if (!file_exists($folderPath)) {
File::isDirectory($folderPath) or File::makeDirectory($folderPath, 0777, true, true);
                }
                $image_parts = explode(";base64,", $base64_encode);
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_type = $image_type_aux[1];
                $image_base64 = base64_decode($image_parts[1]);
                $image = "contact". uniqid() . '.'.$image_type;;
                $file = $folderPath.$image;
                file_put_contents($file, $image_base64);
              }
              
        $contact_detail = Contacts::find($request->id);
        $contact['user_id'] = Auth::id();
        $contact['domain_id'] = $domain_id;
        $contact['fullname'] = $request->fname." ".$request->lname;
        $contact['fname'] = $request->fname;
        $contact['lname'] = $request->lname;
        $contact['phone'] = $request->phone;
        $contact['email'] = $request->email;
              $contact['email_subscription'] = !empty($request->email_subscription)?json_encode($request->email_subscription):'';
        $contact['sms_subscription'] = !empty($request->sms_subscription)?json_encode($request->sms_subscription):'';;
      
        $contact['type'] = $request->type;
        if(!empty($image)){
        $contact['avatar'] = $image;
        }
        $contact['folder'] = $request->folder;
        $contact_detail->update($contact);
        return redirect()->to('contacts')->with('success', __('Contact Updated successfully.'));
    }

    public function connections_destroy($id=0) {
          $id = encrypted_key($id, 'decrypt') ?? $id;
        if (empty($id)) {
            return redirect()->back()->with('error', __('Id is mismatch.'));
        } 
        $folder = Contacts::find($id);
        $folder->delete();
        return redirect()->to('contacts')->with('success', __('Contact deleted successfully.'));
    }
public function change_notification_status(Request $request) {
        $user = Auth::user();
        if ($request->ajax() && !empty($request->id)) {
            $domain_id= get_domain_id();
            if($request->id !=-1){
            $data = Contacts::find($request->id);
            }else{
               $data=$user; 
            }
            if(trim($request->type)==1){
                if($request->id !=-1){
               $subscription=!empty($data->email_subscription) ? json_decode($data->email_subscription):array();
            
               if(!empty($subscription) && is_array($subscription)  && in_array($data->folder,$subscription)){
                   if (($key = array_search($data->folder, $subscription)) !== false) {
                            unset($subscription[$key]);
                        }
                   $newdata=!empty($subscription) ? json_encode($subscription):'';
               }else{
                if(is_array($subscription)){
                   array_push($subscription,$data->folder);
                }
                   $newdata=!empty($subscription) ? json_encode($subscription):'';
               }
               $data->email_subscription=$newdata;
                }else{
                    $data->email_notification=!empty($data->email_notification) ? 0:1;
                }
            }else{
                 if($request->id !=-1){
               $subscription=!empty($data->sms_subscription) ? json_decode($data->sms_subscription):array();
                 if(!empty($subscription) && is_array($subscription) && in_array($data->folder,$subscription)){
                    if (($key = array_search($data->folder, $subscription)) !== false) {
                            unset($subscription[$key]);
                        }
                   $newdata=!empty($subscription) ? json_encode($subscription):'';
               }else{
                  
                   if(is_array($subscription)){
                   array_push($subscription,$data->folder);
                }
               
                    $newdata=!empty($subscription) ? json_encode($subscription):'';
               }
               $data->sms_subscription=$newdata;
               
                }else{
                    $data->sms_notification=!empty($data->sms_notification) ? 0:1;
                }
            }
           $data->update();

            return response()->json(
                            [
                                'success' => true,
                                'html' => 'success',
                            ]
            );
        }
    }
    public function notifications_settings(Request $request) {

        $authuser = Auth::user();
        $domain_id= get_domain_id();
        if ($request->ajax()) {
            $data = Contacts::where('domain_id', $domain_id)->whereRaw('(email="'.$authuser->email.'" OR phone="'.$authuser->mobile.'")');
            return Datatables::of($data)
                ->addIndexColumn()
                ->filterColumn('name', function($query, $keyword) use ($request) {
                    $query->orWhere('name', 'LIKE', '%' . $keyword . '%')
                    ;
                })
                ->addColumn('foldername', function ($data) {
                    return \App\ContactFolder::getfoldername($data->folder);
                 })                         
              ->addColumn('email', function($data){
                  $subscription=!empty($data->email_subscription) ? json_decode($data->email_subscription):array();
                     $class = (!empty($subscription) && is_array($subscription) && !empty($data->folder) && in_array($data->folder,$subscription)) ? "checked" : "";
                                return '<div  class="status-toggle d-flex justify-content-center">
                                                <input onclick="changestatus(1,' . $data->id . ')" type="checkbox" id="status_email_' . $data->id . '" class="check" ' . $class . '>
                                                <label for="status_email_' . $data->id . '" class="checktoggle">checkbox</label>
                                            </div>';                     

             
            })
              ->addColumn('sms', function($data){
                  $subscription=!empty($data->sms_subscription) ? json_decode($data->sms_subscription):"";
                     $class = (!empty($subscription) && is_array($subscription) && !empty($data->folder) && in_array($data->folder,$subscription)) ? "checked" : "";
                                return '<div  class="status-toggle d-flex justify-content-center">
                                                <input onclick="changestatus(2,' . $data->id . ')" type="checkbox" id="status_sms_' . $data->id . '" class="check" ' . $class . '>
                                                <label for="status_sms_' . $data->id . '" class="checktoggle">checkbox</label>
                                            </div>';                     

             
            })
             
                ->rawColumns(['email','foldername','sms'])
                ->make(true);
        }
}
    public function folder_index(Request $request) {

        $authuser = Auth::user();
        $domain_id= get_domain_id();
        if ($request->ajax()) {
            $data = ContactFolder::where('domain_id', $domain_id);
            return Datatables::of($data)
                ->addIndexColumn()
                ->filterColumn('name', function($query, $keyword) use ($request) {
                    $query->orWhere('name', 'LIKE', '%' . $keyword . '%')
                    ;
                })
                ->addColumn('name', function ($data) {
                    return $data->name;
                 })                         
              ->addColumn('action', function($data){
                     $actionBtn = '<div class="actions text-right">
                                                <a class="btn btn-sm bg-success-light" data-title="Edit " href="'.url("contacts/folder/edit/".encrypted_key($data->id,'encrypt')).'">
                                                    <i class="fas fa-pencil-alt"></i>
                                                    Edit
                                                </a>
                                                <a data-url="' . route('contact.folder.destroy',encrypted_key($data->id,'encrypt')) . '" href="#" class="btn btn-sm bg-danger-light delete_record_model">
                                                    <i class="far fa-trash-alt"></i> Delete
                                                </a>
                                            </div>';
                     

                return $actionBtn;
            })
                ->rawColumns(['action'])
                ->make(true);
                return view('contact.folder.index');
        }else{ 
      
        return view('contacts.folder.index');
    }
}

    public function folder_create() {
        $authuser = Auth::user();
        return view('contacts.folder.create', compact('authuser'));
    }

    public function folder_store(Request $request) {
        $user = Auth::user();
        $domain_id= get_domain_id();
        $validation = [
            'name' => 'required',
        ];

        $validator = Validator::make(
                        $request->all(), $validation
        );

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        }
        $folder = new ContactFolder();
        $folder['user_id'] = $user->id;
        $folder['domain_id'] = $domain_id;
        $folder['name'] = $request->name;
        $folder->save();
        return redirect()->to('contacts/folder')->with('success', __('Folder Created successfully.'));
    }

    public function folder_edit($id=0) {
         $authuser = Auth::user();
        $id = encrypted_key($id, 'decrypt') ?? $id;
        if ($id == '') {
            return redirect()->back()->with('error', __('Id is mismatch.'));
        } 
        $folder = ContactFolder::find($id);
        return view('contacts.folder.edit', compact('folder'));
    }

    public function folder_update(Request $request) {
         $domain_id= get_domain_id();
        $folder = ContactFolder::find($request->id);
        $detail['user_id'] = Auth::id();
        $detail['name'] = $domain_id;
        $detail['name'] = $request->name;
        $folder->update($detail);
        return redirect()->to('contacts/folder')->with('success', __('Folder Updated successfully.'));
    }

    public function folder_destroy($id) {
        $id = encrypted_key($id, 'decrypt') ?? $id;
        if (empty($id)) {
            return redirect()->back()->with('error', __('Id is mismatch.'));
        } 
        $folder = ContactFolder::find($id);
        $folder->delete();
        return redirect()->to('contacts/folder')->with('success', __('Contact deleted successfully.'));
    }
    
   
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    

    public function index(Request $request) {
        $authuser = Auth::user();
         if ($request->ajax()) {
            $data =  PublicPageDetail::where('user_id', $authuser->id)->whereIn('type', ['Leads', 'Quote'])
                ->orderByDesc('id');
            return Datatables::of($data)
                ->addIndexColumn()
                ->filterColumn('title', function ($query, $keyword) use ($request) {
                    $sql = " public_title like ?";
                    $query->whereRaw($sql, ["%{$keyword}%"]);
                })->addColumn('title', function ($data) {
                    return ucfirst(substr($data->public_title,0,15));
                })
                ->addColumn('image', function ($data) {
                    
                    $html ='<div class="media align-items-center">
                                    <div>';
                    if(file_exists( storage_path().'/contact/'.$data->image) && !empty($data->image)){
                                        $html .='<img src="'.asset('storage').'/contact/'. $data->image.'"  class="avatar " alt="...">';
                                    }else{
                                        $html .='<img src="'.asset('public').'/demo23/image/patterns/globe-pattern.png" class="avatar"  alt="img">';
                                         }
                    
                                    $html .='</div>
                                </div>';
                    
                    return $html;
                })
                ->addColumn('bgimage', function ($data) {
                    
                    $html ='<div class="media align-items-center">
                                    <div>';
                    if(file_exists( storage_path().'/contact/'.$data->bgimage) && !empty($data->bgimage)){
                                        $html .='<img src="'.asset('storage').'/contact/'. $data->bgimage.'"  class="avatar " alt="...">';
                                    }else{
                                        $html .='<img src="'.asset('public').'/demo23/image/patterns/globe-pattern.png" class="avatar"  alt="img">';
                                         }
                    
                                    $html .='</div>
                                </div>';
                    
                    return $html;
                })
                ->addColumn('type', function ($data) {
                    return '<strong>'.($data->type).' </strong>';
                })
                ->addColumn('createddate', function ($data) {
                    return '<strong>'.\App\Utility::getDateFormated($data->created_at).'</strong>';
                })
                 ->addColumn('action', function ($data) {
                    $authuser = Auth::user();
                    $actionBtn = '<div class="actions">
                                        <a href="'. url('contact/page/edit/'.$data->id).'" class="action-item px-2" data-toggle="tooltip" data-original-title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="javascript::void(0);" class="action-item text-danger px-2 destroyblog" data-id="'.$data->id.'" data-toggle="tooltip" data-original-title="Delete">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
										<a href="javascript::void(0);" class="action-item ml-auto px-2"  data-url="'.url('contact/qrcode/'.$data->id).'" data-ajax-popup="true" data-size="lg" data-title="QR Code">
										   <i class="fas fa-qrcode"></i>
										</a>
                                    </div>';
                    
                    return $actionBtn;
                })
                ->rawColumns(['action','createddate','type','bgimage','image','title'])
                ->make(true);
        }else{
        $total_contact = Newconnect::where("user_id", $authuser->id)->count();
        $total_mobile = Newconnect::where("user_id", $authuser->id)->where('sms', 'Yes')->count();
        $total_quote = Quote::where("user_id", $authuser->id)->count();

        $lead = PublicPageDetail::select('id','image','bgimage','public_title','type','created_at')->where('user_id', $authuser->id)->where('type', 'Leads')->first();
        $quote = PublicPageDetail::select('id','image','bgimage','public_title','type','created_at')->where('user_id', $authuser->id)->where('type', 'Quote')->first();
        $leads = PublicPageDetail::select('id','image','bgimage','public_title','type','created_at')->where('user_id', $authuser->id)->where('type', 'Leads')->orWhere('type', 'Quote')->paginate(10);
        return view('contact.index', compact( "authuser", 'lead', 'quote', 'total_contact', 'total_quote', 'total_mobile', 'leads'));
    }
}

    public function view($view = 'grid') {
        $authuser = Auth::user();
        $leads = PublicPageDetail::select('id','image','bgimage','public_title','type','created_at')->where('user_id', $authuser->id)->where('type', 'Leads')->orWhere('type', 'Quote')->get();
        if (isset($_GET['view'])) {
            $view = 'list';
            $returnHTML = view('contact.list', compact('view', 'leads'))->render();
        } else {

            $returnHTML = view('contact.grid', compact('view', 'leads'))->render();
        }

        return response()->json(
                        [
                            'success' => true,
                            'html' => $returnHTML,
                        ]
        );
    }

    public function qrcode(Request $request) {
        $detail = PublicPageDetail::where('id', $request->id)->first();
        if ($detail->type == "Quote") {
            $url = url(base64_encode($detail->id) . '/quote');
        } else {
            $url = url(base64_encode($detail->id) . '/get');
        }

        $ch = curl_init();
        $timeout = 5;
        curl_setopt($ch, CURLOPT_URL, 'http://tinyurl.com/api-create.php?url=' . $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $tinyurl = curl_exec($ch);
        curl_close($ch);
        return view('contact.qrcode', compact('tinyurl', 'url'));
    }

    public function create() {
        $authuser = Auth::user();
        return view('contact.create', compact('authuser'));
    }

    public function create_quote() {
        $authuser = Auth::user();
        return view('contact.create_quote', compact('authuser'));
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
            'public_title' => 'required',
            'public_subtitle' => 'required',
        ];

        if ($request->hasFile('image')) {
            $validation['image'] = 'mimes:jpeg,jpg,png';
        }
        if ($request->hasFile('bgimage')) {
            $validation['bgimage'] = 'mimes:jpeg,jpg,png';
        }
        $validator = Validator::make(
                        $request->all(), $validation
        );

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        }
        $detail = new PublicPageDetail();
        $detail['user_id'] = $user->id;
        $detail['public_title'] = strip_tags($request->public_title);
        $detail['public_subtitle'] = strip_tags($request->public_subtitle);
        $detail['type'] = $request->type;
        if (!empty($request->image)) {
            $base64_encode = $request->image;
            $folderPath = "storage/contact/";
            $image_parts = explode(";base64,", $base64_encode);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $image = "contact" . uniqid() . '.' . $image_type;
            ;
            $file = $folderPath . $image;
            file_put_contents($file, $image_base64);
            $detail['image'] = $image;
        }
        if (!empty($request->bgimage)) {
            $base64_encode = $request->bgimage;
            $folderPath = "storage/contact/";
            $image_parts = explode(";base64,", $base64_encode);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $image = "contact" . uniqid() . '.' . $image_type;
            ;
            $file = $folderPath . $image;
            file_put_contents($file, $image_base64);
            $detail['bgimage'] = $image;
        }


        $detail->save();
        return redirect()->to('contact/page')->with('success', __('Contact Created successfully.'));
    }

    public function destroy(Request $request) {
        $leads = PublicPageDetail::find($request->book_id);
        $leads->delete();
        return redirect()->to('contact/page')->with('success', __('Contact deleted successfully.'));
    }

    public function edit(Request $request) {
        $lead = PublicPageDetail::find($request->id);
        return view('contact.edit', compact('lead'));
    }

    public function update(Request $request) {
        $public_detail = PublicPageDetail::find($request->id);
        $detail['user_id'] = Auth::id();
        $detail['public_title'] = strip_tags($request->public_title);
        $detail['public_subtitle'] = strip_tags($request->public_subtitle);
        $detail['type'] = $request->type;
        if (!empty($request->image)) {
            $base64_encode = $request->image;
            $folderPath = "storage/contact/";
            $image_parts = explode(";base64,", $base64_encode);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $image = "contact" . uniqid() . '.' . $image_type;
            ;
            $file = $folderPath . $image;
            file_put_contents($file, $image_base64);
            $detail['image'] = $image;
        }
        if (!empty($request->bgimage)) {
            $base64_encode = $request->bgimage;
            $folderPath = "storage/contact/";
            $image_parts = explode(";base64,", $base64_encode);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $image = "contact" . uniqid() . '.' . $image_type;
            ;
            $file = $folderPath . $image;
            file_put_contents($file, $image_base64);
            $detail['bgimage'] = $image;
        }
        $public_detail->update($detail);
        return redirect()->to('contact/page')->with('success', __('Contact Updated successfully.'));
    }

    public function public_index_lead(Request $request) {
        $id = base64_decode($request->id);
        $detail = PublicPageDetail::select('id','image','bgimage','public_title','type','created_at')->where('id', $id)->where('type', 'Leads')->first();
        $id = '';
        if ($detail) {
            $id = base64_encode($detail->id);
        }
        return view('contact.public_lead')->with('detail', $detail)->with('id', $id);
    }

    public function public_index_quote(Request $request) {
        $id = base64_decode($request->id);

        $detail = PublicPageDetail::where('id', $id)->where('type', 'Quote')->first();
        $id = '';
        if ($detail) {
            $id = base64_encode($detail->id);
        }
        return view('contact.public_quote')->with('detail', $detail)->with('id', $id);
    }

    public function lead_insert(Request $request) {
        $url = url()->previous();
        $user_id = get_domain_id();
        $emailexist = Newconnect::where('email', $request->email)->where('user_id', $user_id)->first();
        if (!empty($emailexist)) {
            return redirect()->to($url)->with('error', __('Email already exist.'));
        }
        $phoneexist = Newconnect::where('phone', $request->phone)->where('user_id', $user_id)->first();
        if (!empty($phoneexist)) {
            return redirect()->to($url)->with('error', __('Phone already exist.'));
        }
        $detail = new Newconnect();
        $detail['fname'] = $request->fname;
        $detail['lname'] = $request->lname;
        $detail['email'] = $request->email;
        $detail['phone'] = $request->phone;
        $detail['sms'] = $request->sms;
        $detail['user_id'] = $user_id;
        $detail->save();
        return redirect()->to($url)->with('success', __('Details Added successfully.'));
    }

    public function quote_insert(Request $request) {
        $url = url()->previous();
        $user_id = get_domain_id();
        $emailexist = Quote::where('email', $request->email)->where('user_id', $user_id)->first();
        if (!empty($emailexist)) {
            return redirect()->to($url)->with('error', __('Email already exist.'));
        }
        $phoneexist = Quote::where('phone', $request->phone)->where('user_id', $user_id)->first();
        if (!empty($phoneexist)) {
            return redirect()->to($url)->with('error', __('Phone already exist.'));
        }
        $detail = new Quote();
        $detail['fname'] = $request->fname;
        $detail['lname'] = $request->lname;
        $detail['email'] = $request->email;
        $detail['phone'] = $request->phone;
        $detail['website'] = $request->website;
        $detail['website_traffic'] = $request->website_traffic;
        $detail['traffic_sources'] = json_encode($request->traffic_sources);
        $detail['insurance_types'] = json_encode($request->insurance_types);
        $detail['industries'] = json_encode($request->industries);
        $detail['notes'] = $request->notes;
        $detail['user_id'] = $user_id;
        $detail->save();
        return redirect()->to($url)->with('success', __('Details Added successfully.'));
    }

    

    public function csv_export(Request $request) {
        return Excel::download(new ContactExport($request), 'contact.csv', \Maatwebsite\Excel\Excel::CSV);
    }

    public function import_csv(Request $request) {
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
        if ($countheader < 9) {
            if (!str_contains($header, 'First Name')) {
                return response()->json(array(
                            'success' => false,
                            'errors' => __('1st column should be First Name')
                                ), 404);
            }
            if (!str_contains($header, 'Last Name')) {
                return response()->json(array(
                            'success' => false,
                            'errors' => __('2nd column should be Last Name')
                                ), 404);
            }
            if (!str_contains($header, 'Email')) {
                return response()->json(array(
                            'success' => false,
                            'errors' => __('3rd column should be Email')
                                ), 404);
            }
            if (!str_contains($header, 'Phone')) {
                return response()->json(array(
                            'success' => false,
                            'errors' => __('4th column should be Phone')
                                ), 404);
            }
            if (!str_contains($header, 'SMS')) {
                return response()->json(array(
                            'success' => false,
                            'errors' => __('5th column should be SMS')
                                ), 404);
            }
        }
        if (Excel::import(new ContactImport, $request->file('csv_file'))) {
            return redirect()->to('connections')->with('success', __(' CSV Imported successfully.'));
        } else {
            return redirect()->to('connections');
        }
    }

    public function broadcast_index(Request $request) {
        $authuser = Auth::user();
        if ($request->ajax()) {
            $data = Campaigncontact::select('id','campaign_name','custom_message','status','typeOnChoice')->where(['user'=>$authuser->id]);
            return Datatables::of($data)
                ->addIndexColumn()
                ->filterColumn('campaign_name', function($query, $keyword) use ($request) {
                    $query->orWhere('campaign_contact.campaign_name', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('campaign_contact.custom_message', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('campaign_contact.status', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('campaign_contact.typeOnChoice', 'LIKE', '%' . $keyword . '%')
                   
                    ;
                })
                ->addColumn('campaign_name', function ($data) {
                    return $data->campaign_name;
                 }) 

                 ->addColumn('custom_message', function ($data) {
                    return  $data->custom_message;              
                  })                  
                 ->addColumn('status', function ($data) {
                  return  '<span class="status">'. $data->status .'</span>';
                  })
                  ->addColumn('typeOnChoice', function ($data) {
                    return $data->typeOnChoice;
                         })
                ->rawColumns([])
                ->make(true);
                return view('contact.broadcast.index');
        }else{ 

        if (isset($_GET['view'])) {
            $view = 'list';
        }
      
       $accountsid = User::userSettingsInfo($authuser->id,'account_sid');
         $authtoken = User::userSettingsInfo($authuser->id,'auth_token');
        
       if(!empty($accountsid) && !empty($authtoken)){
        $broadcast = new Campaigncontact;
        $broadcast = $broadcast->getbroadcast($all = 'all');
        return view('contact.broadcast.index', compact('broadcast', "authuser"));
        }else{
         return redirect()->back()->with('error', __('Update your twilio settings first'));  
       }
    }
}

    public function broadcast_create() {
        $authuser = Auth::user();
         
        $folders = Folder::where('user_id', Auth::id())->get();
        $callnumber = Smsnumber::where('userid',Auth::user()->id)->get();
        return view('contact.broadcast.create', compact('authuser', 'folders','callnumber'));
       
    }

    public function broadcast_store(Request $request) {
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
        $campaign = new Campaigncontact();
        $campaign['user'] = $user->id;
        $campaign['campaign_name'] = $request->campaign_name;
        $campaign['custom_message'] = $request->custom_message;
        $campaign['folder'] = $request->folder;
        $campaign['sms_number_id'] = $request->sms_number_id;
        $campaign['typeOnChoice'] = $request->typeOnChoice;
        $campaign['day'] = $request->day ? json_encode($request->day) : NULL;
        $campaign['date'] = $request->date;
        $campaign['time'] = $request->time ? $request->time : NULL;
        $campaign['status'] = $request->status;
        $campaign->save();
        return redirect()->to('broadcast')->with('success', __('Campaign Created successfully.'));
    }

    public function broadcast_edit(Request $request) {
        $broadcast = Campaigncontact::find($request->id);
        $folders = Folder::where('user_id', Auth::id())->get();
        $days = '';
        if ($broadcast) {
            $days = json_decode($broadcast->day);
        }
         $callnumber = Smsnumber::where('userid',Auth::user()->id)->get();
        return view('contact.broadcast.edit', compact('broadcast', 'folders', 'days','callnumber'));
    }

    public function broadcast_update(Request $request) {
        $broadcast = Campaigncontact::find($request->id);
        $campaign['user'] = Auth::id();
        $campaign['campaign_name'] = $request->campaign_name;
        $campaign['custom_message'] = $request->custom_message;
        $campaign['folder'] = $request->folder;
        $campaign['typeOnChoice'] = $request->typeOnChoice;
        $campaign['day'] = $request->day ? json_encode($request->day) : NULL;
        $campaign['date'] = $request->date;
        $campaign['sms_number_id'] = $request->sms_number_id;
        $campaign['time'] = $request->time ? $request->time : NULL;
        $campaign['status'] = $request->status;
        $broadcast->update($campaign);
        return redirect()->to('broadcast')->with('success', __('Campaign Updated successfully.'));
    }

    public function broadcast_destroy(Request $request) {
        $broadcast = Campaigncontact::find($request->broadcast_id);
        $broadcast->delete();
        return redirect()->to('broadcast')->with('success', __('Campaign deleted successfully.'));
    }
    public function number_list(Request $request){

        if ($request->ajax()) {
            $data = Smsnumber::select('id','number','name','created_at')->where('userid',Auth::user()->id);
            return Datatables::of($data)
                ->addIndexColumn()
                ->filterColumn('name', function($query, $keyword) use ($request) {
                    $query->orWhere('smsnumbers.name', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('smsnumbers.number', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('smsnumbers.created_at', 'LIKE', '%' . $keyword . '%')  
                    ;
                })
                ->addColumn('number', function ($data) {
                    return $data->number;
                 })  
                 ->addColumn('name', function ($data) {
                    return $data->name;
                 }) 
                 ->addColumn('created_at', function ($data) {
                    return Date('M d, Y H:i:s',strtotime($data->created_at));
                 })                        
              ->addColumn('action', function($data){
                    
                    $actionBtn = '
                <a href="javascript::void(0);" class="action-item text-danger px-2 destroyblog" data-id="'.$data->id.'" data-toggle="tooltip" data-original-title="'.__('Delete').'">
                <i class="fas fa-trash-alt"></i>
                               </a>';

                return $actionBtn;
            })
                ->rawColumns(['action'])
                ->make(true);
                return view('contact.twilio.index');
        }else{

        $callnumber = Smsnumber::where('userid',Auth::user()->id)->get();
        return view('contact.twilio.index',compact('callnumber'));
    }
}
    public function buy_number(Request $request){
        $html ="";
        if(!empty($request->area_code)){
            $area_code = $request->area_code;
            $accountsid = User::userSettingsInfo(1, 'account_sid');
            $authtoken = User::userSettingsInfo(1, 'auth_token');
            $client = new Client($accountsid, $authtoken);
            if( $request->type == 'local'){

                $numbers = $client->availablePhoneNumbers('US')->local->read(
                    array("areaCode" =>  $area_code)
                );

            }else{
                $numbers = $client->availablePhoneNumbers('US')->tollFree->read(
                    array("areaCode" => $area_code)
                );
            }
            if(!empty($numbers)) {
                $html .= '<thead><tr><td>Number</td><td>Address</td><td>Action</td></tr></thead><tbody>';
                foreach ($numbers as $key => $value) {
                    if ($value->capabilities['voice']) {
                        $voice = 1;
                    } else {
                        $voice = 0;
                    }
                    if ($value->capabilities['SMS']) {
                        $sms = 1;
                    } else {
                        $sms = 0;
                    }
                    if ($value->capabilities['MMS']) {
                        $mms = 1;
                    } else {
                        $mms = 0;
                    }
                    if ($value->capabilities['fax']) {
                        $fax = 1;
                    } else {
                        $fax = 0;
                    }
                    if ($value->postalCode != '') {
                        $postalCode = ',' . $value->postalCode;
                    } else {
                        $postalCode = '';
                    }
                    $html .= '<tr><td>' . $value->friendlyName . '</td><td>' . $value->region . ', ' . $value->isoCountry . ' ' . $postalCode . '</td><td><button onclick="buyNumber(' . $value->phoneNumber . ',' . $voice . ',' . $sms . ',' . $mms . ',' . $fax . ')" class="btn btn-success" type="button"  data-toggle="tooltip" title="Buy Now">Buy</button></td></tr>';
                }
                $html .= '</tbody>';
            }else{
                $html .= '<thead><tr><td>Number</td><td>Address</td><td>Action</td></tr></thead><tbody>';
                $html .='<tr><td colspan="3">No Record Found</td></tr>';
                $html .= '</tbody>';
            }
        }
        return view('contact.twilio.buy_numbers')->with('html',$html);
    }
     public function migrate(Request $request){
        if(!empty($request->sid)){
            $data = array();
            $user = Auth::user();
            $accountsid = User::userSettingsInfo(1, 'account_sid');
            $authtoken = User::userSettingsInfo(1, 'auth_token');
            $client = new Client($accountsid, $authtoken);  
            $just_domain = preg_replace("/^(.*\.)?([^.]*\..*)$/", "$2", $_SERVER['HTTP_HOST']);
            $url = 'https://'.$just_domain.'/api/support/call';
            $smsurl = 'https://'.$just_domain.'/twilio/sms/webhook';
            $name = $user->name. ' Numbers';
            try{
                $phone_data = $client->incomingPhoneNumbers($request->sid)
                    ->update(array(
                            "voiceUrl" => $url,
                            "smsUrl" => $smsurl,
                            "friendlyName" =>$name,
                            "voiceMethod" => "GET",
                        )
                    );
                $data['number'] = $phone_data->phoneNumber;
                $data['userid'] = $user->id;
                $data['name'] = $request->sid;
                Smsnumber::insert($data);
                return redirect()->to('broadcast/numbers')->with('success', __('You have successfully activated number.'));
            }catch(\Exception $e){
                return redirect()->back()->with('danger', __('SID is not vaild.Please try agian.'));
            }
        }
    }
    public function buyNumber(Request $request){
        
        $user = Auth::user();
        $accountsid = User::userSettingsInfo(1, 'account_sid');
        $authtoken = User::userSettingsInfo(1, 'auth_token');
        $client = new Client($accountsid, $authtoken);
        $name = $user->name. ' Numbers';
        $phone = '+'.$request->num;
        $just_domain = preg_replace("/^(.*\.)?([^.]*\..*)$/", "$2", $_SERVER['HTTP_HOST']);
        $url = 'https://'.$just_domain.'/api/support/call';
         $smsurl = 'https://'.$just_domain.'/twilio/sms/webhook';
        $number = $client->incomingPhoneNumbers
            ->create(
                array(
                    "phoneNumber" => $request->num
                )
            );
        $array = array(
            "friendlyName" => $name,
            "phoneNumber" => $phone,
            "voiceMethod" => "GET",
            "voiceUrl" => $url,
            "smsUrl" => $smsurl,
                
        );
        $incoming_phone_number = $client->incomingPhoneNumbers
            ->create($array );

        $client->incomingPhoneNumbers($incoming_phone_number->sid)
            ->update(array(
                    "voiceUrl" => $url,
                    "smsUrl" => $smsurl,
                    "friendlyName" =>$name,
                    "voiceMethod" => "GET",
                )
            );
        $data = array();
        $data["number"] = '+'.$request->num;
        $data["name"] =  $incoming_phone_number->sid;
        $data['userid'] = $user->id;
        Smsnumber::insert($data);
        return redirect()->to('broadcast/numbers')->with('success', __('You have successfully activated number.'));

    }
    public function cancelNumber(Request $request){
        $result = Smsnumber::where("id" ,$request->number_id)->first();
        if(!empty($result)){
            $accountsid = User::userSettingsInfo(1, 'account_sid');
            $authtoken = User::userSettingsInfo(1, 'auth_token');
            $client = new Client($accountsid, $authtoken);
            $incomingPhoneNumbers = $client->incomingPhoneNumbers->read(array("phoneNumber" => $result->number),20);
            foreach ($incomingPhoneNumbers as $record) {
                $numbersid = $record->sid;
            }
            $client->incomingPhoneNumbers($numbersid)->delete();
            Smsnumber::where('id',$result->id)->delete();
            return redirect()->back()->with('success', __('You have successfully deactivated your number.'));
        }
    }
    public function sms_thread($contact=0){
       if(!empty($contact)){
            $user = Auth::user();
           $messages= \App\SmsLog::where('from', 'LIKE', '%' . substr($contact,-10) . '%')
                                 ->Orwhere([['to', 'LIKE', '%' . substr($contact,-10) . '%'],['user_id',$user->id]])
                                 ->OrderBy('created_at','ASC')
                                 ->get();
           $contact= \App\Contacts::where('phone','LIKE',  '%' . substr($contact,-10) . '%')->first();
           return view('contacts.sms_thread', compact('messages','contact'));
        }
        return redirect()->back()->with('error', __('Unauthorized'));
    }
    public function connection_view_send_sms(Request $request) {
        $user = Auth::user();
        if ($request->ajax() && !empty($request->sms_body) && !empty($request->id)) {
            $contact = Contacts::find($request->id);
              $domain_user= get_domain_user();
            if(!empty($contact->phone)){
               $returnsuccess = true;
                   $returnHTML = '';
                    try {
                        $resp=\App\SMS::send_common_sms($contact->phone,$request->sms_body,$domain_user->id);
                        
            
                        
                if((!empty($resp['is_success']))  ){
                    $returnHTML="SMS successfully sent";
                    $returnsuccess = true;
                }else{
                    
                $returnHTML = $resp['error'];
                   
                $returnsuccess = false;
                }
                    } catch (\Exception $e) {
                        $returnHTML =$e->getMessage();
                        $returnsuccess = false;
                    }                   
                    
                
            }else{
                $returnHTML="Contact phone not exist";
                $returnsuccess = false;
            }
            return response()->json(
                            [
                                'success' => $returnsuccess,
                                'html' => $returnHTML,
                            ]
            );
        }
    }
    public function connection_view_send_email(Request $request) {
        
        $user = Auth::user();
        if ($request->ajax() && !empty($request->email_body) && !empty($request->id)) {
             $domain_user= get_domain_user();
            $contact = Contacts::find($request->id);
            if(!empty($contact->email)){
                  $subject = $request->email_subject;
                $email = $contact->email;
                $name = ($contact->fname." ".$contact->lname)??"Subscriber";
               $resp= \App\EMAIL::common_send_Email($email, $name, $subject, $request->email_body , $domain_user->id);
          
                if((!empty($resp['is_success']))  ){
                    $returnHTML="Email successfully sent";
                    $returnsuccess = true;
                }else{
                    
                $returnHTML = $resp['error'];
                   
                $returnsuccess = false;
                }
            }else{
                $returnHTML="Connection email not exist";
                $returnsuccess = false;
            }
            return response()->json(
                            [
                                'success' => $returnsuccess,
                                'html' => $returnHTML,
                            ]
            );
        }
    }
    public function twilio_call_initiate(){
       if(!empty($_GET['phone']) || !empty($_GET['agent'])){
            $user = Auth::user();
            
             $domain_user= get_domain_user();
            $agent_number=!empty($_GET['agent']) ? $_GET['agent'] :$user->phone;
            $phone_number=!empty($_GET['phone']) ? $_GET['phone'] :$user->phone;
            
            $twilio_settings="";
        $domain = \App\UserDomain::where(['user_id' => $domain_user->id])->first();
            $setting = \App\SiteSettings::where("name", 'twilio_key')->where('user_domain_id', $domain->id)->first();
            if (!empty($setting->value) && !empty(json_decode($setting->value))) {
                $twilio_settings = json_decode($setting->value, true);
            } elseif (!empty($setting->value)) {
                $twilio_settings = $setting->value;
            }
             
        $accountsid = $twilio_settings['twilio_account_sid']??"";     
        $authtoken = $twilio_settings['twilio_auth_token']??"";
       $twilio_number=$twilio_settings['twilio_number']??"";   
       
       if(!empty($accountsid) && !empty($authtoken) && !empty($twilio_number)){
        try{
              $client = new Client($accountsid, $authtoken);
             $call = $client->calls
               ->create($phone_number, // to
                        $twilio_number, // from
                        [
                            "twiml" => "<Response><Say>Hi, Please wait we are connecting your call with our agent!</Say> <Dial>'.$agent_number.'</Dial></Response>"
                        ]
               );
             }catch(\Exception $e){  
           $error=$e->getMessage()??"Not sent";
        }
              if(!empty($call->sid)){
             return redirect()->back()->with('success', __('call is initiated'));
              }else{
                return redirect()->back()->with('error', $error??'unable to initiate call, something is wrong');  
              }
        }
         return redirect()->back()->with('error', __('Update twilio settings'));
       }
        return redirect()->back()->with('error', __('Unauthorized'));
    }

}
