<?php

namespace App;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Exam;

class Examsreport extends Model {

    protected $fillable = [
        'user',
        'certify',
        'exam',
        'student',
        'score',
        'correctlyAnswered',
        'totalQuestions',
    ];
  protected $table = 'examsreports';
    public function checkExamStatusOfLearn($certify_id) {
        $authuser = Auth::user();
        $report = self::where(['user' => $authuser->id, 'certify' => $certify_id])->get();
//        $report = self::where(['user' => $authuser->id, 'certify' => $certify_id])->groupBy('exam')->get();
        $Exam = Exam::where(['certify' => $certify_id])->count();
        if ($report) {
            if ($Exam) {
                if ($Exam == count($report)) {
                    $status = true;
                } else {
                    $status = false;
                }
            } else {
                $status = false;
            }
        } else {
            $status = false;
        }
        return $status;
    }

    public function getStudentScoreData($userId, $certifyId, $examId) {
        $report = self::where(['user' => $userId, 'certify' => $certifyId, 'exam' => $examId])->orderBy('created_at', 'DESC')->first();
        return $report;
    }

}
