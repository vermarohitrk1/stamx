<?php

namespace App; 

use Illuminate\Database\Eloquent\Model;

class Unansweredfaq extends Model
{
    
    protected $table = 'unansweredfaqs';
    protected $fillable = [
         'id',
         'created_by',
         'question',
     ];
         
}
