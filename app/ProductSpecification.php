<?php

namespace App;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class ProductSpecification extends Model {

    protected $table = 'product_specifications';
    protected $fillable = [
        'product_id',
        'title',
        'value',
    ];

}
