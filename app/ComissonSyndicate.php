<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ComissonSyndicate extends Model
{
    protected $fillable = [
    	'user',
    	'admin',
        'owner',
    	'promoter'
    ];
    protected $table = 'comisson_syndicates';

    public function addData($request)
    {
    	$user = Auth::user();
    	$owner = $request->promoter + $request->admin;
        $owner = 100 - $owner;
    	$data = self::create([
    		'user'=>$user->id,
    		'owner'=>$owner,
    		'promoter'=>$request->promoter,
            'admin'=>$request->admin
    	]);
   		return $data;
    }
     public function getData()
    {
    	$user = Auth::user();
	   	$data = self::where(['user'=>'1'])->first();
	   	return $data;
    }
     public function updateData($request)
    {
    	$user = Auth::user();
    	$owner = $request->promoter + $request->admin;
        $owner = 100 - $owner;
    	$data = self::where(['user'=>$user->id])->first();
   		$data = $data->update([
    		'owner'=>$owner,
    		'promoter'=>$request->promoter,
            'admin'=>$request->admin
    	]);
   		return $data;
    }
}
