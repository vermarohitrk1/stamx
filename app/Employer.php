<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employer extends Model
{
    protected $fillable = ['company','address','user_id' ,'status'];
    protected $table = "employers";
}
