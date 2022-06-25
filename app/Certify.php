<?php

namespace App;

use App\CertifyCategory;
use Illuminate\Database\Eloquent\Model;
use App\CertifyChapter;
use App\Lecture;
use App\StripePayment;
use App\Instructor;
use App\Syndicatepayment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Mail\CommonEmailTemplate;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

class Certify extends Model {

    protected $fillable = [
        'user',
        'name',
        'boardcertified',
        'certification',
        'degree',
        'cecredit',
        'prerequisites',
        'specialization',
        'price',
        'domain_id',
        'commision',
        'sale_price',
        'image',
        'logos',
        'product',
        'duration',
        'period',
        'description',
        'pennfoster',
        'authoritylabel',
        'status',
        'category',
        'instructor',
        'video',
        'youtubelink',
        'viewtype',
        'videotype',
        'type',
        'syndicate',
        'syndicate_approval',
        'user_id',
        'course_file',
        'email_auto_reply',
    ];
protected $table = "certifies";

    public function getCategoryName($id) {
        $name = CertifyCategory::find($id);
        return $name->name??'Unknown';
    }

    public function getCertifyChapter($id) {
        $chapters = CertifyChapter::where('certify', '=', $id)->get();
        return $chapters;
    }

    public function getCertifyInstructorName($id) {
        $Instructor = Instructor::where(['id' => $id])->first();
        return $Instructor;
    }
    public function getCertifyInstructor($id) {
        $Instructor = Instructor::where(['id' => $id])->first();
        return $Instructor;
    }

    public function checkLearnApproveStatus($id) {
        $user = Auth::user();
        if ($user) {
            $certify = self::where(['user_id' => $user->id, 'id' => $id])->first();
            if ($certify) {
                $status = false;
            } else {
                $status = true;
            }
        } else {
            $status = true;
        }

        return $status;
    }

    public function checkEnrollStatusOfLoginUser($certifuId) {
        $user = Auth::user();
        if ($user) {
            $certify = StripePayment::where(['user_id' => $user->id, 'item_id' => $certifuId, 'item_type' => 'certify'])->first();
            if ($certify) {
                $status = true;
            } else {
                $status = false;
                $Syndicatepayment = Syndicatepayment::where(['certify' => $certifuId, 'buyer' => $user->id])->first();
                if ($Syndicatepayment) {
                    $status = true;
                } else {
                    $status = false;
                }
            }
        } else {
            $status = false;
        }

        return $status;
    }

    public function getSyndicateInfo($id) {
        $domain_id = get_domain_id();
        $data = self::where('id', '=', $id)->where('syndicate_approval', '=', 'APPROVE')->where('domain_id', '!=', $domain_id)->first();
        return $data;
    }


 public function getcDetails($id)
    {
		$getCertityName=self::find($id);
		$getCertityName=$getCertityName->name;
    	return $getCertityName;
    }
	
	
	 public function getcPrice($id)
    {
		$getCertityprice=self::find($id);
		if($getCertityprice->sale_price > 0){
			$price='$'.$getCertityprice->sale_price;
		}
		else{
		$price='$'.$getCertityprice->price;
		}
		$Certityprice=$price;
    	return $Certityprice;
    }
	
	 public function getcertPrice($id)
    {
		$getCertityprice=self::find($id);
		if($getCertityprice->sale_price > 0){
			$price=$getCertityprice->sale_price;
		}
		else{
		$price=$getCertityprice->price;
		}
		$Certityprice=$price;
    	return $Certityprice;
    }
    public function getCertify($id) {
        return self::find($id);
    }
    public function getSyndicateStatus($certifuId) {
        $user = Auth::user();
        if ($user) {
            $certify = StripePayment::where(['item_id' => $certifuId, 'item_type' => 'certify'])->first();
            if ($certify) {
                $status = true;
            } else {
                $status = false;
                $Syndicatepayment = Syndicatepayment::where(['certify' => $certifuId])->first();
                if ($Syndicatepayment) {
                    $status = true;
                } else {
                    $status = false;
                }
            }
        } else {
            $status = false;
        }

        return $status;
    }
    
	   public function CertCode($certifuId) {
        $user = Auth::user();
        if ($user) {
            $certify = StripePayment::where(['item_id' => $certifuId, 'item_type' => 'certify'])->first();
            if ($certify) {
                $code = $certify->enroll_key;
            } else {
               $code = false;
            }
        } else {
            $code = false;
        }

        return $code;
    }
	
    public static function sendWeeklyRecommendedCourses($testemail=null) {
        
               $response=array();
        if(empty($testemail)){
    $contact = \App\Newconnect::where("folder", 'Newsletters')->get();
        $owners=$contact->pluck('user_id')->toArray();
        $unique_owners=!empty($owners) ? array_unique($owners) :"";
        }else{
            $user = Auth::user();
           $unique_owners =!empty($user->id) ? [$user->id] :[];
           if(empty(check_email_is_valid($testemail))){
               $response['error']="Invalid Email Provided";
               return $response;
           }
        }
        //preparing email template
        $template = \App\EmailTemplate::where('name', 'LIKE', "Weekly Courses Catalog")->first();
        if(!empty($template)){
            $content       = \App\EmailTemplateLang::where('parent_id', '=', $template->id)->where('lang', 'LIKE', ($usr->lang?? 'en'))->first();
            $content->from = $template->from;
        }
        
        
        if(!empty($unique_owners) && !empty($content->content)){
            foreach ($unique_owners as $owner){
                $data = \App\Certify::where('status', '=', 'Published')->where('user_id', $owner)->orderBy('id', 'DESC')->paginate(10);
                if(!empty($data) && count($data) >0){
               
                if(!empty($testemail)){
                     $mailTo =$testemail;
                        $content->data =$data;
                        $content->user_id =$owner;
                        // send email
                        try
                        {
                           $resp= Mail::to($mailTo)->send(new \App\Mail\RecommendedCourses($content));
                          
                            $response['success']= empty($resp) ? "Email sent successfully":$resp;
               return $response;
                        }
                        catch(\Exception $e)
                        {
                            $error = __('E-Mail has been not sent due to SMTP configuration');
                            $response['error']=$error;
               return $response;
                        }
                    
                    
                    
                    
                    
                }else{   
                foreach ($contact as $subscriber){
                    if($subscriber->user_id==$owner && !empty($subscriber->email)){
                      
                        $mailTo =$subscriber->email;// $subscriber->email;
                        $content->data =$data;
                        $content->user_id =$owner;
                        $content->mailto =$mailTo;
                        // send email
                        try
                        {
                           $resp= Mail::to($mailTo)->send(new \App\Mail\RecommendedCourses($content));
                        
                        }
                        catch(\Exception $e)
                        {
                            $error = __('E-Mail has been not sent due to SMTP configuration');
                        }
                       
                        
                    }
                }
                }
                
                }

            }
        }
        
        
    }

}
