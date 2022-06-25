<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Faqssetting extends Model
{
     protected $table = 'faqssettings';
   protected $fillable = [
        'id',
        'user_id',
        'url',
        'website',
        'title',
        'subtitle',
    ];
}
