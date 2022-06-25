<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class ContactFolder extends Model
{
    protected $table = 'contact_folders';
    protected $fillable = [
        'user_id',
        'name',
        'domain_id',
        'created_at'
    ];

       public function getfolder($all){
         $user = Auth::user();
         if($all == 'all'){
            $Folder = self::where(['user_id'=>$user->id])->paginate(5); 
         }
         return $Folder;
    }
     public static function getfoldername($id=0){
         $user = Auth::user();
            $Folder = self::where('id',$id)->first(); 
         return !empty($Folder->name) ? $Folder->name :'No Folder';
    }
   
     public function customforms()
    {
        return $this->hasMany('App\CrmCustomForms','folder_id','id');
    }
     
}
