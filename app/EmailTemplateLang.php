<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmailTemplateLang extends Model
{
    protected $fillable = [
        'parent_id',
        'lang',
        'subject',
        'content',
    ];
     protected $table = 'email_template_langs';
}
