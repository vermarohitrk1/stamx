<?php

namespace App\Http\Controllers;


use App\User;
use Redirect;
use Auth;
use DB;
use App\ChatInbox;
use App\ChatGroup;
use App\ChatGroupMembers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use DataTables;
use Illuminate\Support\Facades\Validator;


use Twilio\TwiML\VoiceResponse;
use Twilio\Jwt\ClientToken;
use Twilio\Jwt\AccessToken;
use Twilio\Rest\Client;
use Twilio\Jwt\TaskRouter\WorkerCapability;
use Twilio\Jwt\Grants\VideoGrant;
use GuzzleHttp\ClientInterface;

class ChatController extends Controller {
	protected $sid;
protected $token;
protected $key;
protected $secret;
	public function __construct()
{
   $this->sid = config('services.twilio.sid');
   $this->token = config('services.twilio.token');
   $this->key = config('services.twilio.key');
   $this->secret = config('services.twilio.secret');
}


  public function chatGroups(Request $request) {
        $authuser = Auth::user();
        
        if ($request->ajax()) {
            $data = ChatGroupMembers::select('c.*','chat_group_members.user_id as member_id')
                     ->join('chat_group as c', 'c.id', '=', 'chat_group_members.group_id')
                        ->where('chat_group_members.user_id', $authuser->id);

            return Datatables::of($data)
                ->addIndexColumn()
                ->filterColumn('name', function($query, $keyword) use ($request) {
                    $query->where('c.name', 'LIKE', '%' . $keyword . '%');
                })
                ->addColumn('name', function ($data) {
                    return $data->name;
                })
                ->addColumn('description', function ($data) {
                    return ucfirst(substr($data->description,0,15));
                })
                ->addColumn('image', function ($data) {
                    
                    $html ='<div class="media align-items-center">
                                    <div>';
                    if(file_exists( storage_path().'/chat/'.$data->image) && !empty($data->image)){
                                        $html .='<img src="'.asset('storage').'/chat/'. $data->image.'"  class="avatar " alt="...">';
                                    }else{
                                        $html .='<img src="'.asset('public').'/demo23/image/patterns/globe-pattern.png" class="avatar"  alt="img">';
                                         }
                    
                                    $html .='</div>
                                </div>';
                    
                    return $html;
                })
                ->addColumn('role', function ($data) {
                    $authuser = Auth::user();
                    if($authuser->id==$data->user_id){
                       $role="Admin"; 
                       $class="success"; 
                    }else{
                        $role="Member";
                        $class="info";
                    }
                    return '<span class="badge badge-'.$class.'">'.$role.'</span>';
                 }) 
                ->addColumn('members', function ($data) {
                    $authuser = Auth::user();
                    $members = ChatGroupMembers::where('group_id',$data->id)->count();
                    return $members;
                 }) 
               
                   ->addColumn('action', function ($data) {
                    $authuser = Auth::user();
                    $actionBtn = '<div class="actions">
                                        <a href="#" data-url="'. url('chat/group/view/'.encrypted_key($data->id, "encrypt")).'" data-ajax-popup="true" data-size="lg"   class="action-item px-2" data-toggle="tooltip" data-original-title="View Group">
                                            <i class="fas fa-eye"></i>
                                        </a>';
                                        
                                        if($authuser->id==$data->user_id){

                                       $actionBtn .= ' <a  href="'. url('chat/group/edit/'.$data->id).'" class="action-item px-2" data-toggle="tooltip" data-original-title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                      
										 <a data-url="' . route('chat.group.destroy',encrypted_key($data->id,'encrypt')) . '" href="#" class="btn btn-sm bg-danger-light delete_record_model">
                                                    <i class="fas fa-trash-alt"></i> 
                                                </a>';
                                        }

										
                                   $actionBtn .= ' </div>';
                    
                    return $actionBtn;
                })
                ->rawColumns(["name","description","action","image","role","members"])
                ->make(true);
                return view('chat.index');
        }else{ 

           $own = ChatGroup::where('user_id',$authuser->id)->count();
           $others = ChatGroupMembers::where('user_id',$authuser->id)->count();
           $others=$others-$own;
     return view('chat.index', compact( "authuser","own","others"));
       
    }
}

public function chatGroupCreate() {
        $user = Auth::user();
         $users = \App\User::leftjoin('user_contacts as c','c.user_id','=','users.id')
                            //->where('users.type','employee')
                            ->OrderBy('users.id','DESC')
                            ->select('users.*');
           if(in_array($user->type, ["partner","network","participant","caseworker","coach"])){
               $creator_id=\Auth::user()->creatorId();
               $users->whereRaw("(c.parent_id={$user->id} OR c.parent_id={$creator_id} ) and users.id !={$user->id}");
           }else{
               if($user->type=="admin"){
                   $users->whereRaw("(c.parent_id={$user->id} OR users.created_by IN ({$user->id},0) ) and users.id !={$user->id}");
               }else{
               $users->whereRaw("(c.parent_id={$user->id} OR users.created_by={$user->id} ) and users.id !={$user->id}");
               }
           }
           
           $users=$users->get();
       return view('chat.create', compact('users','user'));
       
    }
public function chatGroupEdit($id) {
        $user = Auth::user();
        $data= ChatGroup::find($id);
        if($data->user_id != $user->id){
         return redirect()->back()->with('error', __('Permission Denied.'));   
        }
        $data->members= ChatGroupMembers::where('group_id',$id)->get()->pluck('user_id')->toArray();
         $users = \App\User::leftjoin('user_contacts as c','c.user_id','=','users.id')
                            //->where('users.type','employee')
                            ->OrderBy('users.id','DESC')
                            ->select('users.*');
           if(in_array($user->type, ["partner","network","participant","caseworker","coach"])){
               $creator_id=\Auth::user()->creatorId();
               $users->whereRaw("(c.parent_id={$user->id} OR c.parent_id={$creator_id} ) and users.id !={$user->id}");
           }else{
               if($user->type=="admin"){
                   $users->whereRaw("(c.parent_id={$user->id} OR users.created_by IN ({$user->id},0) ) and users.id !={$user->id}");
               }else{
               $users->whereRaw("(c.parent_id={$user->id} OR users.created_by={$user->id} ) and users.id !={$user->id}");
               }
           }
           
           $users=$users->get();
           
          
       return view('chat.create', compact('users','user','data'));
       
    }
public function chatGroupView($id) {
        $user = Auth::user();
        $id = !empty($id) ? encrypted_key($id, 'decrypt') : 0;
        $data= ChatGroup::find($id);
        $data->members= ChatGroupMembers::where('group_id',$id)->get()->pluck('user_id')->toArray();
         
       return view('chat.groupview', compact('user','data'));
       
    }
    
