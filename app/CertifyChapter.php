<?php

namespace App;
use App\Lecture;
use Illuminate\Database\Eloquent\Model;

class CertifyChapter extends Model
{
    protected $fillable = [
        'certify',
        'title',
        'description',
        'indexing',
    ];

    public function getLectureOfChapter($chapterId){
    	$Lecture = Lecture::where('chapter','=',$chapterId)->get();
    	return $Lecture;
    }

    public function getChapterType(){
        return [
            'custom' => 'Custom',
            'scorm' => 'Scorm'
        ];
    }
}
