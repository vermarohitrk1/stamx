<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AddEvent extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'status'
    ];

    public function getstatus(){
        return[
            'Enable'=>'Enable',
            'Disable'=>'Disable',
        ];
    }

}