    public function chatGroupStore(Request $request) {
        $user = Auth::user();
        $id = !empty($request->id) ? encrypted_key($request->id, 'decrypt') : 0;
        $validation = [
                'users' => 'required|min:1',
            ];
            $validator = Validator::make(
                            $request->all(), $validation
            );

            if ($validator->fails()) {
                return redirect()->back()->withInput()->withErrors($validator);
            }
            if(!empty($id)){
             $save = ChatGroup::where('id', $id)->first();
            }else{
               $save = new ChatGroup(); 
            }
            
                        $save['user_id'] = $user->id;
                        $save['name'] = $request->name??"";
                        $save['description'] = $request->description??"";
                         if (!empty($request->image)) {

            $base64_encode = $request->image;
            $folderPath =storage_path()."/chat/";
            $image_parts = explode(";base64,", $base64_encode);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $image = "group" . uniqid() . '.' . $image_type;
            ;
            $file = $folderPath . $image;
            File::makeDirectory($folderPath, $mode = 0777, true, true);
            
            file_put_contents($file, $image_base64);
            $save['image'] = $image;
        }
                       $save->save();
                       
                        if(!empty($id)){
                            $members = ChatGroupMembers::where("group_id",$id);
                            $members->delete();
                        }else{
                            $id=$save->id;
                        }
            
            $save = new ChatGroupMembers();
                        $save['user_id'] = $user->id;
                        $save['group_id'] = $id;
                        $save->save(); 
            foreach ($request->users as $encrypted_user_id) {
                $user_id = !empty($encrypted_user_id) ? encrypted_key($encrypted_user_id, 'decrypt') : 0;
                 if (!empty($user_id)) {                    
                        $save = new ChatGroupMembers();
                        $save['user_id'] = $user_id;
                        $save['group_id'] = $id;
                        $save->save();                  
                }
            }
            return redirect()->route('chat.groups.list')->with('success', __('Successfully created'));
      
    }
     public function destroygroup($id_enc=0) {
		  $id = !empty($id_enc) ? encrypted_key($id_enc, "decrypt") : 0;
        $group = ChatGroup::find($id);
        $group->delete();
        
        $groupmeb = ChatGroupMembers::where("group_id",$id);
        $groupmeb->delete();
        
        $groupchat = ChatInbox::where("group_id",$id);
        $groupchat->delete();
        
        
        return redirect()->route('chat.groups.list')->with('success', __('Group and chat deleted successfully.'));
    }
	
	
	 public function getchatUsersList(Request $request) {
        $authuser = Auth::user();
       
        $page = $request->page;
        $output = '';

        //printing group chats
        if (!empty($request->inbox) && $request->inbox == "group") {
            $chatGroups=ChatGroup::join('chat_group_members as c','c.group_id','=','chat_group.id')
                    ->where('c.user_id', $authuser->id)->get();
			
            if (!empty($chatGroups) && count($chatGroups) > 0) {
                    $groups = null;
                    $usersnochat = array();
                    foreach ($chatGroups as $key => $group) {

                        $lastmessage = ChatInbox::where(['group_id' => $group->group_id])->orderBy('created_at', 'DESC')->first();
					//	dd($lastmessage);
                        if ($lastmessage) {
                            $groups[$lastmessage->created_at->toDateTimeString()] = $group;
                        } else {
                            $usersnochat[$key] = $group;
                        }
                    }

                    if ($groups == null) {
                        $groups = $usersnochat;
                    } else {
                        krsort($groups);
                        $groups = array_merge($groups, $usersnochat);
                    }
                

                    foreach ($groups as $ownerId) {
                    
					  $lastmessagee = ChatInbox::where(['group_id' => $ownerId->group_id])->orderBy('created_at', 'DESC')->first();

                        $output .= "<a href='javascript:void(0);'  class='list-group-item list-group-item-action groupDataMessage ggg' data-id='" . $ownerId->group_id . "'>
			<div class='d-flex align-items-center' data-toggle='tooltip' data-placement='right' data-title=''    data-original-title='' title=''>
			<div>
			<div class='avatar-parent-child'>";
                        $groupInfo=getChatGroupDetails($ownerId->group_id);
                            if(!empty($groupInfo->image) && file_exists( storage_path().'/chat/'.$groupInfo->image )){
                            $output .= "<img alt='Image' src='" . asset('storage') . "/chat/" . $groupInfo->image . "' class='avatar rounded-circle'>";
                        } else {
                            $output .= "   <span class='avatar avatar_c rounded-circle'>" . substr(ucfirst($groupInfo->name), 0, 1) . "</span>"; 
                        }


                            $output .= "<span class='avatar-child '></span> </div></div>";
                      
                        $output .= " <div class='flex-fill ml-3'>
                                            <h6 class='text-sm mb-0 contact-name'>" . ucfirst($groupInfo->name) . "</h6>";



                        if ($lastmessagee) {
							
						
                            $output .= "<p class='text-sm mb-0'> " . substr($lastmessagee->message_text, 0, 10) . "";
                            if (strlen($lastmessagee->message_text) > 10) {

                                $output .= "...";
                            }
                            $output .= " </p>";
                        }

                        $output .= "</div>";

                        $output .= "<div class='chatDivMessage'>";
                        if ($lastmessagee) {
                            $output .= "<p class='allMessageTiming'> " . time_elapsed_string($lastmessagee->created_at) . "
                                                    </p>";
                            if (getGroupMessageCount($ownerId->group_id)) {
                                $output .= "	  <span class='meaasgechat'>" . getGroupMessageCount($ownerId->group_id) . " </span>";
                            }
                        }

                        $output .= "</div>";

                        $output .= "</div></a>";
                    }
                }else{
                  $output .= "<div class='chatDivMessage'>";
                            $output .= "<p class='text-sm mb-0 mt-3'> Empty Groups List";
     
                            $output .= " </p>";
                             $output .= "</div>";
                        
                }
            
            
            
            
            
        } 
        echo $output;
    }
    
    
    
