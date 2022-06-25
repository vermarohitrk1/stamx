<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Certificate extends Model
{
    protected $fillable = [
        'user',
        'template',
		'text',
		'top',
		'header',
		'logo',
		'badge',
		'footer',
    ];
    protected $table = 'certificates';

    public function getData()
    {
        return self::where(['user' => Auth::user()->id])->get();
    }

    public function getSingleData($id)
    {
        return self::where(['user' => Auth::user()->id, 'id' => $id])->first();
    }

    public function updateData($request)
    {
        return self::where(['user' => Auth::user()->id, 'id' => $request->id])->update($request);
    }

    public function deleteSingleData($id)
    {
        return self::where(['user' => Auth::user()->id, 'id' => $id])->delete();
    }
}
