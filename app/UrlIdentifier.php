<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Certify;
use App\Instructor;
use App\Exam;
use App\Question;
use App\Examsreport;
use App\CertifyCategory;
use App\CertifyChapter;
use App\Lecture;
use App\Plan;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UrlIdentifier extends Model {

    protected $fillable = [
        'table_name',
        'table_unique_identity',
		'status'
    ];
    protected $table = 'url_identifiers';

    public function checkTableNameByModal($tableName) {
        $response = [
            'status' => false,
            'message' => '',
            'data' => ''
        ];

        if (!empty($tableName)) {
            $UrlIdentifier = UrlIdentifier::where(['table_name' => $tableName])->first();
            if (!empty($UrlIdentifier)) {
                $response = [
                    'status' => false,
                    'message' => 'Table Url Identifier Alreay Created Choose Another Table',
                    'data' => $UrlIdentifier
                ];
            } else {
                $rand = rand();
                $response = [
                    'status' => true,
                    'message' => 'Table Available For Make Url Identifier',
                    'data' => $tableName . $rand
                ];
            }
        }

        return $response;
    }

    public function store($request) {
        $UrlIdentifier = self::create(
                        [
                            'table_name' => $request->table_name,
                            'table_unique_identity' => $request->table_unique_identity,
                            'status' => $request->status
                        ]
        );
        return $UrlIdentifier;
    }

    public function list() {
        $UrlIdentifier = self::all();
        return $UrlIdentifier;
    }

    public function getUrlIdentifier($id) {
        $UrlIdentifier = self::find($id);
        return $UrlIdentifier;
    }

    public function UpdateUrlIdentifier($request) {

        $UrlIdentifier = self::find($request->urlidentifierId);
        if ($UrlIdentifier->id){
            $UrlIdentifier->status = $request->status;
            $UrlIdentifier->save();
        }
        return $UrlIdentifier;
    }

    public function DeleteUrlIdentifier($request) {
        $UrlIdentifier = self::find($request->urlidentifiers_id);
        if ($UrlIdentifier) {
            $UrlIdentifier = $UrlIdentifier->delete();
        }
        return $UrlIdentifier;
    }

}
