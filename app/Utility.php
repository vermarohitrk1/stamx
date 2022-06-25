<?php

namespace App;

use App\Mail\CommonEmailTemplate;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class Utility extends Model
{
    
    // Check File is exist and delete these
    public static function checkFileExistsnDelete(array $files)
    {
        $status = false;
        foreach($files as $key => $file)
        {
            if(Storage::exists($file))
            {
                $status = Storage::delete($file);
            }
        }

        return $status;
    }

    // Save Settings on .env file
    public static function setEnvironmentValue(array $values)
    {
        $envFile = app()->environmentFilePath();
        $str     = file_get_contents($envFile);
     
        if(count($values) > 0)
        {
            foreach($values as $envKey => $envValue)
            {
                $keyPosition       = strpos($str, "{$envKey}=");
                $endOfLinePosition = strpos($str, "\n", $keyPosition);
                $oldLine           = substr($str, $keyPosition, $endOfLinePosition - $keyPosition);

                // If key does not exist, add it
                if(!$keyPosition || !$endOfLinePosition || !$oldLine)
                {
                    $str .= "{$envKey}='{$envValue}'\n";
                }
                else
                {
                    $str = str_replace($oldLine, "{$envKey}='{$envValue}'", $str);
                }
            }
        }

        $str = substr($str, 0, -1);
        $str .= "\n";

        if(!file_put_contents($envFile, $str))
        {
            return false;
        }

        return true;
    }

    // for invoice number format
    public static function invoiceNumberFormat($number)
    {
        return '#' . sprintf("%05d", $number);
    }

    // get project wise currency formatted amount
    public static function projectCurrencyFormat($project_id, $amount, $decimal = false)
    {
        $project = Project::find($project_id);
        if(empty($project))
        {
            $project                    = new Project();
            $project->currency          = '$';
            $project->currency_position = 'pre';
        }

        if($decimal == true)
        {
            $number = number_format($amount, 2);
        }
        else
        {
            $number = number_format($amount);
        }

        return (($project->currency_position == "pre") ? $project->currency : '') . $number . (($project->currency_position == "post") ? $project->currency : '');
    }

    // get progress bar color
    public static function getProgressColor($percentage)
    {
        $color = '';

        if($percentage <= 20)
        {
            $color = 'danger';
        }
        elseif($percentage > 20 && $percentage <= 40)
        {
            $color = 'warning';
        }
        elseif($percentage > 40 && $percentage <= 60)
        {
            $color = 'info';
        }
        elseif($percentage > 60 && $percentage <= 80)
        {
            $color = 'primary';
        }
        elseif($percentage >= 80)
        {
            $color = 'success';
        }

        return $color;
    }

    // get date formated
    public static function getDateFormated($date)
    {
        if(!empty($date) && $date != '0000-00-00')
        {
            return date("d M Y", strtotime($date));
        }
        else
        {
            return '';
        }
    }
    // get date formated
    public static function getDateTimeFormated($date)
    {
        if(!empty($date) && $date != '0000-00-00')
        {
            return date("d M Y H:i:", strtotime($date));
        }
        else
        {
            return '';
        }
    }

    // Return timesheet sum of array
    public static function affiliate_calculateTimesheetHours($time,$points)
    {
        $minutes = 0;
        return sprintf('%02d:%02d', $points, $minutes);
    }

    public static function calculateTimesheetHours($times)
    {
        $minutes = 0;
        foreach($times as $time)
        {
            list($hour, $minute) = explode(':', $time);
            $minutes += $hour * 60;
            $minutes += $minute;
        }
        $hours   = floor($minutes / 60);
        $minutes -= $hours * 60;

        return sprintf('%02d:%02d', $hours, $minutes);
    }

    // Return multiple time to single total hr
    public static function timeToHr($times)
    {
        $totaltime = self::calculateTimesheetHours($times);
        $timeArray = explode(':', $totaltime);
        if($timeArray[1] <= '30')
        {
            $totaltime = $timeArray[0];
        }
        $totaltime = $totaltime != '00' ? $totaltime : '0';

        return $totaltime;
    }

    // Return Week first day and last day
    public static function getFirstSeventhWeekDay($week = null)
    {
        $first_day = $seventh_day = null;
        if(isset($week))
        {
            $first_day   = Carbon::now()->addWeeks($week)->startOfWeek();
            $seventh_day = Carbon::now()->addWeeks($week)->endOfWeek();
            //            $first_day   = Carbon::now()->addWeeks($week);
            //            $seventh_day = Carbon::now()->addWeeks($week + 1)->subDays(1);
        }
        $dateCollection['first_day']   = $first_day;
        $dateCollection['seventh_day'] = $seventh_day;
        $period                        = CarbonPeriod::create($first_day, $seventh_day);
        foreach($period as $key => $dateobj)
        {
            $dateCollection['datePeriod'][$key] = $dateobj;
        }

        return $dateCollection;
    }

    // Return Percentage from two value
    public static function getPercentage($val1 = 0, $val2 = 0)
    {
        $percentage = 0;
        if($val1 > 0 && $val2 > 0)
        {
            $percentage = intval(($val1 / $val2) * 100);
        }

        return $percentage;
    }

    // Return Last 7 Days with date & day name
    public static function getLastSevenDays()
    {
        $arrDuration   = [];
        $previous_week = strtotime("-1 week +1 day");

        for($i = 0; $i < 7; $i++)
        {
            $arrDuration[date('Y-m-d', $previous_week)] = date('D', $previous_week);
            $previous_week                              = strtotime(date('Y-m-d', $previous_week) . " +1 day");
        }

        return $arrDuration;
    }
    // Return Last 7 Days with date & day name
    public static function getMonthsList($count=1)
    {
        $arrDuration   = [];
//        $previous_month = strtotime("-1 year +1 month");
       
        for($i = 0; $i < $count; $i++)
        {
            $arrDuration[] = date('F', strtotime("-$i month"));
        }

        return $arrDuration;
    }

       
    // get font-color code accourding to bg-color
    public static function hex2rgb($hex)
    {
        $hex = str_replace("#", "", $hex);

        if(strlen($hex) == 3)
        {
            $r = hexdec(substr($hex, 0, 1) . substr($hex, 0, 1));
            $g = hexdec(substr($hex, 1, 1) . substr($hex, 1, 1));
            $b = hexdec(substr($hex, 2, 1) . substr($hex, 2, 1));
        }
        else
        {
            $r = hexdec(substr($hex, 0, 2));
            $g = hexdec(substr($hex, 2, 2));
            $b = hexdec(substr($hex, 4, 2));
        }
        $rgb = array(
            $r,
            $g,
            $b,
        );

        //return implode(",", $rgb); // returns the rgb values separated by commas
        return $rgb; // returns an array with the rgb values
    }


    // For Delete Directory
    public static function delete_directory($dir)
    {
        if(!file_exists($dir))
        {
            return true;
        }

        if(!is_dir($dir))
        {
            return unlink($dir);
        }

        foreach(scandir($dir) as $item)
        {
            if($item == '.' || $item == '..')
            {
                continue;
            }

            if(!self::delete_directory($dir . DIRECTORY_SEPARATOR . $item))
            {
                return false;
            }

        }

        return rmdir($dir);
    }


    public static function send_emails($email = null, $name = null, $subject = 'New Email', $body = null,$template=null,$user_data=null) {
        $mailer_settings='';
     

        if (!empty($email) && !empty($body)) {
         try { 
             $domain_id= get_domain_id();
             $domain_user= get_domain_user();
			 
			
             $permissions= role_permissions($domain_user->type);
             
            // dd($permissions);
		
				if(in_array('allow_to_user_admin_mailer_settings', $permissions)){
             
                  $mailer_settings=\App\SiteSettings::getValByName('mailer_settings');
           // dd(  $mailer_settings);
           
             config(
                     [
                         'mail.driver' => $mailer_settings[1]['MAIL_DRIVER']??'',
                         'mail.host' => $mailer_settings[1]['MAIL_HOST']??'',
                         'mail.port' => $mailer_settings[1]['MAIL_PORT']??'',
                         'mail.encryption' => $mailer_settings[1]['MAIL_ENCRYPTION']??'',
                         'mail.username' => $mailer_settings[1]['MAIL_USERNAME']??'',
                         'mail.password' => $mailer_settings[1]['MAIL_PASSWORD']??'',
                         'mail.from.address' => $mailer_settings[1]['MAIL_FROM_ADDRESS']??'',
                         'mail.from.name' => $mailer_settings[1]['MAIL_FROM_NAME']??'',
                     ]
             );
         
             }
				
			
             
                
                 if(!empty($template)){


                     $template_response= \App\EmailTemplate::prepare_email_body($body,$domain_id,$template,$user_data);
                     $subject=$template_response['subject'];
                     $body=$template_response['body'];
                     $from=$template_response['from'];
                 
                 }else{
                  
                     if(is_array($body)){
                         $array_body='';
                         foreach ($body as $i=>$row){
                             $array_body .="<b>".$i.":</b> ".$row."<br>";
                         }
                         $body=$array_body;
                     }else{
                        $template_response['body']= $body;
                        $from=!empty($from) ? $from : get_from_name_email();
                     }
                 }
               //  dd($from);
                 $content       = array();
             $content['content'] = $template_response['body'];
             $content['subject'] = $subject;
             $content['email'] = $email;
//             $content['from'] = $from;
             //dd($content);
             $mailTo = $email;
              $content['from']=!empty($from) ? $from : get_from_name_email();
              $from=$content['from']??'';
           
             $res= \Mail::send([], ['name',$name], function($message) use ($email,$name,$subject,$body,$from) {
                  $message->to($email, $name)
                          ->from(config('mail.from.address'),$from)
                          ->subject($subject)
                          ->setBody($body, 'text/html');
              });

           // dd( $template_response);
            
            // dd($content);
           //  $content = json_encode($content);
              //dd($mailer_settings);
             // dd($mailTo);
                 //dd($mailer_settings);
              if($mailer_settings != ''){
                 //dd('hi',$mailer_settings);
                 
               Mail::to($mailTo)->send(new CommonEmailTemplate($content));
         }

            return $res;
        } catch (Exception $e) {
            //dd($e);
            if(env('APP_ENV')=='local'){
                dd($e);

                } //for development mode
                
              
             return false;
        }
         return true;
     } else {
         return false;
     }
 }
    
}