    //video chat from here
    public function video()
{
        
   $rooms = [];
   try {
       $client = new Client($this->sid, $this->token);
       $allRooms = $client->video->rooms->read([]);

        $rooms = array_map(function($room) {
           return $room->uniqueName;
        }, $allRooms);

   } catch (Exception $e) {
       echo "Error: " . $e->getMessage();
   }
     return view('chat.video', compact('rooms'));
}
public function createRoom(Request $request)
{
   $client = new Client($this->sid, $this->token);

   $exists = $client->video->rooms->read([ 'uniqueName' => $request->roomName]);

   if (empty($exists)) {
       $client->video->rooms->create([
           'uniqueName' => $request->roomName,
           'type' => 'group',
           'recordParticipantsOnConnect' => false
       ]);

       \Log::debug("created new room: ".$request->roomName);
   }

   return redirect()->action('ChatController@joinRoom', [
       'roomName' => $request->roomName
   ]);
}
public function joinRoom($roomName)
{
   // A unique identifier for this user
   $identity = Auth::user()->name;

   \Log::debug("joined with identity: $identity");
   $token = new AccessToken($this->sid, $this->key, $this->secret, 3600, $identity);

   $videoGrant = new VideoGrant();
   $videoGrant->setRoom($roomName);

   $token->addGrant($videoGrant);

   return view('chat.room', [ 'accessToken' => $token->toJWT(), 'roomName' => $roomName ]);
}


public function place_video_call(Request $request)
{
  $user_id=$request->user??0;
  $caller=$request->caller??0;
  $type=$request->type??0;
  if($type==="rec"){
    $user=User::find($caller);
  }else{
       $user=User::find($user_id);
  }

    if(!empty($user)){
         if($type==="rec"){
              $roomName="videoRoomNo".$user_id;
         }else{
       $roomName="videoRoomNo".$user->id;
         }
      
   
    try{
    $client = new Client($this->sid, $this->token);
   $exists = $client->video->rooms->read([ 'uniqueName' => $roomName]);
  
    } catch (Exception $e) {
           //echo $e->getMessage();
         return redirect()->back()->with('error', __('Error occured.'));
    }

   if (empty($exists)) {
       $client->video->rooms->create([
           'uniqueName' => $roomName,
           'type' => 'group',
           'recordParticipantsOnConnect' => false
       ]);

       \Log::debug("created new room: ".$roomName);
       
    
   }
    if($type==="rec"){
        
    }else{
           //creating event
         $params=['room'=>$roomName,'caller'=> Auth::user()->name,'caller_id'=>Auth::user()->id];
  event(new \App\Events\MyEvent($params));
    }
   // A unique identifier for this user

   \Log::debug("joined with identity: $user->name");
   $token = new AccessToken($this->sid, $this->key, $this->secret, 3600, $user->name);

   $videoGrant = new VideoGrant();
   $videoGrant->setRoom($roomName);

   $token->addGrant($videoGrant);

   $accessToken=$token->toJWT();
  return view('chat.twiliovideo', compact('user','roomName','accessToken'));
   }else{
        return redirect()->back()->with('error', __('Permission Denied.'));
   }
}
}
