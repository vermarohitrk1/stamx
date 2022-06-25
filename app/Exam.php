<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    protected $fillable = [
        'user_id',
        'certify',
        'name',
        'retakes',
        'description',
        'status',
    ];
    protected $table = "exams";

}
