<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PublicPageDetail extends Model
{
    protected $fillable = [
        'user_id',
         'public_title',
         'public_subtitle',
         'image',
         'bgimage',
         'url',
         'type',
         'donation_form_data',
     ];
}
