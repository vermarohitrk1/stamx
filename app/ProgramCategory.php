<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use DB;
class ProgramCategory extends Model
{
    protected $table = 'programs_categories';
    protected $fillable = [
        'name'
     ];

      
  
    
}
