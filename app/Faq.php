<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    protected $table = 'faqs';
   protected $fillable = [
        'id',
        'user_id',
        'category_id',
        'question',
        'answer',
    ];
     public function category()
    {
        return $this->belongsTo('App\FaqCategory');
    }
     public static function get_category_name($id=0)
    {
         $category = \App\FaqCategory::find($id);
         
        return !empty($category->name) ? $category->name :'Un-Categorized';
    }
}
