<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use DB;
class Photobooth extends Model
{
    protected $table = 'photobooth';
    protected $fillable = [
        'user_id',
        'title',
		'template',
		'public_id',
		'status'
      
     
    ];

  
    
}
