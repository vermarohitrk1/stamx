<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssessmentCategory extends Model
{
    protected $table = "assessment_categories";
     protected $fillable = [
        'id',
        'name',
    ];
      public function forms()
    {
        return $this->hasMany('App\AssessmentForms','category','id');
    }
    public function count_forms()
    {
        return $this->forms()
                ->selectRaw('category, count(category) as count')
                ->groupBy('category');
    }
     public static function getcatname($id=0){
       
            $Folder = self::where('id',$id)->first(); 
         return !empty($Folder->name) ? $Folder->name :'No Category';
    }
}
