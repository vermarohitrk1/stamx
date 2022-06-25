<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CrmCustomForms extends Model
{
    protected $table = 'crm_custom_forms';
     protected $fillable = [
       'user_id',
        'title',
        'description',
        'folder_id',
        'status',
        'redirect_url',
        'agreements_url',
    ];
     public function forms()
    {
        return CrmCustomForms::hasOne('App\Folder', 'id', 'folder_id');
    }
      public function user()
    {
        return $this->belongsTo('App\User');
    }
      
      public function questions()
    {
        return $this->hasMany('App\CrmCustomFormQuestions', 'form_id', 'id');
    }
      public function responses()
    {
        return $this->hasMany('App\CrmCustomFormResponses', 'form_id', 'id');
    }
    
      public function folder()
    {
        return $this->belongsTo('App\Folder', 'folder_id', 'id');
    }
   
}
