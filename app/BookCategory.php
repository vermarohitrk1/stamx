<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use DB;
class BookCategory extends Model
{
    protected $table = 'books_categories';
    protected $fillable = [
        'user_id',
        'name'
      
     
    ];

    public function getcategory($all){
        $user_id =  get_domain_id();

        $BookCategory = self::where(['user_id'=>$user_id])->paginate(5);
		 return $BookCategory;
	}
      
    public static function get_random_categories($count=10,$id=0) {       
       $category= self::inRandomOrder()->limit($count);
       if(!empty($id)){
         $category->WHere('id',$id)  ;
         $category->orWHere('id','!=',$id)  ;
       }
       $category=$category->get();
 
       return $category;
        
    }
    
}
