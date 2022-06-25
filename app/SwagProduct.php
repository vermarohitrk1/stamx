<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SwagProduct extends Model
{
     protected $table = 'swag_products';
     protected $fillable = [
        'id',
        'user_id',
        'title',
        'description',
        'status',
        'image',
    ];
}
