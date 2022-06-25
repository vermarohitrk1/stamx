<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class JobFormField
 * @package App
 */
class JobFormField extends Model
{
    const ENUM_TEXT = 'text';
    const ENUM_EMAIL = 'email';
    const ENUM_NUMBER = 'number';
    const ENUM_TEXTAREA = 'textarea';
    const ENUM_DATE = 'date';
    const ENUM_RADIO = 'radio';
    const ENUM_CHECKBOX = 'checkbox';
    const ENUM_SELECT = 'select';
    const ENUM_FILE = 'file';
    const QUES_DISABLE_OPTION = [
        self::ENUM_EMAIL,
        self::ENUM_NUMBER,
        self::ENUM_DATE,
    ];

    /**
     * @var string[]
     */
    protected $fillable = ['form_id', 'label', 'status', 'type', 'is_required', 'is_deletable', 'have_option', 'job_id', 'user_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function jobFormEntity(){
        return $this->belongsTo(JobFormEntity::class, 'form_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function jobFormOption(){
        return $this->hasMany(JobFormOption::class, 'field_id', 'id');
    }

    /**
     * @return string[]
     */
    public function getEnumType(){
        $typeOption = [
            self::ENUM_TEXT,
            self::ENUM_EMAIL,
            self::ENUM_NUMBER,
            self::ENUM_TEXTAREA,
            self::ENUM_DATE,
            self::ENUM_RADIO,
            self::ENUM_CHECKBOX,
            self::ENUM_SELECT,
            self::ENUM_FILE,
            ];
        return $typeOption;
    }



    /**
     * @return array
     */
    public function getTypeOption($formSectionId = ""){
        $typeOptionLabel = [];
        $disableEnumType = self::QUES_DISABLE_OPTION;
        $jobFormData = JobFormEntity::find($formSectionId);
        foreach ($this->getEnumType() as $type){
            if($jobFormData->slug == JobFormEntity::QUESTION_SLUG){
                if(in_array($type, $disableEnumType)){
                    continue;
                }
            }

            $typeOptionLabel[$type] = ucfirst($type);
        }
        return $typeOptionLabel;
    }

    /**
     * @param $options
     * @param $fieldId
     */
    public function saveCustomOptions($options, $fieldId){
        foreach ($options as $option){
            $jobOption = new JobFormOption();
            $jobOption->field_id = $fieldId;
            $jobOption->label = $option;
            $jobOption->save();
        }
    }

    /**
     * @return bool
     */
    public function deleteCustomOptions(){
        $options = $this->jobFormOption;
        foreach ($options as $option){
            $option->delete();
        }
        return true;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getFieldLabel($id){
        return $label = self::find($id)->label;
    }
}
