<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentLectureStatus extends Model
{
    protected $fillable = [
    	'student',
    	'chapter_id',
    	'lecture_id',
    	'study_status',
    	'status'
    ];
}
