<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class EmailTemplate extends Model
{
    protected $fillable = [
        'integration_place',
        'name',
        'from',
        'keyword',
        'created_by',
        'domain_id',
        'status',
        'show_for',
    ];
     protected $table = 'email_templates';
   public static function prepare_email_body($body,$domain_id,$place,$user_data){
       if(is_array($body)){
                            $array_body='';
                            foreach ($body as $i=>$row){
                                $array_body .="<b>".$i.":</b> ".$row."<br>";
                            }
                            $body=$array_body;
                        }
       $template=self::where('integration_place',$place)->where('domain_id',$domain_id)->where('status','Active')->first();
       if(!empty($template)){
           $arrVariable=[];
           $arrValue=[];
           $emailTemplateLang =\App\EmailTemplateLang::where('parent_id',$template->id)->where('lang','en')->first();
           
           $from= $template->from;
           $keywords= explode(',', $template->keyword);
           
           if(!empty($keywords)){
               foreach ($keywords as $row){
                   $rowexplode=explode(':', $row);
                  // dd($rowexplode);
                   if(!empty($rowexplode)){
                       if(isset($rowexplode[1])){
                        array_push($arrVariable, $rowexplode[1]);
                       }
                 
                   array_push($arrValue, $rowexplode[0]);
                   }
               }
           }
           if(!empty($user_data->name) || !empty($user_data->fname)){
                array_push($arrVariable, '{name}');
                   array_push($arrValue, $user_data->name??$user_data->fname);
           }
           if(!empty($user_data->fname)){
            array_push($arrVariable, '{name}');
               array_push($arrValue, $user_data->fname);
       }
           if(!empty($user_data->email)){
                array_push($arrVariable, '{email}');
                   array_push($arrValue, $user_data->email);
           }
           array_push($arrVariable, '{content}');
                   array_push($arrValue, $body);
           
                   array_push($arrVariable, '{app_name}');
                   array_push($arrValue, env('APP_NAME'));
           
                   array_push($arrVariable, '{app_url}');
                   array_push($arrValue, url('/'));
           
                   if(!empty($user_data->email)){
                   array_push($arrVariable, '{unsubscribe_url}');
                   array_push($arrValue, url('/unsubscribe?email=' . $user_data->email));
                   }
           
           $subject= $emailTemplateLang->subject??'';           
           $body= str_replace($arrVariable, array_values($arrValue), $emailTemplateLang->content??'');;
  ///  $bod =  view('email.test',compact('body'));
    
         //  dd($bod->render());
        }
       $response=[
           'from'=>$from??'',
           'subject'=>$subject??'',
           'body'=>$body??'',
       ];
       return $response;
   }
}

