<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blacklist extends Model
{
    public $timestamps = false;
    protected $table = 'blacklists';
       protected $fillable = [
        'user_id',
        'type',
        'value',
        'status',
        'created_at',
        'updated_at'
    ];
}
