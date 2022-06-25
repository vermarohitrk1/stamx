<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use File;

class Lecture extends Model
{
    const SCORM_UPLOAD_FILE_LOCATION = 'storage/certify/uploads/scorm/zip/';
    const SCORM_UPLOAD_FILE_PATH = 'storage/certify/uploads/scorm/zip/';
    const SCORM_EXTRACT_FILE_PATH = 'storage/certify/uploads/scorm/courses/';
    /**
     * @var string[]
     */
    protected $fillable = [
        'title',
        'description',
        'type',
        'content',
        'indexing',
        'certify',
        'chapter',
    ];

    /**
     * @param $chapterId
     * @return mixed
     */
    public function getLectureOfChapter($chapterId){
    	$Lecture = self::where('chapter','=',$chapterId)->get();
    	return $Lecture;
    }

    /**
     * @param $chapterId
     * @return mixed
     */
     public function getStudentLearn($chapterId){
        $Lecture = self::where('chapter','=',$chapterId)->get();
        return $Lecture;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\UrlGenerator|string
     */
    public function getScormUrl(){
        $scormUrl = '';
        if($this->scorm_provider == 'ispring'){
            $ispringXml = simplexml_load_file(self::SCORM_EXTRACT_FILE_PATH.$this->content.'/imsmanifest.xml') or die("Error: Cannot create object");
            $scormUrl = self::SCORM_EXTRACT_FILE_PATH.$this->content.'/'.$ispringXml[0]->resources->resource['href'];
        }
        elseif($this->scorm_provider == 'articulate'){
            $ispringXml = simplexml_load_file(self::SCORM_EXTRACT_FILE_PATH.$this->content.'/imsmanifest.xml') or die("Error: Cannot create object");
            $scormUrl = self::SCORM_EXTRACT_FILE_PATH.$this->content.'/'.$ispringXml[0]->resources->resource['href'];
        }
        elseif($this->scorm_provider == 'adobe_captivate'){
            $scormUrl = self::SCORM_EXTRACT_FILE_PATH.$this->content.'/index.html';
        }
        if($scormUrl!=""){
            $scormUrl = url($scormUrl);
        }
        return $scormUrl;
    }

    /**
     * @return bool
     */
    public function deletePreviousScormFiles(){
        $deletePath = self::SCORM_EXTRACT_FILE_PATH.$this->content;
        if(File::deleteDirectory($deletePath)){
            return true;
        }
        else{
            return false;
        }
    }
}
