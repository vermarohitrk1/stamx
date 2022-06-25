<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CertifyCategory extends Model
{
   protected $fillable = [
        'user_id',
        'name',
        'icon',
    ];
protected $table = "certify_categories";
    public function getDetails($id)
    {
		$getcategory=self::find($id);
		$getcategory=$getcategory->name;
    	return $getcategory;
    }
    public static function getCourseCategories()
    {
       
    	$cat= self::select('certify_categories.id','certify_categories.name','certify_categories.icon')->join('certifies as c','c.category','certify_categories.id')->groupBy('certify_categories.id','certify_categories.name','certify_categories.icon')->get();
        return $cat;
    }
}
