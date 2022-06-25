<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class JobDepartment
 * @package App
 */
class JobDepartment extends Model
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
