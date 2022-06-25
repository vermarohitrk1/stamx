<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use App\BookCategory;
use DB;

class Book extends Model
{
    protected $fillable = [
        'user_id',
        'custom_url',
        'title',
        'category',
        'status',
        'description',
        'image',
        'buylink',
        'youtube',
        'show_video',
        'itunes_link',
         'price',
        'featured',
        'favourite_read',
        'treading_books',
        'slider',
        'author',
        'marketplace'
    ];

    public function getalldata($all){
         $user = Auth::user();
            $Book = self::where(['user_id'=>$user->id])->where('status','Published')->get();

         return $Book;
    }

    public function getcategory($categoryId){
        $categories = BookCategory::where(['id'=>$categoryId])->first();
        if(!empty($categories)){
            return $categories->name;
        }
        return "";
    }
}
