<?php

namespace App;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class ProductOption extends Model {

    protected $table = 'product_options';
    protected $fillable = [
        'product_id',
        'attribute_id',
        'attribute_options_id'
    ];


}
