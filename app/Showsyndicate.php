<?php

namespace App;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;


class Showsyndicate extends Model {

    protected $fillable = [
        'certify_id',
        'user_id',
        'domain_id'
     
    ];
    protected $table = 'show_syndicate';

    //get g details from ID
    public static function getall($id = '')
    {
        return $g = Showsyndicate::find($id);
    }

}
