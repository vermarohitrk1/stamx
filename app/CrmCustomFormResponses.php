<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CrmCustomFormResponses extends Model
{
    protected $table = 'crm_custom_form_responses';
     protected $fillable = [
       'user_id',
        'form_id',
        'response',
    ];
  public function form()
    {
        return $this->belongsTo('App\CrmCustomForms', 'id', 'form_id');
    }
      public function user()
    {
        return $this->belongsTo('App\User');
    }
      
}
