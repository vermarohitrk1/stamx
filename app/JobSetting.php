<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use Illuminate\Http\Request;

/**
 * Class JobSetting
 * @package App
 */
class JobSetting extends Model
{
    protected $_collection = null;
    protected $fillable = [
        "user_id",
        "key",
        "value",
    ];

    const LANGUAGE = [
        "" => "Please Select",
        "en" => "English"
    ];

    const DATE_FORMAT = [
        "" => "Please Select",
        "d-m-Y" => "DD-MM-YYYY",
        "m-d-Y" => "MM-DD-YYYY",
        "Y-m-d" => "YYYY-MM-DD",
        "m/d/Y" => "MM/DD/YYYY",
        "d/m/Y" => "DD/MM/YYYY",
        "Y/m/d" => "YYYY/MM/DD",
        "m.d.Y" => "MM.DD.YYYY",
        "d.m.Y" => "DD.MM.YYYY",
        "Y.m.d" => "YYYY.MM.DD",
    ];

    const EMAIL_SERVICE_TYPE = [
        "" => "Choose One",
        "ses" => "Amazon SES",
        "mailgun" => "Mailgun",
        "smtp" => "SMTP",
        "sendmail" => "SendMail",
    ];

    const JOB_COMPANY_IMAGES = [
        "company_logo",
        "company_icon",
        "company_banner"
    ];

    const UPLOAD_DIR = "storage/job_logo/";

    /**
     * @param $key
     * @return mixed|string
     */
    public function loadByKey($key)
    {
        $allCollection = $this->getAllCollection();
        return $allCollection[$key] ?? "";
    }

    /**
     * @return mixed|null
     */
    public function getAllCollection()
    {
        if ($this->_collection != null) {
            return $this->_collection;
        } else {
            $userId = Auth::user()->id ?? 1;
            $allCollection = self::where("user_id", $userId)->get();
            $finalCollection = [];
            foreach ($allCollection as $item) {
                $finalCollection[$item->key] = $item->value;
            }
            $this->_collection = $finalCollection;
            return $this->_collection;
        }
    }

    /**
     * @param $key
     * @return array
     */
    public function getSelectOptions($key)
    {
        $value = $this->loadByKey($key);
        switch ($key) {
            case "language":
                $allOption = self::LANGUAGE;
                break;
            case "date_format":
                $allOption = self::DATE_FORMAT;
                break;
            case "email_service":
                $allOption = self::EMAIL_SERVICE_TYPE;
                break;
            case "timezone":
                $timezones = Timezone::get();
                $allOption = [];
                foreach ($timezones as $item) {
                    $allOption[$item->timezone] = $item->timezone;
                }
                break;
            default:
                $allOption = [];
                break;
        }
        return [
            "all_option" => $allOption,
            "value" => $value
        ];
    }

    /**
     * @param array $data
     * @return array
     */
    public function saveJobSettings(array $data)
    {
        $response = [
            "success" => false,
            "message" => ""
        ];
        try {
            $userId = Auth::user()->id;
            $filesData = self::JOB_COMPANY_IMAGES;
            foreach ($data as $key => $value) {
                $rowModel = self::where(["key" => $key, "user_id" => $userId])->first();
                if(in_array($key, $filesData)){
                    $value = $this->uploadJobFiles($key);
                }
                if (!empty($rowModel)) {
                    $rowModel->value = $value;
                    $rowModel->save();
                } else {
                    self::create([
                        "key" => $key,
                        "user_id" => $userId,
                        "value" => $value,
                    ]);
                }
            }
            $response["success"] = true;
        } catch (\Exception $ex) {
            $response["message"] = $ex->getMessage();
        }
        return $response;
    }

    /**
     * @param $key
     * @return string
     */
    public function uploadJobFiles($key){
        $file = Request()->file($key);
        $destinationPath = self::UPLOAD_DIR;
        $fileName = time()."_".$file->getClientOriginalName();
        $file->move($destinationPath, $fileName);
        return $fileName;
    }

    /**
     * @param $fileName
     * @return bool
     */
    public function getJobImage($fileName){
        return self::UPLOAD_DIR.$fileName;
    }
}
