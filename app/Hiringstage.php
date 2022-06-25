<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Hiringstage
 * @package App
 */
class Hiringstage extends Model
{
    const DISQUALIFIED_LABEL = 'Disqualified';
    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'status'
    ];

    /**
     * @return string[]
     */
    public function getStatus(){
        return[
            'Enable'=>'Enable',
            'Disable'=>'Disable',
        ];
    }

    /**
     * @return string
     */
    public static function getDefaultStageId(){
        $defaultStage = self::where(['name'=> 'New', 'is_deletable' => 0])->first();
        $defaultStageId = "";
        if(!empty($defaultStage)){
            $defaultStageId = $defaultStage->id;
        }
        return $defaultStageId;
    }

}
