<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
class SendDetailsRequest extends Model
{
    protected $fillable = [
    	'sender',
    	'reciver',
    	'type',
    	'overview',
    	'status'
	];
	protected $table = 'send_details_requests';

	public function storeData($req,$data)
	{
		$data = self::create([
			'sender'=>Auth::user()->id,
			'reciver'=>$data->user,
			'type'=>$req->optionType,
			'overview'=>$req->comment,
			'status'=>'Pending'
		]);
		return $data->id;
	}
}
