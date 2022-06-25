<?php

namespace App;

use App\Plan;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class MyCourse extends Model
{
    protected $fillable = [
    	'user',
    	'certify'
    ];

    protected $table = 'corporate_courses';

    public function getData($id)
    {
    	$user = Auth::user();
    	$data = self::where(['user'=>$user->id,'certify'=>$id])->first();
    	return $data;
    }
    public function getUserData()
    {
    	$user = Auth::user();
    	$data = self::where(['user'=>$user->id])->get();
    	return $data;
    }
    public function addData($id)
    {
    	$user = Auth::user();
    	$data = self::create([
    		'user'=>$user->id,
    		'certify'=>$id
    	]);
    	return $data;
    }
    public function removeData($id)
    {
    	$user = Auth::user();
    	$data = self::where(['user'=>$user->id,'certify'=>$id])->first();
    	$data = $data->delete();
    	return $data;
    }

    public function getAllAssistenceOfCourse($certifyId)
    {
        $data = self::where(['certify'=>$certifyId])->get();
        return $data;
    }
     public function getAllAssistenceOfCourseFind($request)
    {
        $user = User::where(['type'=>'corporate'])->where('name', 'like', '%' . $request->search . '%')->get('id');
        $data = self::where(['certify'=>$request->certify])->whereIn('user',$user)->get();
        return $data;
    }
     public function getAllAssistenceOfCourseUser($certifyId)
    {
        $data = self::where(['certify'=>$certifyId,'user'=>Auth::user()->id])->get();
        return $data;
    }
}
