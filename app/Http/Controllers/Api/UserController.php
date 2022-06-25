<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Mail;
use DataTables;
use Response;
use DB;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Schema;

class UserController extends Controller {

    public function profile(Request $request){
        $user = Auth::user()->toArray();
        foreach ($user as $name => $value) {
            if ($value == null) {
                $user["$name"] = '';
            }
            $user['avatar']=Auth::user()->getAvatarUrl();
        }
        return response()->json($user,200);
//    $user_data = array( 
//                 'id' => $user->id,
//                 'name'=> $user->name,
//                'email' => $user->email,
//                'type' => $user->type,
//                'nickname' => $user->nickname,
//                'dob' => $user->dob,
//                'blood_group' => $user->blood_group,
//                'gender' => $user->gender,
//                'mobile' => $user->mobile,
//                'about' => $user->about,
//                'address1' => $user->address1,
//                'address2' => $user->address2,
//                'city' => $user->city,
//                'state' => $user->state,
//                'postal_code' => $user->postal_code,
//                'country' => $user->country,
//                'avatar' => Auth::user()->getAvatarUrl(),
//                'created_by' => $user->created_by,
//                'is_active' => $user->is_active,
//                'login_status' => $user->login_status,
//                'average_rating' => $user->average_rating,
//                'profile_completion_percentage' => $user->profile_completion_percentage,
//                'device_token' => $user->device_token,
//                'created_at' => $user->created_at
//             );
//         return response()->json($user_data,200);
        
    }
    
    public function profile_update(Request $request){
        $objUser = Auth::user();
        $user_data=array();
        ($request->has('name') ? $user_data['name']= $request->name : '');
        ($request->has('type') ? $user_data['type']= $request->type : '');
        ($request->has('nickname') ? $user_data['nickname']= $request->nickname : '');
        ($request->has('dob')? $user_data['dob']= $request->dob : '');
        ($request->has('blood_group') ? $user_data['blood_group']= $request->blood_group : '');
        ($request->has('gender') ? $user_data['gender']= $request->gender : '');
        ($request->has('mobile') ? $user_data['mobile']= $request->mobile : '');
        ($request->has('about') ? $user_data['about']= $request->about : '');
        ($request->has('address1') ? $user_data['address1']= $request->address1 : '');
        ($request->has('address2') ? $user_data['address2']= $request->address2 : '');
        ($request->has('city') ? $user_data['city']= $request->city : '');
        ($request->has('state') ? $user_data['state']= $request->state : '');
        ($request->has('postal_code') ? $user_data['postal_code']= $request->postal_code : '');
        ($request->has('country') ? $user_data['country']= $request->country : '');
       
        ($request->has('created_by') ? $user_data['created_by']= $request->created_by : '');
        ($request->has('is_active') ? $user_data['is_active']= $request->is_active : '');
        ($request->has('login_status') ? $user_data['login_status']= $request->login_status : '');
        ($request->has('average_rating') ? $user_data['average_rating']= $request->average_rating : '');
        
        if (!empty($request->avatar)) {
            \App\Utility::checkFileExistsnDelete([$objUser->avatar]);
            $avatarName = $objUser->id . '_avatar' . time() . '.' . $request->avatar->getClientOriginalExtension();
            $request->avatar->storeAs('avatars', $avatarName);
            $user_data['avatar'] = 'avatars/' . $avatarName;
        }
               if(User::where('id',Auth::user()->id)->update($user_data)){
                update_profile_completion();
                   return response()->json(['msg'=>'Profile Updated Successfully!'],200);
               }else{
                   return response()->json(['error'=>'Internal server error!'],401);
               }
    }
}