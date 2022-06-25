<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PetitionForms extends Model
{
    protected $table = 'petition_forms';
     protected $fillable = [
       'user_id',
        'title',
        'description',
        'folder_id',
        'status',
        'target',
        'end_date',
        'redirect_url',
        'agreements_url',
        'tags',
        'alert',
        'image',
        'dummy',
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
        return $this->hasMany('App\PetitionFormQuestions', 'form_id', 'id');
    }
      public function responses()
    {
        return $this->hasMany('App\PetitionFormResponses', 'form_id', 'id');
    }
    
      public function folder()
    {
        return $this->belongsTo('App\Folder', 'folder_id', 'id');
    }
     public function getfolder($categoryId){
        $categories = \App\ContactFolder::where(['id'=>$categoryId])->first();
        if(!empty($categories)){
            return $categories->name; 
        }
         return "No Folder";
    }
}
