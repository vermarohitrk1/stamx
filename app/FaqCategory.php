<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FaqCategory extends Model
{
   protected $table = 'faqcategories';
   protected $fillable = [
        'id',
        'user_id',
        'name',
    ];
     public function faqs()
    {
        return $this->hasMany('App\Faq');
    }
}
