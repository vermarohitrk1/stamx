<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Certify;
use App\SendDetailsRequest;
use App\User;
use App\Showsyndicate;
use App\Instructor;
use App\Exam;
use App\ShopProduct;
use App\Question;
use App\UserContact;
use App\Examsreport;
use App\CertifyCategory;
use App\CertifyChapter;
use App\Lecture;
use App\StudentLectureStatus;
use App\StudentLearnStatus;
use App\WalletExpenses;
use App\Plan;
use App\Certificate;
use App\Syndicatepayment;
use App\Marketplace;
use App\Syndicate;
use App\AssistanceRequest;
use App\MyCourse;
use App\CompanyWallet;
use App\CorporateCoupon;
use App\StripePayment;
use App\Utility;
use App\WithdrawRequest;
use Mail;
use Twilio\TwiML\VoiceResponse;
use Twilio\Jwt\ClientToken;
use Twilio\Rest\Client;
use Twilio\Jwt\TaskRouter\WorkerCapability;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use DataTables;
use File;
use ZipArchive;
use App\BlsState;
use App\BlsIndustry;
use Alert;
use Carbon\Carbon;
class CertifyController extends Controller
{

    public function __construct()
    {
        $this->subdomain = get_domain_id();
    }

    public function test()
    {
        echo 'test';
        die;
    }
public function index(Request $request)
    {
        $authuser = Auth::user();
        $domain_id= get_domain_id();
        $user = Auth::user();
		
		
        if (isset($_GET['type']) && $_GET['type'] == 'Masterclass') {
            $type = 'Masterclass';
        } else {             
            $type = 'Regular';
        }
//        $bls_industries = BlsIndustry::select('id','name')->get();
        $syndicateCertify = 0;

        if ($request->ajax() && !empty($request->blockElementsData)) {
                if (!empty($request->duration)) {
                    $tilldate = Carbon::now()->addMonth($request->duration)->toDateTimeString();
                }
                
                $CertifiesCount = Certify::where('user_id', $authuser->id);
        if (!empty($tilldate)) {
                    $CertifiesCount->where("created_at", ">", $tilldate);
                }
                        $CertifiesCount=$CertifiesCount->count();
            $student = StripePayment::join('certifies', 'certifies.id', '=', 'stripe_payments.item_id')
                ->where('certifies.domain_id',$domain_id)
                ->groupBy('stripe_payments.user_id');
             if (!empty($tilldate)) {
                    $student->where("stripe_payments.created_at", ">", $tilldate);
                }

                $student=$student->count();
            $income = StripePayment::join('certifies', 'certifies.id', '=', 'stripe_payments.item_id')
                ->where('certifies.domain_id', $domain_id)
                ->where('stripe_payments.item_type', "certify");
             if (!empty($tilldate)) {
                    $income->where("stripe_payments.created_at", ">", $tilldate);
                }
                $income=$income->sum('total_price');
        
            
         
               
                    
                    
                        return json_encode([
                    'courses' => $CertifiesCount,
                    'students' => $student,
                    'income' => format_price($income),
                ]);
                
                
                
         }elseif ($request->ajax()) {
			 if ($authuser->type == 'mentee' ) {
                $syndicateCertify = 1; 
                $data = Certify::select('certifies.*','stripe_payments.exp_date')
                    ->Join('stripe_payments', 'certifies.id', '=', 'stripe_payments.item_id')
                    ->where('stripe_payments.item_type', 'certify')
                    ->Where('stripe_payments.user_id', $user->id)
                    ->groupBy('certifies.id');
            }

          elseif ($authuser->type == 'mentor'|| $authuser->type == 'corporate' ) {
              $syndicateCertify = 1;

			$data = Certify::where('type', '=', $type)->Where('user_id', $user->id);
          }elseif ($authuser->type == 'admin' ) {
			$data = Certify::where('type', '=', $type);

            } else {
                $data = Certify::where('type', '=', $type)->Where('user_id', $user->id);
           }
            if (!empty($request->filter_status)) {
              
                    $data->where('certifies.status', $request->filter_status);
               
            }
            return Datatables::of($data)
                ->addIndexColumn()
                       ->orderColumn('name', function ($query, $order) {
                     $query->orderBy('certifies.id', $order);
                 })
                ->filterColumn('name', function ($query, $keyword) use ($request) {
                    $sql = "certifies.name like ?";
                    $query->whereRaw($sql, ["%{$keyword}%"]);
                })
                 ->orderColumn('price', function ($query, $order) {

                     $query->orderBy('price', $order);
                 })
                ->addColumn('name', function ($data) {
                    if (!empty($data->image)) {
                        if (file_exists(storage_path() . '/certify/' . $data->image)) {
                            $url = asset('storage/certify/' . $data->image);
                        } else {
                            $url = asset('public/demo.png');
                        }
                    } else {
                        $url = asset('public/demo.png');
                    }
                    return '<div class="media align-items-center">
                            <a href="' . url('certify/show/' . encrypted_key($data->id, 'encrypt')) . '"
                            class="avatar  hover-translate-y-n3 course_img">
                            <img src="' . $url . '"
                            class="">
                            </a>
                            <div class="media-body ml-4 text-sm">
                            <a href="' . url('certify/show/' . encrypted_key($data->id, 'encrypt')) . '"
                            class="text-black" style="color: black;">
                            ' . $data->name . '
                            </a>
                            </div>
                            </div>';
                })->addColumn('price', function ($data) {

                    return format_price( $data->price);
                })->addColumn('duration', function ($data) {

                    return $data->duration . " " . $data->period;
                })->addColumn('status', function ($data) {

                    return $data->status;
                })->addColumn('exp_date', function ($data) {

                    return $data->getCategoryName($data->category);
                })->addColumn('action', function ($data) {
                    $authuser = Auth::user();
                    $actionBtn='';

                    $domain_id= get_domain_id();
                    $permissions= permissions();

                     $actionBtn = '<div class="actions text-right">

                                                <a class="btn btn-sm bg-info-light mr-1" href="'. url('certify/show/' . encrypted_key($data->id, 'encrypt')) .'">
                                                    <i class="fas fa-eye"></i>
                                                    View
                                                </a>';

                    if( $authuser->id ==$data->user_id && (in_array('course_create_regular', $permissions) ) || $authuser->type=="admin"){


                          $actionBtn .= '<a class="btn btn-sm bg-success-light" data-title="Edit " href="'.route('certify.edit', encrypted_key($data->id, 'encrypt')) .'">
                                                    <i class="fas fa-pencil-alt"></i>
                                                    Edit
                                                </a>
                                                <a data-url="' . url('certify/destroy/'.encrypted_key($data->id,'encrypt')) . '" href="#" class="btn btn-sm bg-danger-light delete_record_model">
                                                    <i class="far fa-trash-alt"></i> Delete
                                                </a>';
                    }
					
					else{

                        if (checkExamStatus($data->id) == true) {
                            $actionBtn .= '<a class="btn btn-sm bg-warning-light" href="'.  url('certify/certificate/' . encrypted_key($data->id, 'encrypt')) .'">
                                                    <i class="fa fa-certificate"></i>
                                                    Certificate
                                                </a>';
                        }
                    }
                    $actionBtn .="</div>";

                    return $actionBtn;
                })
                ->rawColumns(['action', 'name','price'])
                ->make(true);
        } else {


            $CertifiesCount = Certify::where('user_id', $authuser->id)->whereMonth('created_at', date('m'))->count();
            $student = StripePayment::join('certifies', 'certifies.id', '=', 'stripe_payments.item_id')
                ->where('certifies.domain_id',$domain_id)
                ->groupBy('stripe_payments.user_id')
                    ->whereMonth('stripe_payments.created_at', date('m'))

                ->count();
            $income = StripePayment::join('certifies', 'certifies.id', '=', 'stripe_payments.item_id')
                ->where('certifies.domain_id', $domain_id)
                ->where('stripe_payments.item_type', "certify")
                    ->whereMonth('stripe_payments.created_at', date('m'))
                ->sum('total_price');
            $incomplete = StripePayment::join('certifies', 'certifies.id', '=', 'stripe_payments.item_id')
                ->where('stripe_payments.completed_on', "ongoing")
                ->where('stripe_payments.item_type', "certify")
                ->where('certifies.domain_id', $domain_id)
                    ->whereMonth('stripe_payments.created_at', date('m'))
                ->count();


            return view('certify.index', compact('CertifiesCount', 'authuser', 'type', 'income', 'student', 'incomplete', 'syndicateCertify'));
        }
    }
	
	
	public function Corporateindex(Request $request)
    {
        $authuser = Auth::user();
        $domain_id= get_domain_id();
        $user = Auth::user();
		
		
        if (isset($_GET['type']) && $_GET['type'] == 'Masterclass') {
            $type = 'Masterclass';
        } else {             
            $type = 'Regular';
        }
//        $bls_industries = BlsIndustry::select('id','name')->get();
        $syndicateCertify = 0;

        if ($request->ajax()) {
			 if ($authuser->type == 'mentee' ) {
                $syndicateCertify = 1; 
                $data = Certify::select('certifies.*','stripe_payments.exp_date')
                    ->Join('stripe_payments', 'certifies.id', '=', 'stripe_payments.item_id')
                    ->where('stripe_payments.item_type', 'certify')
                    ->Where('stripe_payments.user_id', $user->id)
                    ->groupBy('certifies.id');
            } elseif($authuser->type == 'corporate'){
				  $data = Certify::where('type','=', $type);
			}

          elseif ($authuser->type == 'mentor' ) {
              $syndicateCertify = 1;

			$data = Certify::where('type', '=', $type)->Where('user_id', $user->id);
          }elseif ($authuser->type == 'admin' ) {
			$data = Certify::where('type', '=', $type);

            } else {
                $data = Certify::where('type', '=', $type)->Where('user_id', $user->id);
           }
            return Datatables::of($data)
                ->addIndexColumn()
                       ->orderColumn('name', function ($query, $order) {
                     $query->orderBy('certifies.id', $order);
                 })
                ->filterColumn('name', function ($query, $keyword) use ($request) {
                    $sql = "certifies.name like ?";
                    $query->whereRaw($sql, ["%{$keyword}%"]);
                })
                 ->orderColumn('price', function ($query, $order) {

                     $query->orderBy('price', $order);
                 })
                ->addColumn('name', function ($data) {
                    if (!empty($data->image)) {
                        if (file_exists(storage_path() . '/certify/' . $data->image)) {
                            $url = asset('storage/certify/' . $data->image);
                        } else {
                            $url = asset('public/demo.png');
                        }
                    } else {
                        $url = asset('public/demo.png');
                    }
                    return '<div class="media align-items-center">
                            <a href="' . url('certify/show/' . encrypted_key($data->id, 'encrypt')) . '"
                            class="avatar  hover-translate-y-n3 course_img">
                            <img src="' . $url . '"
                            class="">
                            </a>
                            <div class="media-body ml-4 text-sm">
                            <a href="' . url('certify/show/' . encrypted_key($data->id, 'encrypt')) . '"
                            class="text-black" style="color: black;">
                            ' . $data->name . '
                            </a>
                            </div>
                            </div>';
                })->addColumn('price', function ($data) {

                    return format_price( $data->price);
                })->addColumn('duration', function ($data) {

                    return $data->duration . " " . $data->period;
                })->addColumn('status', function ($data) {

                    return $data->status;
                })->addColumn('exp_date', function ($data) {

                    return $data->getCategoryName($data->category);
                })->addColumn('action', function ($data) {
                    $authuser = Auth::user();
                    $actionBtn='';

                    $domain_id= get_domain_id();
                    $permissions= permissions();

                     $actionBtn = '<div class="actions text-right">

                                                <a class="btn btn-sm bg-info-light mr-1" href="'. url('certify/show/' . encrypted_key($data->id, 'encrypt')) .'">
                                                    <i class="fas fa-eye"></i>
                                                    View
                                                </a>';

                    if( $authuser->id ==$data->user_id && (in_array('course_create_regular', $permissions) ) || $authuser->type=="admin"){


                          $actionBtn .= '<a class="btn btn-sm bg-success-light" data-title="Edit " href="'.route('certify.edit', encrypted_key($data->id, 'encrypt')) .'">
                                                    <i class="fas fa-pencil-alt"></i>
                                                    Edit
                                                </a>
                                                <a data-url="' . url('certify/destroy/'.encrypted_key($data->id,'encrypt')) . '" href="#" class="btn btn-sm bg-danger-light delete_record_model">
                                                    <i class="far fa-trash-alt"></i> Delete
                                                </a>';
                    }
					elseif ($authuser->type == 'corporate') {
                        if (getCorpurateCertityDetails($data->id) == true) {
                            $actionBtn = '<a href="javascript:void(0);" data-id="' . $data->id . '"
                                               class="action-item addedCertify btn btn-sm bg-success-light" data-toggle="tooltip"
                                               data-original-title="Add To Catalog">
                                                <i class="fa fa-plus"></i>Add To Catalog
                                           </a>';
                        } else {
                            $actionBtn = ' <a href="javascript:void(0);" class="action-item addCertify btn btn-sm bg-success-light"
                                               data-id="' . $data->id . '" data-title="' . $data->name . '" data-toggle="tooltip"
                                               data-original-title="Add To Catalog">
                                               <i class="fa fa-plus"></i>Add To Catalog
                                            </a>';
                        }
                    }
					else{

                        if (checkExamStatus($data->id) == true) {
                            $actionBtn .= '<a class="btn btn-sm bg-warning-light" href="'.  url('certify/certificate/' . encrypted_key($data->id, 'encrypt')) .'">
                                                    <i class="fa fa-certificate"></i>
                                                    Certificate
                                                </a>';
                        }
                    }
                    $actionBtn .="</div>";

                    return $actionBtn;
                })
                ->rawColumns(['action', 'name','price'])
                ->make(true);
        } else {


            $CertifiesCount = Certify::where('user_id', $authuser->id)->whereMonth('created_at', date('m'))->count();
            $student = StripePayment::join('certifies', 'certifies.id', '=', 'stripe_payments.item_id')
                ->where('certifies.domain_id',$domain_id)
                ->groupBy('stripe_payments.user_id')
                    ->whereMonth('stripe_payments.created_at', date('m'))

                ->count();
            $income = StripePayment::join('certifies', 'certifies.id', '=', 'stripe_payments.item_id')
                ->where('certifies.domain_id', $domain_id)
                ->where('stripe_payments.item_type', "certify")
                    ->whereMonth('stripe_payments.created_at', date('m'))
                ->sum('total_price');
            $incomplete = StripePayment::join('certifies', 'certifies.id', '=', 'stripe_payments.item_id')
                ->where('stripe_payments.completed_on', "ongoing")
                ->where('stripe_payments.item_type', "certify")
                ->where('certifies.domain_id', $domain_id)
                    ->whereMonth('stripe_payments.created_at', date('m'))
                ->count();


            return view('certify.corporateindex', compact('CertifiesCount', 'authuser', 'type', 'income', 'student', 'incomplete', 'syndicateCertify'));
        }
    }
 
    public function mycourses(Request $request)
    {

        if ($request->ajax()) {
            $data = Certify::join('corporate_courses', 'corporate_courses.certify', '=', 'certifies.id')
                ->where('corporate_courses.user', Auth::id())
                ->select('certifies.*');
            return Datatables::of($data)
                ->addIndexColumn()
                       ->orderColumn('name', function ($query, $order) {
                     $query->orderBy('certifies.id', $order);
                 })
                ->filterColumn('name', function ($query, $keyword) use ($request) {
                    $sql = "certifies.name like ?";
                    $query->whereRaw($sql, ["%{$keyword}%"]);
                })
                ->addColumn('name', function ($data) {
                    return '<div class="media align-items-center">
                                <div>
                                    <a href="' . url('certify/show/' . encrypted_key($data->id, 'encrypt')) . '"
                                       class="">
                                        <img src="' . asset('storage') . '/certify/' . $data->image . '" class="avatar">
                                    </a>
                                </div>
                                <div class="media-body ml-4 text-sm">
                                    <a href="' . url('certify/show/' . encrypted_key($data->id, 'encrypt')) . '"
                                       class="text-black" style="color: black;">
                                        ' . $data->name . '
                                    </a>
                                </div>
                            </div>';
                })->addColumn('price', function ($data) {
                     return format_price( $data->price);
                })->addColumn('duration', function ($data) {
                    return '<i class="fa fa-calendar"></i>' . $data->duration . ' ' . $data->period;
                })->addColumn('status', function ($data) {
                    return '<span class="badge badge-dot mr-4">
                                <i class="' . (($data->status == 'Published') ? 'bg-success' : 'bg-danger') . '"></i>
                                <span class="status">' . $data->status . '</span>
                            </span>';
                })->addColumn('action', function ($data) {
                    $authuser = Auth::user();
                    $actionBtn = '<div class="actions text-center">
                                    <a href="javascript:void(0)" class="action-item addCertify btn btn-sm bg-danger-light"
                                       data-id="' . $data->id . '" data-toggle="tooltip"
                                       data-original-title="Remove from my courses">
                                        <i class="fas fa-minus"></i> Remove from Catalog
                                    </a>
                                </div>';
                    return $actionBtn;
                })
                ->rawColumns(['action', 'name', 'price', 'status', 'duration'])
                ->make(true);
        } else {
            return view('certify.corpurate');
        }
    }

    public function certifyCorpurateAddCertify(Request $request)
    {
        $MyCourse = new MyCourse();
        $MyCourse = $MyCourse->addData($request->corpurate_certify);
        if ($MyCourse) {
            return redirect()->route('certify.index')->with('success', __('Certify added successfully.'));
        } else {
            return redirect()->route('certify.index')->with('error', __('Certify not added.'));
        }
    }

    public function certifyCorpurateRemoveCertify(Request $request)
    {
        $MyCourse = new MyCourse();
        $MyCourse = $MyCourse->removeData($request->corpurate_certify);
        if ($MyCourse) {
            return redirect()->back()->with('success', __('Certify removed successfully.'));
        } else {
            return redirect()->back()->with('error', __('Certify not removed.'));
        }
    }



    public function certificate($id_encrypted)
    {
        $id = !empty($id_encrypted) ? encrypted_key($id_encrypted, 'decrypt') : 0;
        if ($id == false) {
            return redirect()->route('certify.index')->with('error', __('Permission Denied.'));
        }
        $authuser = Auth::user();

        //dd($Parent);
        $certify = Certify::find($id);
		   $Parent = User::where('id', $certify->user_id)->first();


        $StripePayment = StripePayment::where(['user_id' => $authuser->id, 'item_id' => $id, 'item_type' => 'certify'])->first();
        $CertificateData = Certificate::where('user','1')->first();

        $dataImg = "";
        $array1 = "";
        $array2 = "";
		$logo="";
		$badge="";
        if ($CertificateData) {
			if(!empty($CertificateData->badge)){
				 $path = 'https://stemx.com/storage/certify/' . $CertificateData->badge;
            $img = file_get_contents($path);
            $badge = base64_encode($img);
				
			}
			
			if(!empty($CertificateData->logo)){
			$path = 'https://stemx.com/storage/certify/' . $CertificateData->logo;
            $img = file_get_contents($path);
            $logo = base64_encode($img);
			}
            // Get the image and convert into string
            $path = 'https://stemx.com/storage/certificate/' . $CertificateData->template;

            $img = file_get_contents($path);
            $dataImg = base64_encode($img);
            $text = str_replace("{StudentName}", Auth::user()->name, $CertificateData->text);
            $text = str_replace("{CourseName}", $certify->name, $text);
            $str = str_word_count($text, 1);
            list($array1, $array2) = array_chunk($str, ceil(count($str) / 2));
            $array1 = implode(" ", $array1);
            $array2 = implode(" ", $array2);
			$top=$CertificateData->top;
			$header=$CertificateData->header;
			$footer=$CertificateData->footer;
        }
        return view('certify.certificate', compact('top','header','footer','authuser', 'certify', 'StripePayment', 'dataImg', 'CertificateData', 'array1', 'array2','logo','badge'));
    }

    public function updateCompletedDate()
    {
        $authuser = Auth::user();
        if ($authuser->type == 'admin' || $authuser->type == 'owner') {
            $StripePayment = new StripePayment();
            return $StripePayment;
        }
        if (isset($_GET['certify'])) {
            $certify_id = $_GET['certify'];
            $StripePayment = StripePayment::where(['user_id' => $authuser->id, 'item_id' => $certify_id, 'item_type' => 'certify'])->first();
            $StripePayment->completed_on = date("Y-m-d");
            $StripePayment = $StripePayment->save();
        }

        return $StripePayment;
    }

    public function addcertificate()
    {
        $authuser = Auth::user();
        $CertificateData = Certificate::where('user', $authuser->id)->first();

        return view('certify.addcertificate', compact('authuser', 'CertificateData'));
    }

    public function createcertificate(Request $request)
    {
        $authuser = Auth::user();
        $Certificate = Certificate::where(['user' => $authuser->id])->first();
        if (isset($request->name)) {
            $data = [
                'user' => $authuser->id,
                'text' => $request->name,
                'top' => $request->top,
                'header' => $request->header,
                'footer' => $request->footer,
				'template' => $request->template,
            ];

        } 
		
		if (!empty($request->logo)) {
            $image = '';
                $base64_encode = $request->logo;
                $folderPath = "storage/certify/";
                $image_parts = explode(";base64,", $base64_encode);
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_type = $image_type_aux[1];
                $image_base64 = base64_decode($image_parts[1]);
                $image = "certify" . uniqid() . '.' . $image_type;
                $file = $folderPath . $image;
                file_put_contents($file, $image_base64);
			$data = [
               
                'logo' => $image,
            ];           
		   }
           
       
		if (!empty($request->badge)) {
            $image = '';
            
                $base64_encode = $request->badge;
                $folderPath = "storage/certify/";
                $image_parts = explode(";base64,", $base64_encode);
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_type = $image_type_aux[1];
                $image_base64 = base64_decode($image_parts[1]);
                $image = "certify" . uniqid() . '.' . $image_type;
                $file = $folderPath . $image;
                file_put_contents($file, $image_base64);
           
            $data = [
               
                'badge' => $image,
            ];
        }

        if ($Certificate) {
          Certificate::where(['user' => $authuser->id])->update($data);
            return redirect()->back()->with('success', __('Certifcate added successfully.'));
        } else {
            Certificate::create($data);
            return redirect()->back()->with('success', __('Certifcate Updated successfully.'));
        }
    }

    public function createcertificateText()
    {
        $authuser = Auth::user();
        $Certificate = new Certificate();
        $Certificate['user_id'] = $authuser->id;
        return redirect()->route('certify.index')->with('success', __('Certifcate added successfully.'));
    }

    public function create()
    {
        $authuser = Auth::user();
        $domain_id= get_domain_id();
        $Certify_categories = DB::table('certify_categories')->orderByDesc('id')->get();
        $instructor = \App\Instructor::select("u.*")->join("users as u","u.id","=","instructors.user_id")->where('instructors.domain_id',$domain_id)->orderByDesc('instructors.id')->get();
        $countCertify_categories = count($Certify_categories);
//        $free_products = ShopProduct::where(['user_id' => $authuser->id])->get();
        $bls_industries = BlsIndustry::select('id','name')->get();
        return view('certify.create', compact('Certify_categories', 'countCertify_categories', 'instructor','bls_industries'));
    }

    public function masterCreate()
    {
        $authuser = Auth::user();
         $domain_id= get_domain_id();
        $bls_industries = BlsIndustry::select('id','name')->get();
        $Certify_categories = DB::table('certify_categories')->orderByDesc('id')->get();
        $countCertify_categories = count($Certify_categories);
       $instructor = \App\Instructor::select("u.*")->join("users as u","u.id","=","instructors.user_id")->where('instructors.domain_id', $domain_id)->orderByDesc('instructors.id')->get();
        return view('certify.masterClassCreate', compact('Certify_categories', 'countCertify_categories', 'instructor','bls_industries'));
    }

    public function update(Request $request)
    {
        Certify::where('id',$request->certifyId)->update(['bls_industry'=> $request->bls_industry]);

        $pennfosterStatus = 0;
        if (isset($_POST['pennfoster'])) {
            if ($_POST['pennfoster'] == 1) {
                $pennfosterStatus = 1;
            }
        }
        $authoritylabel = 0;
        if (isset($_POST['authoritylabel'])) {
            if ($_POST['authoritylabel'] == 1) {
                $authoritylabel = 1;
            }
        }
        $image = '';
        $addlogos = "";
        $post = $request->all();
        $data = Certify::find($request->certifyId);
        $image = '';
        if (!empty($request->image)) {
            $base64_encode = $request->image;
            $folderPath = "storage/certify/";
             if (!file_exists($folderPath)) {
File::isDirectory($folderPath) or File::makeDirectory($folderPath, 0777, true, true);
                }
            $image_parts = explode(";base64,", $base64_encode);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $image = "certify" . uniqid() . '.' . $image_type;
            $file = $folderPath . $image;
            file_put_contents($file, $image_base64);
        } else {
            $image = $data->image;
        }

        if (!empty($request->addlogos)) {
            $base64_encode = $request->addlogos;
            $folderPath = "storage/certify/";
             if (!file_exists($folderPath)) {
File::isDirectory($folderPath) or File::makeDirectory($folderPath, 0777, true, true);
                }
            $image_parts = explode(";base64,", $base64_encode);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $addlogos = "certify" . uniqid() . '.' . $image_type;

            $file = $folderPath . $addlogos;
            file_put_contents($file, $image_base64);
        } else {
            $addlogos = $data->logos;
        }

        if ($request->type == 'Regular') {
            if ($post['videotype'] == 'video') {
                if (!empty($request->hasFile('videofile'))) {
                    $fileNameToStore = time() . '.' . $request->videofile->getClientOriginalExtension();
                    $video = $request->file('videofile')->storeAs('certify', Str::random(20) . $fileNameToStore);
                    $post['video'] = $video;
                    $post['youtubelink'] = '';
                }
            } else {
                $post['video'] = '';
            }
        }

        if (!empty($request->hasFile('video'))) {
            $fileNameToStore = time() . '.' . $request->video->getClientOriginalExtension();
            $video = $request->file('video')->storeAs('certify', Str::random(20) . $fileNameToStore);
            $post['video'] = $video;
        } else {
            $post['video'] = $data->video;
        }
        $post['instructor'] = !empty($request->instructor) ? implode(',', $request->instructor) : '';
        $post['image'] = $image;
        $post['logos'] = $addlogos;
        $post['pennfoster'] = $pennfosterStatus;
        $post['authoritylabel'] = $authoritylabel;
        if (!empty($request->hasFile('course_file'))) {
            $fileNameToStore = time() . '.' . $request->course_file->getClientOriginalExtension();
            $course_details_file = $request->file('course_file')->storeAs('certify', Str::random(20) . $fileNameToStore);
            $post['course_file'] = $course_details_file;
        }
        $post['email_auto_reply']=!empty($request->email_auto_reply) ? 1 :0;
        $Certify = Certify::find($request->certifyId);
        $Certify->update($post);

        return redirect()->route('certify.index')->with('success', __('Certify Updated successfully.'));
    }

    public function destroy($id_encrypted=0)
    {

         $id = !empty($id_encrypted) ? encrypted_key($id_encrypted, 'decrypt') : 0;
        if (empty($id)) {
            return redirect()->route('certify.index')->with('error', __('Permission Denied.'));
        }
            $Certify = Certify::find($id);
            $Certify->delete();
            return redirect()->route('certify.index')->with('success', __('Certify deleted successfully.'));

    }

    public function edit($id_encrypted)
    {
        $id = !empty($id_encrypted) ? encrypted_key($id_encrypted, 'decrypt') : 0;
        if ($id == false) {
            return redirect()->route('certify.index')->with('error', __('Permission Denied.'));
        }
        $authuser = Auth::user();
        $domain_id= get_domain_id();
        $CertifyCategories = DB::table('certify_categories')->orderByDesc('id')->get();
        $Certify = Certify::find($id);
        $instructor = \App\Instructor::select("u.*")->join("users as u","u.id","=","instructors.user_id")->where('instructors.domain_id', $domain_id)->orderByDesc('instructors.id')->get();
//        $free_products = ShopProduct::where(['user_id' => $authuser->id])->get();
        $bls_industries = BlsIndustry::select('id','name')->get();
        return view('certify.edit', compact('Certify', 'CertifyCategories', 'instructor','bls_industries'));
    }

    public function store(Request $request)
    {
        $domain_id= get_domain_id();
        $pennfosterStatus = 0;
        if (isset($_POST['pennfoster'])) {
            if ($_POST['pennfoster'] == 1) {
                $pennfosterStatus = 1;
            }
        }
        $authoritylabel = 0;
        if (isset($_POST['authoritylabel'])) {
            if ($_POST['authoritylabel'] == 1) {
                $authoritylabel = 1;
            }
        }
        $image = '';
        $user = Auth::user();
        // echo "<pre>";print_r($request->all());die();
        if (!empty($request->image)) {

            $base64_encode = $request->image;
            $folderPath = "storage/certify/";
            if (!file_exists($folderPath)) {
                File::isDirectory($folderPath) or File::makeDirectory($folderPath, 0777, true, true);
            }
            $image_parts = explode(";base64,", $base64_encode);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $image = "certify" . uniqid() . '.' . $image_type;
            $file = $folderPath . $image;
            file_put_contents($file, $image_base64);
        }


        $addlogos = '';
        if (!empty($request->addlogos)) {

            $base64_encode = $request->addlogos;
            $folderPath = "storage/certify/";
            $image_parts = explode(";base64,", $base64_encode);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $addlogos = "addlogos" . uniqid() . '.' . $image_type;
            $file = $folderPath . $addlogos;
            file_put_contents($file, $image_base64);
        }

        $Certify = new Certify();
        $Certify['user_id'] = $user->id;
        $Certify['name'] = $request->name;
        $Certify['image'] = $image;
        $Certify['logos'] = $addlogos;

        if ($request->type == 'Masterclass') {
            if (!empty($request->instructor)) {
                $Certify['instructor'] = implode(',', $request->instructor);
            } else {
                $Certify['instructor'] = $user->id;
            }
        } else {
            $Certify['instructor'] = !empty($request->instructor) ? implode(',', $request->instructor) : '';
        }


        $Certify['price'] = $request->price;
        $Certify['sale_price'] = $request->sale_price;
        $Certify['certification'] = $request->certification;
        $Certify['boardcertified'] = $request->boardcertified;
        $Certify['degree'] = $request->degree;
        $Certify['specialization'] = $request->specialization;
        $Certify['cecredit'] = $request->cecredit;
        $Certify['prerequisites'] = $request->prerequisites;
        $Certify['description'] = $request->description;
        $Certify['duration'] = $request->duration;
        $Certify['period'] = $request->period;
        $Certify['category'] = $request->category;
        $Certify['syndicate'] = $request->syndicate;
        $Certify['status'] = $request->status;
        if (isset($request->product) && !empty($request->product)) {
            $Certify['product'] = $request->product;
        }
        $Certify['pennfoster'] = $pennfosterStatus;
        $Certify['domain_id'] = $domain_id;
        $Certify['viewtype'] = $request->viewtype;
        $Certify['commision'] = $request->commision;
        $Certify['type'] = $request->type;
        $Certify['videotype'] = $request->videotype;
        $Certify['authoritylabel'] = $authoritylabel;
        $Certify['bls_industry'] = $request->bls_industry;
        if ($request->videotype == 'video') {
            if (!empty($request->hasFile('videofile'))) {
                $fileNameToStore = time() . '.' . $request->videofile->getClientOriginalExtension();
                $video = $request->file('videofile')->storeAs('certify', Str::random(20) . $fileNameToStore);
                $Certify['video'] = $video;
            }
        } else {
            $Certify['youtubelink'] = $request->youtubelink;
        }
        if (!empty($request->hasFile('video'))) {
            $fileNameToStore = time() . '.' . $request->video->getClientOriginalExtension();
            $video = $request->file('video')->storeAs('certify', Str::random(20) . $fileNameToStore);
            $Certify['video'] = $video;
        }
        if (!empty($request->hasFile('course_file'))) {
            $fileNameToStore = time() . '.' . $request->course_file->getClientOriginalExtension();
            $course_details_file = $request->file('course_file')->storeAs('certify', Str::random(20) . $fileNameToStore);
            $Certify['course_file'] = $course_details_file;
        }
        $Certify['email_auto_reply']=!empty($request->email_auto_reply) ? 1 :0;
        $Certify->save();

        ///add in certifiy
         $data= array(
                    'email' => $user->email,
                    'fname' => $user->name,
                    'phone' => $user->phone,
                );
            $response= \App\Contacts::create_contact($data, 'Cources');

            $user = Auth::user();
            $rolescheck = \App\Role::whereRole($user->type)->first();
            if($rolescheck->role == 'mentor' ){
                if(checkPlanModule('points')){
                    $checkPoint = \Ansezz\Gamify\Point::find(2);
                    if(isset($checkPoint) && $checkPoint != null ){
                        if($checkPoint->allow_duplicate == 0){
                            $createPoint = $user->achievePoint($checkPoint);
                        }else{
                            $addPoint = DB::table('pointables')->where('pointable_id', $user->id)->where('point_id', $checkPoint->id)->get();
                            if($addPoint == null){
                                $createPoint = $user->achievePoint($checkPoint);
                            }
                        }
                    }
                }
            }
        return redirect()->route('certify.index')->with('success', __('Certify added successfully.'));
    }

    public function featchData($view = 'list')
    {
        $authuser = Auth::user();
        if (isset($_GET['type']) && $_GET['type'] == 'Masterclass') {
            $type = 'Masterclass';
        } else {
            $type = 'Regular';
        }
        $Certifies = Certify::where('user_id', '=', $authuser->id)->where('type', '=', $type)->orderByDesc('id')->get();
        if (isset($_GET['view'])) {
            $view = 'list';
            $returnHTML = view('certify.list', compact('view', 'Certifies', 'type', 'authuser'))->render();
        } else {
            $returnHTML = view('certify.grid', compact('view', 'Certifies', 'type', 'authuser'))->render();
        }

        return response()->json(
            [
                'success' => true,
                'html' => $returnHTML,
            ]
        );
    }

    public function CertifyCategoriesIndex(Request $request)
    {

        $authuser = Auth::user();
        if ($request->ajax()) {
            $authuser = Auth::user();
            $data = CertifyCategory::select('id','name','icon')->orderByDesc('id');
            return Datatables::of($data)
                ->addIndexColumn()
                ->filterColumn('name', function ($query, $keyword) use ($request) {
                    $sql = "certify_categories.name like ?";
                    $query->whereRaw($sql, ["%{$keyword}%"]);
                })->addColumn('name', function ($data) {
                    if (!empty($data->icon)) {
                        if (file_exists(storage_path() . '/certify/icon/' . $data->icon)) {
                            $url = asset('storage/certify/icon/' . $data->icon);
                        } else {
                            $url = asset('public/assets_admin/img/user/user.jpg');
                        }
                    } else {
                        $url = asset('public/assets_admin/img/user/user.jpg');
                    }
                    $html='<h2 class="table-avatar"><a href="#" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="'.$url.'" alt="'.$data->name.'"></a><a href="#">'.$data->name.'</a></h2>';
                    return $html;
                })->addColumn('action', function ($data) {
                    if ($data->id == 0) {
                        $actionBtn = '<i class="fas fa-exclamation-triangle text-center"></i>';
                    } else {
                        $actionBtn = '';


                          $actionBtn = '<div class="actions text-right">
                                                <a class="btn btn-sm bg-success-light" data-title="Edit Category" href="'.route('certify.category.edit', encrypted_key($data->id, 'encrypt')).'">
                                                    <i class="fas fa-pencil-alt"></i>
                                                    Edit
                                                </a>
                                                <a data-url="' . route('certify.category.destroy',encrypted_key($data->id,'encrypt')) . '" href="#" class="btn btn-sm bg-danger-light delete_record_model">
                                                    <i class="far fa-trash-alt"></i> Delete
                                                </a>
                                            </div>';
                    }
                    return $actionBtn;
                })
                ->rawColumns(['name', 'action'])
                ->make(true);
        }
        return view('certify.certifyCategories.index');
    }

    public function CertifyCategoriesCreate()
    {
        return view('certify.certifyCategories.create');
    }

    public function CertifyCategoriesFeatchdata($view = 'list')
    {
        $authuser = Auth::user();
        $CertifyCategories = CertifyCategory::select('id','name')->where('user_id', '=', $authuser->id)->orwhere('user_id', '=', '0')->orderByDesc('id')->get();
        return view('certify.certifyCategories.list', compact('view', 'CertifyCategories'));
    }

    public function CertifyCategoriesEdit($id=0)
    {
$id = encrypted_key($id, 'decrypt') ?? $id;
         if (empty($id)) {
            return redirect()->back()->with('success', __('Id is mismatch.'));
        }
        $CertifyCategory = CertifyCategory::find($id);
        return view('certify.certifyCategories.edit', compact('CertifyCategory'));
    }

    public function CertifyCategoriesDestroy($id=0)
    {
        $id = encrypted_key($id, 'decrypt') ?? $id;
        if (empty($id)) {
            return redirect()->back()->with('success', __('Id is mismatch.'));
        }

            $CertifyCategory = CertifyCategory::find($id);
            $CertifyCategory->delete();
            return redirect()->back()->with('success', __('Certify Category deleted successfully.'));

    }

    public function CertifyCategoriesUpdate(Request $request)
    {
        $validator = Validator::make(
            $request->all(), [
                'name' => 'required',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        }
         $image='';
        if (!empty($request->image)) {

            $base64_encode = $request->image;
            $folderPath = "storage/certify/icon/";
             if (!file_exists($folderPath)) {
File::isDirectory($folderPath) or File::makeDirectory($folderPath, 0777, true, true);
                }
            $image_parts = explode(";base64,", $base64_encode);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $image = "certify" . uniqid() . '.' . $image_type;
            $file = $folderPath . $image;
            file_put_contents($file, $image_base64);
        }


        $post = $request->all();
        $CertifyCategory = CertifyCategory::find($request->id);
         $CertifyCategory->name = $request->name;
         if(!empty($image)){
         $CertifyCategory->icon = $image;
         }
        $CertifyCategory->update($post);

        return redirect()->route('certify.categories')->with('success', __('Certify Category Updated successfully.'));
    }

    public function CertifyCategoriesStore(Request $request)
    {
        $user = Auth::user();
        $CertifyCategory = new CertifyCategory();
        $image='';
        if (!empty($request->image)) {

            $base64_encode = $request->image;
            $folderPath = "storage/certify/icon/";
             if (!file_exists($folderPath)) {
File::isDirectory($folderPath) or File::makeDirectory($folderPath, 0777, true, true);
                }
            $image_parts = explode(";base64,", $base64_encode);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $image = "certify" . uniqid() . '.' . $image_type;
            $file = $folderPath . $image;
            file_put_contents($file, $image_base64);
        }
        $CertifyCategory['name'] = $request->name;
         $CertifyCategory['icon'] = $image;
        $CertifyCategory['user_id'] = $user->id;
        $CertifyCategory->save();
        if ($CertifyCategory) {
            return redirect()->back()->with('success', __('Certify Category Added successfully.'));
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function curriculumStore(Request $request)
    {
        $authuser = Auth::user();
        $post = $request->all();
        $certifyId = $post['certify'];
        $chapters = array();
        $lectures = array();
        if (isset($post['chapterid'])) {
            for ($i = 0; $i < count($post['chapterid']); $i++) {
                $chapters[$i] = array('id' => $post['chapterid'][$i], 'indexing' => $post['indexing'][$i], 'title' => $post['chaptertitle'][$i], 'description' => $post['chapterdescription'][$i]);
            }
        }
        if (isset($post['lectureid'])) {
            for ($i = 0; $i < count($post['lectureid']); $i++) {
                $lectures[$i] = array('id' => $post['lectureid'][$i], 'indexing' => $post['lectureindexing'][$i], 'title' => $post['lecturetitle'][$i], 'description' => $post['lecturedescription'][$i], 'type' => $post['type'][$i], 'content' => $post['content'][$i]);
            }
        }
        foreach ($chapters as $key => $chapter) {
            $saveChapter = CertifyChapter::find($chapter['id']);
            $saveChapter->update($chapter);
        }
        foreach ($lectures as $key => $lecture) {
            $saveLecture = Lecture::find($lecture['id']);
            $saveLecture->update($lecture);
        }
        return redirect()->back()->with('success', __('Curriculum Updated successfully.'));
    }

    public function curriculumSave(Request $request)
    {
        $authuser = Auth::user();
        $maxIndex = DB::select('select MAX(indexing) as indexing from certify_chapters where certify = ' . $request->certify_id);
        if ($maxIndex[0]->indexing > 0) {
            $indexing = $maxIndex[0]->indexing + 1;
        } else {
            $indexing = 1;
        }

        $CertifyChapter = new CertifyChapter();
        $CertifyChapter['certify'] = $request->certify_id;
        $CertifyChapter['title'] = $request->title;
        $CertifyChapter['description'] = $request->description;
        $CertifyChapter['type'] = $request->type;
        $CertifyChapter['indexing'] = $indexing;
        $CertifyChapter->save();
        if ($CertifyChapter) {
            return redirect()->back()->with('success', __('Curriculum Saved successfully.'));
        } else {
            return redirect()->back()->with('error', __('OopsError.'));
        }
    }

    public function lectureFileSave(Request $request)
    {

        $lactureId = $request->lectureId;
        $lecture = Lecture::find($lactureId);
        $content = "";
        if (!empty($request->hasFile('file'))) {
            $fileNameToStore = time() . '.' . $request->file->getClientOriginalExtension();
            $content = $request->file('file')->storeAs('certify', Str::random(20) . $fileNameToStore);
        }
        if (!empty($request->hasFile('content'))) {
            $lecture->deletePreviousScormFiles();
            $identifier = md5(rand(10000, 99999));
            $fileNameToStore = $identifier . '.' . $request['content']->getClientOriginalExtension();
            $uploadPath = Lecture::SCORM_UPLOAD_FILE_LOCATION;
            $request->file('content')->storeAs(Lecture::SCORM_UPLOAD_FILE_PATH, $fileNameToStore);
            $fullPath = $uploadPath . $fileNameToStore;
            $content = $identifier;
            $zip = new ZipArchive;
            $zip->open($fullPath);
            $zip->extractTo(Lecture::SCORM_EXTRACT_FILE_PATH . $identifier);
            $zip->close();
            File::delete($fullPath);
        }

        if ($content != "") {
            $lecture->content = $content;
            if ($request->scorm_provider != "") {
                $lecture->scorm_provider = $request->scorm_provider;
            }
            $lecture->save();
            if ($lecture) {
                return redirect()->back()->with('success', __('File Saved successfully.'));
            } else {
                return redirect()->back()->with('error', __('OopsError.'));
            }
        } else {
            return redirect()->back()->with('error', __('OopsError.'));
        }
    }

    public function lectureSave(Request $request)
    {

        $authuser = Auth::user();
        $maxIndex = DB::select('select MAX(indexing) as indexing from lectures where certify = ' . $request->certify_id . ' AND chapter = ' . $request->chapter_id);
        if ($maxIndex[0]->indexing > 0) {
            $indexing = $maxIndex[0]->indexing + 1;
        } else {
            $indexing = 1;
        }
        if (!empty($request->hasFile('content'))) {
              if ($request->type == "scorm") {
                $identifier = md5(rand(10000, 99999));
                $fileNameToStore = $identifier . '.' . $request['content']->getClientOriginalExtension();
                $uploadPath = Lecture::SCORM_UPLOAD_FILE_LOCATION;
                $zipFile = $request->file('content');
                $zipFile->move($uploadPath, $fileNameToStore);
                $fullPath = $uploadPath . $fileNameToStore;
                $content = $identifier;
                $zip = new ZipArchive;
				$zip->open($fullPath);

             $zip->extractTo(Lecture::SCORM_EXTRACT_FILE_PATH . $identifier);

		   $zip->close();
                File::delete($fullPath);
            } else {
                $fileNameToStore = time() . '.' . $request['content']->getClientOriginalExtension();


                $content = $request->file('content')->storeAs('certify', Str::random(20) . $fileNameToStore);

            }
        } else {
            $content = $request['content'];
        }
        $Lecture = new Lecture();
        $Lecture['title'] = $request->title;
        $Lecture['description'] = $request->description;
        $Lecture['type'] = $request->type;
        $Lecture['content'] = $content;
        $Lecture['scorm_provider'] = $request->scorm_provider;
        $Lecture['indexing'] = $indexing;
        $Lecture['chapter'] = $request->chapter_id;
        $Lecture['certify'] = $request->certify_id;
        $Lecture->save();
        if ($Lecture) {
            return redirect()->back()->with('success', __('Lecture Saved successfully.'));
        } else {
            return redirect()->back()->with('error', __('OopsError.'));
        }
    }

    public function scromFileData(Request $request)
    {
        $returnHTML = view('certify.scorm.fileData')->render();
        return response()->json(array('success' => true, 'html' => $returnHTML));
    }

    public function certifyCurriculumCreate($id)
    {
        if ($id) {
            $model = new CertifyChapter();
            return view('certify.certifyCurriculum.curriculumCreate', compact('id', 'model'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function learnview($id_encrypted)
    {
        $id = !empty($id_encrypted) ? encrypted_key($id_encrypted, 'decrypt') : 0;
        if ($id == false) {
            return redirect()->route('certify.index')->with('error', __('Permission Denied.'));
        }
        if ($id) {

            $user = Auth::user();
            //recording penn foster record
            $Certify_detail = \App\Certify::where('id', $id)->first();
            if ($Certify_detail) {
                //send data to penn fooster
//                if (empty($Certify_detail->pennfoster)) {
//                    $courses = \App\PennfosterLogs::where("user_id", $user->id)->where("course_id", $id)->first();
//                    if (empty($courses)) {
//                        $penfoster_res = \App\PennfosterLogs::record_log($user->id, $id);
//                    }
//                }
            }


            return view('certify.learnview', compact('id'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function featchDatalearnview()
    {
        $authuser = Auth::user();
        if (isset($_GET['certify'])) {
            $Certify = Certify::find($_GET['certify']);
            $Chapters = DB::table('certify_chapters')->where('certify', '=', $Certify->id)->orderBy('indexing', 'ASC')->get();
            foreach ($Chapters as $Chapter) {
                $Chapter->lectures = DB::table('lectures')->where('chapter', '=', $Chapter->id)->orderBy('indexing', 'ASC')->get();
            }
        }
        $returnHTML = view('certify.learnGrid', compact('Certify', 'Chapters'))->render();

        return response()->json(
            [
                'success' => true,
                'html' => $returnHTML,
            ]
        );
    }

    public function lernLecturedata(Request $request)
    {
        $authuser = Auth::user();
        if (isset($request->id)) {
            //$lecture = DB::table('lectures')->where('id', '=', $_GET['id'])->first();
            $lecture = Lecture::find($request->id);
        } else {
            return redirect()->back()->with('error', __('Lecture id Not Found.'));
        }
        $returnHTML = view('certify.learnGridData', compact('lecture'))->render();
        return response()->json(
            [
                'success' => true,
                'html' => $returnHTML,
            ]
        );
    }

    public function syndicate(Request $request)
    {

        $status = 'approved';
        $authuser = Auth::user();
		
		if (!empty($_GET['code']) && empty($authuser->stripe_account_id)) {
                \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

                try {
                    $response = \Stripe\OAuth::token([
                                'grant_type' => 'authorization_code',
                                'code' => $_GET['code'],
                    ]);
                } catch (\Exception $e) {
                    return "Error: " . $e->getMessage();
                }

                if (isset($response->stripe_user_id)) {
                    DB::table("users")->where("id", $authuser->id)->update(array(
                        "stripe_account_id" => $response->stripe_user_id
                    ));
					
					if($authuser->type =='admin'){
						
						 $arrEnv  = array();
						$arrEnv['COMMISSION_STATUS'] = '1';
						$env = Utility::setEnvironmentValue($arrEnv);
						return redirect()->route('admin.site.settings')->with('success', __('Stripe account successfully connected.'));
					}
                } else {
                    return "Error: " . $response->error_description;
                }
            }
        if ($request->ajax()) {


            if ($authuser->type == 'admin') {

                      $data = Certify::where('syndicate', 'Enabled')->where('syndicate_approval', 'APPROVE');

            } else {
                $data = Certify::where('syndicate', 'Enabled')->where('syndicate_approval', 'APPROVE');
            }


            return Datatables::of($data)
                ->addIndexColumn()
                ->filterColumn('name', function ($query, $keyword) use ($request) {
                    $sql = "certifies.name like ?";
                    $query->whereRaw($sql, ["%{$keyword}%"]);
                })->addColumn('name', function ($data) {
                    return $data->name;
                })->addColumn('type', function ($data) {
                    return $data->type;
                })->addColumn('price', function ($data) {
                    return '$' . $data->price;
                })->addColumn('status', function ($data) {
                    $authuser = Auth::user();
                    $status = 'approved';


                    if ($status == 'pending') {
                        $actionBtn = '<div class="custom-control custom-switch customSyndicate">
                                        <input type="checkbox" class="custom-control-input"
                                               id="custom' . $data->id . '" value="' . $data->id . '"
                                               ' . (($data->syndicate_approval == 'APPROVE') ? 'checked' : '') . '>
                                        <label class="custom-control-label" for="custom' . $data->id . '"></label>
                                    </div>';
                    } else {

					 if ($authuser->type == 'admin') {
							   $actionBtn = '<div class="custom-control custom-switch customSwitches">
                                        <input type="checkbox" class="custom-control-input"
                                               id="customSwitches' . $data->id . '" value="' . $data->id . '"
                                               ' . (($data->syndicate_approval == 'APPROVE') ? 'checked' : '') . '>
                                        <label class="custom-control-label"
                                               for="customSwitches' . $data->id . '"></label>
                                    </div>';
						}
						else{
							$showsyndicate=Showsyndicate::where('certify_id',$data->id)->where('user_id',$data->user_id)->first();
							if($showsyndicate){

							}
							else{

							}
							
							if($data->user_id != $authuser->id){
								 if (!empty($authuser->stripe_account_id)){
									 $actionBtn = '<div class="custom-control custom-switch customSwitchesFrontend">
                                        <input type="checkbox" class="custom-control-input"
                                               id="customSwitches' . $data->id . '" value="' . $data->id . '"
                                               ' . (($showsyndicate) ? 'checked' : '') . '>
                                        <label class="custom-control-label"
                                               for="customSwitches' . $data->id . '"></label>
                                    </div>';
								 } 
								 else{
									$actionBtn = '<div class="custom-control custom-switch customSwitchesSyndicate">
                                        <input type="checkbox" class="custom-control-input"
                                               id="customSwitches' . $data->id . '" value="' . $data->id . '"
                                               ' . (($showsyndicate) ? 'checked' : '') . '>
                                        <label class="custom-control-label"
                                               for="customSwitches' . $data->id . '"></label>
                                    </div>'; 
								 }
								
								
							}
							
							else{
								
								$actionBtn ='';
							}
							   

						}

                    }
                    return $actionBtn;
                })
                ->rawColumns(['status'])
                ->make(true);
        } else {
            $status = 'approved';
            $authuser = Auth::user();
            if ($authuser->type == 'admin') {
                if (isset($_GET['status']) && $_GET['status'] == 'pending') {
                    $status = $_GET['status'];
                    $syndicate = DB::table('certifies')->where('syndicate', '=', 'Enabled')->get();
                } else {
                    $syndicate = DB::table('certifies')->where('syndicate', '=', 'Enabled')->where('syndicate_approval', '=', 'APPROVE')->get();
                }
            } else {
                $syndicate = DB::table('certifies')->where('syndicate', '=', 'Enabled')->where('syndicate_approval', '=', 'APPROVE')->where('user_id', '=', $authuser->id)->get();
            }
            return view('certify.syndicate', compact('status', 'authuser'));
        }

    }




    public function pending_syndicate(Request $request)
    {


        $authuser = Auth::user();
        if ($request->ajax()) {


            if ($authuser->type == 'admin') {
                $data = Certify::where('syndicate', 'Enabled')->where('syndicate_approval', 'PENDING');
            } else {
                $data = Certify::where('syndicate', 'Enabled')->where('syndicate_approval', 'PENDING')->where('user_id',  $authuser->id);
            }


            return Datatables::of($data)
                ->addIndexColumn()
                ->filterColumn('name', function ($query, $keyword) use ($request) {
                    $sql = "certifies.name like ?";
                    $query->whereRaw($sql, ["%{$keyword}%"]);
                })->addColumn('name', function ($data) {
                    return $data->name;
                })->addColumn('type', function ($data) {
                    return $data->type;
                })->addColumn('price', function ($data) {
                    return '$' . $data->price;
                })->addColumn('status', function ($data) {
                    $authuser = Auth::user();

                        $status = 'pending';


                   if ($authuser->type == 'admin') {
                       $actionBtn = '<div class="custom-control custom-switch customSwitches">
                                        <input type="checkbox" class="custom-control-input"
                                               id="customSwitches' . $data->id . '" value="' . $data->id . '"
                                               ' . (($data->syndicate_approval == 'APPROVE') ? 'checked' : '') . '>
                                        <label class="custom-control-label"
                                               for="customSwitches' . $data->id . '"></label>
                                    </div>';
				   }else{
					    $actionBtn = 'Pending';

				   }
                    return $actionBtn;
                })
                ->rawColumns(['status'])
                ->make(true);
        } else {

            $authuser = Auth::user();
            if ($authuser->type == 'admin') {

                    $syndicate = DB::table('certifies')->where('syndicate', '=', 'Enabled')->where('syndicate_approval', '=', 'PENDING')->get();

            } else {
                $syndicate = DB::table('certifies')->where('syndicate', '=', 'Enabled')->where('syndicate_approval', '=', 'PENDING')->where('user_id', '=', $authuser->id)->get();
            }
            return view('certify.pending_syndicate', compact('authuser'));
        }

    }

    public function marketplace(Request $request)
    {
        $authuser = Auth::user();
        if ($authuser->type != 'owner') {
            return redirect()->route('certify.index')->with('error', __('Permission Denied.'));
        }
        if ($request->ajax()) {
            $authuser = Auth::user();
            $user = User::where('type', '=', 'admin')->first();
            $data = DB::table('certifies')->where('syndicate', '=', 'Enabled')->where('user_id', '=', $user->id);
            return Datatables::of($data)
                ->addIndexColumn()
                ->filterColumn('name', function ($query, $keyword) use ($request) {
                    $sql = "certifies.name like ?";
                    $query->whereRaw($sql, ["%{$keyword}%"]);
                })
                ->addColumn('name', function ($data) {
                    if (!empty($data->image)) {
                        if (file_exists(storage_path() . '/certify/' . $data->image)) {
                            $url = asset('storage/certify/' . $data->image);
                        } else {
                            $url = asset('public/demo.png');
                        }
                    } else {
                        $url = asset('public/demo.png');
                    }
                    return '<div class="media align-items-center">
                            <img src="' . $url . '" class="avatar  hover-translate-y-n3 course_img">
                            <div class="media-body ml-4 text-sm">
                            ' . $data->name . '
                            </div>
                            </div>';
                })
                ->addColumn('type', function ($data) {
                    return $data->type;
                })
                ->addColumn('price', function ($data) {

                    return '$' . $data->price;
                })
                ->addColumn('action', function ($data) {
                    $actionBtn = '';
                    $actionBtn .= '<div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input swicherClass"
                                            ' . ((checkMarketPlace($data->id) == true) ? 'checked' : '') . '
                                              id="customSwitches' . $data->id . '" value="' . $data->id . '">
                                              <label class="custom-control-label" for="customSwitches' . $data->id . '"></label>
                                        </div>';
                    return $actionBtn;
                })
                ->rawColumns(['name', 'action'])
                ->make(true);
        }
        return view('certify.marketplace');
    }

    public function activeMarketplace(Request $request)
    {
        if ($request->action == 'add') {
            $Marketplace = new Marketplace();
            $Marketplace = $Marketplace->addData($request);
        } else {
            $Marketplace = new Marketplace();
            $Marketplace = $Marketplace->deleteData($request);
        }
        if ($Marketplace) {
            return array('data' => $Marketplace, 'message' => 'status changed', 'status' => true);
        }
    }

    public function syndicateStripe()
    {
        $responce = [];
        $authuser = Auth::user();
        if (isset($_GET['certifyId'])) {
            $certifyId = $_GET['certifyId'];
        } else {
            $certifyId = '';
        }
        if (empty($authuser->stripe_account_id)) {
            return $responce = [
                'status' => false,
                'dataType' => 'stripe',
                'data' => "https://connect.stripe.com/express/oauth/authorize?redirect_uri=https://stemx.com/site-settings&client_id=" . env('STRIPE_CLIENT_ID')
            ];
        }

        if ($certifyId) {
            $syndicate = new Syndicate();
            $syndicate = $syndicate->saveData($certifyId);
            if ($syndicate) {
                return $responce = [
                    'status' => true,
                    'dataType' => 'data'
                ];
            }
        }
    }

    public function syndicateStripeDisable()
    {
        $authuser = Auth::user();
        if (isset($_GET['certifyId'])) {
            $certifyId = $_GET['certifyId'];
        } else {
            $certifyId = '';
        }
        $syndicate = new Syndicate();
        $syndicate = $syndicate->deleteData($certifyId);
        if ($syndicate) {
            return $responce = [
                'status' => true,
                'dataType' => 'data'
            ];
        }
    }


    public function syndicatePending()
    {
        $authuser = Auth::user();
        if (isset($_GET['certifyId']) && !empty($_GET['certifyId'])) {
            $certifyid = $_GET['certifyId'];
            $certify = Certify::find($certifyid);
            if ($certify) {
                $certify->syndicate_approval = 'PENDING';
                $certify->save();
            }
            return true;
        } else {
            return false;
        }
    }

    public function syndicateRevenue(Request $request)
    {
        $authuser = Auth::user();
        if ($request->ajax()) {
            $authuser = Auth::user();
            if ($authuser->type == 'admin') {
                $data = Syndicatepayment::orderByDesc('id');
            } elseif ($authuser->type == 'mentor') {
                $data = Syndicatepayment::where(['owner' => $authuser->id])->orwhere(['promoter' => $authuser->id])->orderByDesc('id');
            }
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('certify', function ($data) {
                    if (getCertifyDetails($data->certify)) {
                        return getCertifyDetails($data->certify)->name;
                    } else {
                        return 'Item Deleted';
                    }
                })
                ->addColumn('amount', function ($data) {
                    return '$' . $data->amount;
                })
                ->addColumn('buyer', function ($data) {
                    if (getUserDetails($data->buyer)) {
                        return getUserDetails($data->buyer)->name;
                    } else {
                        return 'User Deleted';
                    }
                })
                ->addColumn('owner_share', function ($data) {
                    return '$' . $data->owner_share;
                })
                ->addColumn('promoter_share', function ($data) {
                    return '$' . $data->promoter_share;
                })
                ->addColumn('admin_share', function ($data) {
                    return '$' . $data->admin_share;
                })
                ->rawColumns(['certify', 'buyer'])
                ->make(true);
        } else {
            return view('certify.syndicateRevenue', compact('authuser'));
        }

    }

    public function featchDataSyndicate($status = 'approved')
    {
        $authuser = Auth::user();
        if ($authuser->type == 'admin') {
            if (isset($_GET['status']) && $_GET['status'] == 'pending') {
                $status = $_GET['status'];
                $syndicate = DB::table('certifies')->where('syndicate_approval', '=', 'PENDING')->get();
            } else {
                $syndicate = DB::table('certifies')->where('syndicate_approval', '=', 'APPROVE')->get();
            }
        } else {
            $syndicate = DB::table('certifies')->where('syndicate_approval', '=', 'APPROVE')->where('user_id', '=', $authuser->id)->get();
        }

        $returnHTML = view('certify.syndicatelist', compact('status', 'syndicate', 'authuser'))->render();


        return response()->json(
            [
                'success' => true,
                'html' => $returnHTML,
            ]
        );
    }

    public function show(Request $request, $id_encrypted)
    {
        $id = !empty($id_encrypted) ? encrypted_key($id_encrypted, 'decrypt') : 0;
        if ($id == false) {
            return redirect()->route('certify.index')->with('error', __('Permission Denied.'));
        }
        $authuser = Auth::user();
            $Certify = Certify::find($id);
        $exams = DB::table('exams')->where('certify', '=', $id)->paginate(5);

        $Chapters = DB::table('certify_chapters')->where('certify', '=', $id)->get();
        $students = StripePayment::where(['item_id' => $id, 'item_type' => 'certify'])->get();
        if ($request->ajax()) {

          $data = DB::table('exams')->where('certify', '=', $id);
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('name', function ($data) {

                        return $data->name;

                })->addColumn('questions', function ($data) {

					 $questions = DB::table('courses_questions')->where('examid', '=', $data->id)->get();
					 $examcourses_questions = count($questions);
					   return $examcourses_questions;

                })->addColumn('status', function ($data) {

                  return $data->status;

                })->addColumn('students', function ($data) {
					$studentCount = DB::table('examsreports')->where('exam', '=', $data->id)->get();
					  $examstudentCount= count($studentCount);
                    return $examstudentCount;

                })->addColumn('action', function ($data) {

				    $ahuser = Auth::user();
                     $actionBtn = '
					      <div class="dropdown">
                                                        <button
                                                            class="btn btn-sm btn-white btn-icon-only rounded-circle"
                                                            type="button" id="dropdownMenu2" data-toggle="dropdown"
                                                            aria-haspopup="true" aria-expanded="false">
                                                            <span class="btn-inner--icon"><i class="fas fa-filter"></i></span>
                                                        </button>
					 <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                                            <button class="dropdown-item" type="button">
                                                                <a class="dropdown-item"
                                                                   href="' . route('certify.exam.examperview',['id'=>encrypted_key($data->id,'encrypt')]).'"
                                                                   data-val="created_at-asc">
                                                                    <i class="fas fa-search-dollar"></i>Preview Exam
                                                                </a>
                                                            </button>';
                                                            if($ahuser->type=='mentor' || $ahuser->type=='admin')  {


                                      $actionBtn .=  '<button class="dropdown-item" type="button">
                                                                    <a class="dropdown-item"
                                                                       href="' . url('certify/exam/build/'.encrypted_key($data->id,'encrypt')).'"
                                                                       data-val="created_at-asc">
                                                                        <i class="fas fa-edit"></i>Exam Editor
                                                                    </a>
                                                                </button>
                                                                <button class="dropdown-item" type="button">
                                                                    <a class="dropdown-item"
                                                                       href="' . route('certify.exam.students',['id'=>encrypted_key($data->id,'encrypt')]).'"
                                                                       data-val="created_at-asc">
                                                                        <i class="fas fa-list-ol"></i>Students List
                                                                    </a>
                                                                </button>
                                                                <button class="dropdown-item" type="button">
                                                                    <a class="dropdown-item destroyExam"
                                                                       data-id="'.$data->id.'"
                                                                       certifyid=""
                                                                       href="javascript:void(0)"
                                                                       data-val="created_at-asc">
                                                                        <i class="fas fa-trash"></i>Delete Exam
                                                                    </a>
                                                                </button>

                                                        </div> </div>';

															}

						return	 $actionBtn ;

                })
                ->rawColumns(['students', 'questions', 'status', 'name', 'action'])
                ->make(true);
        } else {
            return view('certify.certifyChapters.show', compact('authuser', 'Chapters', 'Certify', 'exams', 'students'));
        }

    }

	public function student_enroll(Request $request){

		  $authuser = Auth::user();

        if ($request->ajax()) {
            $data = StripePayment::join('certifies as c', 'stripe_payments.item_id', '=', 'c.id')
                ->join('users','users.id','=','stripe_payments.user_id')
                ->select("stripe_payments.*", 'c.name as course_name', 'c.image as course_image', 'c.id as course_id','users.name as username')
                ->where(['c.user_id' => $authuser->id, 'item_type' => 'certify']);
            return Datatables::of($data)
                ->addIndexColumn()
                ->filterColumn('course', function ($query, $keyword) use ($request) {
                    $query->orWhere('c.name', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('users.name', 'LIKE', '%' . $keyword . '%');
                })->addColumn('course', function ($data) {
                    if (!empty($data->course_image)) {
                        if (file_exists(storage_path() . '/certify/' . $data->course_image)) {
                            $url = asset('storage/certify/' . $data->course_image);
                        } else {
                            $url = asset('public/demo.png');
                        }
                    } else {
                        $url = asset('public/demo.png');
                    }
                    return '<div class="media align-items-center">
                            <a href="' . url('certify/show/' . encrypted_key($data->course_id, 'encrypt')) . '"
                            class="avatar  hover-translate-y-n3 course_img">
                            <img src="' . $url . '"
                            class="">
                            </a>
                            <div class="media-body ml-4 text-sm">
                            <a href="' . url('certify/show/' . encrypted_key($data->course_id, 'encrypt')) . '"
                            class="text-black" style="color: black;">
                            ' . substr($data->course_name, 0, 30) . '...
                            </a>
                            </div>
                            </div>';
                })
                ->addColumn('name', function ($data) {
                    return $data->username;
                })
				
                ->addColumn('completed_on', function ($data) {
                    if (!empty($data->completed_on)) {
                        return '<strong>100%</strong><br><span>Completed</span>';
                    } else {
                        return '<strong class="text-default"><i class="fa fa-checkbox-blank-circle"></i>
                        Ongoing</strong>';
                    }
                })->addColumn('enroll', function ($data) {
                    return '<strong>' . date('M d, Y', strtotime($data->created_at)) . '</strong><br><span>Enrolled On</span>';
                })->addColumn('ongoing', function ($data) {
                    if (!empty($data->completed_on != 'ongoing')) {
                        return '<strong>' . \App\Utility::getDateFormated($data->completed_on) . '</strong><br><span>Completed On</span>
						<br><strong>Cert Code: ' .$data->enroll_key.'</strong>';
                    } else {
                        return '<span> Not Completed</span>';
                    }
				
                
                })->addColumn('status', function ($data) {
                    if (!empty($data->completed_on != 'ongoing')) {
                        return '<strong class="text-primary">
                                    <i class="fa fa-checkbox-blank-circle"></i>
                                Completed</strong>';
                    } else {
                        return '<strong class="text-default">
                                    <i class="fa fa-checkbox-blank-circle"></i>
                                Ongoing</strong>';
                    }
                })
                ->rawColumns(['completed_on', 'ongoing', 'status', 'name', 'enroll', 'course','code'])
                ->make(true);
        } else {
            return view('certify.certifyChapters.mystudents', compact('authuser'));
        }


	}

	  public function ExamShow(Request $request, $id_encrypted)
    {
        $id = !empty($id_encrypted) ? encrypted_key($id_encrypted, 'decrypt') : 0;
	;
        if ($id == false) {
            return redirect()->route('certify.index')->with('error', __('Permission Denied.'));
        }
        $authuser = Auth::user();
            $Certify = Certify::find($id);
        $exams = DB::table('exams')->where('certify', '=', $id)->paginate(5);
        foreach ($exams as $key => $exam) {
            $courses_questions = DB::table('courses_questions')->where('examid', '=', $exam->id)->get();
            $studentCount = DB::table('examsreports')->where('exam', '=', $exam->id)->groupBy('user')->get();
            $exam->questions = count($courses_questions);
            $exam->students = count($studentCount);
        }
        $Chapters = DB::table('certify_chapters')->where('certify', '=', $id)->get();
        $students = StripePayment::where(['item_id' => $id, 'item_type' => 'certify'])->get();
        if ($request->ajax()) {
            $data = Exam::where(['certify' => $id]);
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('name', function ($data) {

                        return $data->name;

                })->addColumn('questions', function ($data) {
					 $questions = DB::table('courses_questions')->where('examid', '=', $exam->id)->get();
					 $examcourses_questions = count($questions);
					   return $examcourses_questions;

                })->addColumn('status', function ($data) {
                  return $data->status;
                })->addColumn('students', function ($data) {
				$studentCount = DB::table('examsreports')->where('exam', '=', $exam->id)->groupBy('user')->get();
					  $examstudentCount= count($studentCount);
                    return $examstudentCount;

                })->addColumn('action', function ($data) {
                    if (!empty($data->completed_on != 'ongoing')) {
                        return '<strong class="text-primary">
                                    <i class="fa fa-checkbox-blank-circle"></i>
                                Completed</strong>';
                    } else {
                        return '<strong class="text-default">
                                    <i class="fa fa-checkbox-blank-circle"></i>
                                Ongoing</strong>';
                    }
                })
                ->rawColumns(['completed_on', 'ongoing', 'status', 'name', 'enroll'])
                ->make(true);
        } else {
            return view('certify.certifyChapters.show', compact('authuser', 'Chapters', 'Certify', 'exams', 'students'));
        }

    }
    public function mystudents(Request $request)
    {

        $authuser = Auth::user();

        if ($request->ajax()) {
            $data = StripePayment::join('certifies as c', 'stripe_payments.item_id', '=', 'c.id')
                ->join('users','users.id','=','stripe_payments.user_id')
                ->select("stripe_payments.*", 'c.name as course_name', 'c.image as course_image', 'c.id as course_id','users.name as username')
                ->where(['c.user_id' => $authuser->id, 'item_type' => 'certify']);
            return Datatables::of($data)
                ->addIndexColumn()
                ->filterColumn('course', function ($query, $keyword) use ($request) {
                    $query->orWhere('c.name', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('users.name', 'LIKE', '%' . $keyword . '%');
                })->addColumn('course', function ($data) {
                    if (!empty($data->course_image)) {
                        if (file_exists(storage_path() . '/certify/' . $data->course_image)) {
                            $url = asset('storage/certify/' . $data->course_image);
                        } else {
                            $url = asset('public/demo.png');
                        }
                    } else {
                        $url = asset('public/demo.png');
                    }
                    return '<div class="media align-items-center">
                            <a href="' . url('certify/show/' . encrypted_key($data->course_id, 'encrypt')) . '"
                            class="avatar  hover-translate-y-n3 course_img">
                            <img src="' . $url . '"
                            class="">
                            </a>
                            <div class="media-body ml-4 text-sm">
                            <a href="' . url('certify/show/' . encrypted_key($data->course_id, 'encrypt')) . '"
                            class="text-black" style="color: black;">
                            ' . substr($data->course_name, 0, 30) . '...
                            </a>
                            </div>
                            </div>';
                })
                ->addColumn('name', function ($data) {
                    return $data->username;
                })
                ->addColumn('completed_on', function ($data) {
                    if (!empty($data->completed_on)) {
                        return '<strong>100%</strong><br><span>Completed</span>';
                    } else {
                        return '<strong class="text-default"><i class="fa fa-checkbox-blank-circle"></i>
                        Ongoing</strong>';
                    }
                })->addColumn('enroll', function ($data) {
                    return '<strong>' . date('M d, Y', strtotime($data->created_at)) . '</strong><br><span>Enrolled On</span>';
                })->addColumn('ongoing', function ($data) {
                    if (!empty($data->completed_on != 'ongoing')) {
                        return '<strong>' . \App\Utility::getDateFormated($data->completed_on) . '</strong><br><span>Completed On</span>';
                    } else {
                        return '<span> Not Completed</span>';
                    }
                })->addColumn('status', function ($data) {
                    if (!empty($data->completed_on != 'ongoing')) {
                        return '<strong class="text-primary">
                                    <i class="fa fa-checkbox-blank-circle"></i>
                                Completed</strong>';
                    } else {
                        return '<strong class="text-default">
                                    <i class="fa fa-checkbox-blank-circle"></i>
                                Ongoing</strong>';
                    }
                })
                ->rawColumns(['completed_on', 'ongoing', 'status', 'name', 'enroll', 'course'])
                ->make(true);
        } else {
            return view('certify.certifyChapters.mystudents', compact('authuser'));
        }

    }

//payments
    public function payments(Request $request)
    {
        $authuser = Auth::user();
        $StripePayment = StripePayment::where(['user_id' => $authuser->id, 'item_type' => 'certify'])->get();
        if ($request->ajax()) {
            $data = StripePayment::where(['user_id' => $authuser->id, 'item_type' => 'certify']);
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('item_name', function ($data) {
                    return $data->item_name;
                })->addColumn('total_price', function ($data) {
                    return '$' . $data->total_price;
				  })->addColumn('mode', function ($data) {
					  
					  if($data->payment_key =='Wallet'){
						  $mode='Via Wallet';
					  }
					  elseif($data->payment_key =='free'){
						    $mode='Redeemed Via Coupon';
						  
					  }
					  else
					  {
						   $mode=' Via Stripe';
					  }
                    return $mode;	
                })->addColumn('created_at', function ($data) {
                    return $data->created_at;
                })->addColumn('status', function ($data) {
                    return 'Paid';
                })
                ->rawColumns(['total_price', 'status'])
                ->make(true);
        } else {
            return view('certify.payments', compact('authuser', 'StripePayment'));
        }
    }

//exam functions

    public function examCreate($certify)
    {
        return view('certify.exams.examCreate', compact('certify'));
    }

    public function examQuestionCreate($examId)
    {
        return view('certify.exams.questionCreate', compact('examId'));
    }

    public function examQuestionStore(Request $request)
    {
        $user = Auth::user();

        $question = new Question;
        $question['examid'] = $request->examId;
        $question['question'] = $request->question;
        $question['type'] = $request->type;
        $question['required'] = $request->required;
        $answer = implode(",", $request->answer);
        $question['answers'] = $answer;
        if (!empty($request->correct) > 0) {
            $correct = implode(",", $request->correct);
            $question['correct'] = $correct;
        }


        $maxIndex = DB::select('select MAX(indexing) as indexing from courses_questions where examid = ' . $request->examId);
        // echo"<pre>";print_r($maxIndex);die();
        if ($maxIndex[0]->indexing > 0) {
            $indexing = $maxIndex[0]->indexing + 1;
        } else {
            $indexing = 1;
        }
        // echo"<pre>";print_r($indexing);die();
        $question['indexing'] = $indexing;


        $question->save();
        // echo "<pre>";print_r($question);die();
        if ($question) {
            return redirect()->back()->with('success', __('Certify Exam Question Created successfully.'));
        } else {
            return redirect()->back()->with('error', __('Oops Error.'));
        }
    }

    public function examQuestionUpdate(Request $request)
    {
        $user = Auth::user();
        $post = $request->all();

        $examid = $post['exam'];
        $courses_questions = array();
        $answers = array();
        $correct = array();
        // echo "<pre>";print_r($post);die();
        foreach ($post['questionid'] as $key => $value) {
            $answers[$value] = implode(",", $post['answer'][$value]);
        }

        foreach ($post['questionid'] as $key => $value) {
            $correct[$value] = implode(",", $post['correct'][$value]);
        }
        if (isset($post['questionid'])) {
            for ($i = 0; $i < count($post['questionid']); $i++) {

                $courses_questions[$i] = array('id' => $post['questionid'][$i], 'indexing' => $i + 1, 'question' => $post['question'][$i], 'type' => $post['type'][$i], 'required' => $post['required'][$i]);
            }
        }

        foreach ($courses_questions as $key => $question) {
            $Question = Question::find($question['id']);

            $Question->update($question);
        }
        foreach ($answers as $key => $answer) {
            $Question = Question::find($key);

            $Question['answers'] = $answer;
            $Question->update();
        }
        foreach ($correct as $key => $correctVal) {
            $Question = Question::find($key);
            $Question['correct'] = $correctVal;
            $Question->update();
        }
        if ($Question) {
            return redirect()->back()->with('success', __('Certify Exam Questions Updated successfully.'));
        } else {
            return redirect()->back()->with('error', __('Oops Eorror Detected.'));
        }
        // echo "<pre>";print_r($request->all());die();
    }

    public function examStore(Request $request)
    {
        $user = Auth::user();
        $exam = new Exam();
        $exam['user_id'] = $user->id;
        $exam['certify'] = $request->certify_id;
        $exam['name'] = $request->title;
        $exam['description'] = $request->description;
        $exam['retakes'] = $request->retakes;
        $exam->save();
        $exam->id;
        if ($exam) {
            return redirect()->back()->with('success', __('Certify Exam Created successfully.'));
        } else {
            return redirect()->back()->with('error', __('Default plan is deleted.'));
        }
        // echo "<pre>";print_r($request->all());die();
    }

    public function examUpdate(Request $request)
    {
        $user = Auth::user();
        $post = $request->all();
        $exam = Exam::find($request->examid);
        $exam->update($post);
        if ($exam) {
            return redirect()->back()->with('success', __('Certify Exam Updated successfully.'));
        } else {
            return redirect()->back()->with('error', __('Default plan is deleted.'));
        }
        // echo "<pre>";print_r($request->all());die();
    }

    public function examQuestionDistroy(Request $request)
    {

        $Question = Question::find($request->questionDeleteId);
        $Question->delete();

        if ($Question) {
            return redirect()->back()->with('success', __('Certify Exam Question Delete successfully.'));
        } else {
            return redirect()->back()->with('error', __('Default plan is deleted.'));
        }

        // echo "<pre>";print_r($request->all());die();
    }

    public function ExamDestroy(Request $request)
    {

        $exam = Exam::find($request->examId);
        $exam->delete();

        if (isset($request->certifyid)) {
            if ($exam) {
                return redirect()->back()->with('success', __('Certify Exam Delete successfully.'));
            } else {
                return redirect()->back()->with('error', __('Default plan is deleted.'));
            }
        } else {
            if ($exam) {
                return redirect()->route('certify.index')->with('success', __('Certify Exam Delete successfully.'));
            } else {
                return redirect()->back()->with('error', __('Default plan is deleted.'));
            }
        }

        // echo "<pre>";print_r($request->all());die();
    }

    public function examBuilder($id_encrypted)
    {
        $examid = !empty($id_encrypted) ? encrypted_key($id_encrypted, 'decrypt') : 0;
        if ($examid == false) {
            return redirect()->route('certify.index')->with('error', __('Permission Denied.'));
        }
        $exam = Exam::find($examid);
        $questions = DB::table('courses_questions')->where('examid', '=', $examid)->orderBy('indexing', 'ASC')->get();
        foreach ($questions as $key => $question) {
            $question->answers = explode(",", $question->answers);
            $question->correct = explode(",", $question->correct);
        }
        // echo "<pre>";print_r($courses_questions);die();
        return view('certify.exams.examBuilder', compact('exam', 'questions'));
    }

    public function CertifyExamStudents(Request $request, $id_encrypted)
    {
        $examId = !empty($id_encrypted) ? encrypted_key($id_encrypted, 'decrypt') : 0;
        if ($examId == false) {
            return redirect()->route('certify.index')->with('error', __('Permission Denied.'));
        }
        $user = Auth::user();
        $exam = Exam::find($examId);
        $students = Examsreport::where(['exam' => $examId])->groupBy('user', 'certify', 'exam')->get();
        if ($request->ajax()) {
            $examId = !empty($id_encrypted) ? encrypted_key($id_encrypted, 'decrypt') : 0;
            if ($examId == false) {
                return redirect()->route('certify.index')->with('error', __('Permission Denied.'));
            }
            $user = Auth::user();
            $exam = Exam::find($examId);
            $data = Examsreport::join('exams', 'exams.id', 'examsreports.exam')
                ->where(['examsreports.exam' => $examId])
                ->where(['exams.id' => $examId])
                ->select('examsreports.*', 'exams.name as examname')
                ->groupBy('examsreports.user', 'examsreports.certify', 'examsreports.exam');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('name', function ($data) {
                    if (getUserDetails($data->user)) {
                        return getUserDetails($data->user)->name;
                    } else {
                        return 'Guest User';
                    }
                })->addColumn('examname', function ($data) {
                    return $data->examname;
                })->addColumn('correct', function ($data) {
                    return '<strong>' . getStudentScore($data->user, $data->certify, $data->exam)->correctlyAnswered . '</strong><br><span>Questions</span>';
                })->addColumn('total', function ($data) {
                    return '<strong>' . getStudentScore($data->user, $data->certify, $data->exam)->totalQuestions . '</strong><br><span>Questions</span>';
                })->addColumn('score', function ($data) {
                    return '<strong>' . getStudentScore($data->user, $data->certify, $data->exam)->score . '
                                %</strong>
                            <div class="progress">
                                <div class="progress-bar progress-bar-success progress-bar-striped"
                                     role="progressbar"
                                     aria-valuenow="' . getStudentScore($data->user, $data->certify, $data->exam)->score . '"
                                     aria-valuemin="0" aria-valuemax="100"
                                     style="width:' . getStudentScore($data->user, $data->certify, $data->exam)->score . '%">
                                </div>
                            </div>';
                })
                ->rawColumns(['name', 'examname', 'correct', 'total', 'score'])
                ->make(true);
        } else {
            return view('certify.exams.students', compact('exam', 'students'));
        }
    }

    public function CertifyExamPerview($id_encrypted)
    {
        $examId = !empty($id_encrypted) ? encrypted_key($id_encrypted, 'decrypt') : 0;
        if ($examId == false) {
            return redirect()->route('certify.index')->with('error', __('Permission Denied.'));
        }
        $user = Auth::user();
        $lastTake = '';
        $exam = Exam::find($examId);
        $certify = Certify::find($exam->certify);
        $questions = DB::table('courses_questions')->where('examid', '=', $exam->id)->get();
        $examsreports = DB::table('examsreports')->where('exam', '=', $exam->id)->where('student', '=', $user->id)->get();
        $takes = count($examsreports);
        if ($takes > 0) {
            $lastTake = DB::table('examsreports')->where('exam', '=', $exam->id)->where('student', '=', $user->id)->orderBy('created_at', 'DESC')->first();
        }

        foreach ($questions as $key => $question) {
            $question->answers = explode(",", $question->answers);
            $question->correct = explode(",", $question->correct);
        }

        return view('certify.exams.examPerview', compact('exam', 'questions', 'takes', 'lastTake', 'user'));
    }

    public function CertifyExamPerviewSave(Request $request)
    {
        $user = Auth::user();
        // echo "<pre>";print_r($request->all());die();
        $exam = Exam::find($request->examid);
        $post = $request->all();
        $questionCount = $request->questionCount;
        $postquestions = array();
        $postanswers = array();
        $answers = array();
        $correct = array();
        $isCorrect = array();
        $postquestions = $request->question;
        $postanswers = $request->answer;
        $questions = DB::table('courses_questions')->where('examid', '=', $request->examid)->get();
        foreach ($questions as $key => $question) {
            $answers[$question->id] = explode(",", $question->answers);
            $correct[$question->id] = explode(",", $question->correct);
        }
        for ($i = 0; $i < count($postquestions); $i++) {
            $questionId = $postquestions[$i];
            $countOfCorrect[$questionId] = count($correct[$questionId]);
            $countOfAnswer[$questionId] = count($postanswers[$questionId]);
            for ($j = 0; $j < count($postanswers[$questionId]); $j++) {

                if ($countOfAnswer[$questionId] < $countOfCorrect[$questionId] || $countOfAnswer[$questionId] > $countOfCorrect[$questionId]) {
                    $isCorrect[$questionId][$j] = 'no';
                } elseif ($countOfAnswer[$questionId] == $countOfCorrect[$questionId]) {
                    if (in_array($postanswers[$questionId][$j], $correct[$questionId])) {
                        $isCorrect[$questionId][$j] = 'yes';
                    } else {
                        $isCorrect[$questionId][$j] = 'no';
                    }
                }
            }
        }

        $score = 0;
        for ($i = 0; $i < count($postquestions); $i++) {
            $questionId = $postquestions[$i];
            if (in_array('no', $isCorrect[$questionId])) {
                $score = $score + 0;
            } else {
                $score = $score + 1;
            }
        }
        $percentagePerQuestion = 100 / $questionCount;
        $percentage = $score * $percentagePerQuestion;
        $perInt = intval($percentage);
        if ($user->type != "owner" && $user->type != "admin") {
            $Examsreport = new Examsreport();
            $Examsreport['user'] = $user->id;
            $Examsreport['certify'] = $exam->certify;
            $Examsreport['exam'] = $request->examid;
            $Examsreport['student'] = $user->id;
            $Examsreport['score'] = $perInt;
            $Examsreport['correctlyAnswered'] = $score;
            $Examsreport['totalQuestions'] = $questionCount;
            $Examsreport->save();
        }
        return redirect()->back()->with('success', __('You Set this exam and scored ' . $perInt . '%'));
    }

    public function CertifyExamStatus(Request $request)
    {
        $examId = $request->examId;
        $status = '';
        if ($request->status == 'Unpublished') {
            $status = 'Published';
        } else {
            $status = 'Unpublished';
        }
        $exam = Exam::find($examId);
        $exam['status'] = $status;
        $exam->update();
        if ($exam) {
            return redirect()->back()->with('success', __('Exam Status has Been Changed'));
        } else {
            return redirect()->back()->with('error', __('Ooops Error Detected'));
        }
    }

    public function certifyCurriculum($id_encrypted)
    {
        $id = !empty($id_encrypted) ? encrypted_key($id_encrypted, 'decrypt') : 0;
        if ($id == false) {
            return redirect()->route('certify.index')->with('error', __('Permission Denied.'));
        }
        $Certify = Certify::find($id);
        $chapters = DB::table('certify_chapters')->where('certify', '=', $id)->orderBy('indexing', 'ASC')->get();
        foreach ($chapters as $chapter) {
            $chapter->lectures = DB::table('lectures')->where('chapter', '=', $chapter->id)->orderBy('indexing', 'ASC')->get();
        }
        $certifyChapter = new CertifyChapter();
        return view('certify.certifyCurriculum.certifyCurriculum', compact('chapters', 'Certify', 'certifyChapter'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function curriculumDestroy(Request $request)
    {
        if ($request) {
            $type = $request->destroytype;
            $curriculumId = $request->curriculumId;
            if ($type == 'chapter') {
                $CertifyChapter = CertifyChapter::find($curriculumId);
                $CertifyChapter->delete();
            } elseif ($type == 'lecture') {
                $Lecture = Lecture::find($curriculumId);
                $Lecture->delete();
            }

            return redirect()->back()->with('success', __('Curriculum deleted successfully.'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function Instructor(Request $request)
    {
        $authuser = Auth::user();
        $domain_id= get_domain_id();
        if ($request->ajax()) {
            $data = Instructor::select("u.*","instructors.id as instructor_id")->join("users as u","u.id","=","instructors.user_id")->where('instructors.domain_id', '=', $domain_id)->orderByDesc('instructors.id');
            return Datatables::of($data)
                ->addIndexColumn()
                ->filterColumn('name', function ($query, $keyword) use ($request) {
                    $sql = "u.name like ?";
                    $query->whereRaw($sql, ["%{$keyword}%"]);
                })->addColumn('name', function ($data) {
                    if (!empty($data->avatar)) {
                        if (file_exists(storage_path() . '/user/' . $data->avatar)) {
                            $url = asset('storage/user/' . $data->avatar);
                        } else {
                            $url = asset('public/assets_admin/img/user/user.jpg');
                        }
                    } else {
                        $url = asset('public/assets_admin/img/user/user.jpg');
                    }
                    return '<div class="media align-items-center">
                                <img src="' . $url . '" class="avatar">
                                <div class="media-body ml-4 text-sm">
                                    ' . $data->name . '
                                </div>
                            </div>';
                })->addColumn('city', function ($data) {
                    return $data->city;
                })->addColumn('state', function ($data) {
                    return $data->state;
                })->addColumn('action', function ($data) {
//               <a class="btn btn-sm bg-success-light" data-title="Edit" href="'.route('instructor.edit', encrypted_key($data->id, 'encrypt')).'">
//                                                    <i class="fas fa-pencil-alt"></i>
//                                                    Edit
//                                                </a>

                      $actionBtn = '<div class="actions text-right">

                                                <a data-url="' . route('instructor.destroy',encrypted_key($data->instructor_id,'encrypt')) . '" href="#" class="btn btn-sm bg-danger-light delete_record_model">
                                                    <i class="far fa-trash-alt"></i> Delete
                                                </a>
                                            </div>';
                    return $actionBtn;
                })
                ->rawColumns(['action', 'name'])
                ->make(true);
        }
        return view('certify.instructor.index');
    }

    public function FeatchDataInstructor($view = 'list')
    {

        $authuser = Auth::user();
        $Certifies = Instructor::where('user_id', '=', $authuser->id)->orderByDesc('id')->get();

        if (isset($_GET['view'])) {
            $view = 'list';
            $returnHTML = view('certify.instructor.list', compact('view', 'Certifies'))->render();
        } else {
            $returnHTML = view('certify.instructor.grid', compact('view', 'Certifies'))->render();
        }

        return response()->json(
            [
                'success' => true,
                'html' => $returnHTML,
            ]
        );
    }

    public function InstructorCreate()
    {
        $authuser = Auth::user();
        return view('certify.instructor.create');
    }

    public function InstructorStore(Request $request)
    {
        $user = Auth::user();
        $validation = [
            'instructor' => 'required',
        ];


        $validator = Validator::make(
            $request->all(), $validation
        );

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        }
$domain_id= get_domain_id();
$exist= instructor::where('user_id',$request->instructor)->first();
if(empty($exist)){
        $instructor = new instructor();
        $instructor['user_id'] = $request->instructor;
        $instructor['created_by'] = $user->id;
        $instructor['domain_id'] = $domain_id;


        $instructor->save();

        return redirect()->route('instructor.index')->with('success', __('Instructor added successfully.'));
}else{
   return redirect()->route('instructor.index')->with('error', __('Instructor already exist'));
}
    }

    public function InstructorEdit($id_encrypted)
    {
        $id = !empty($id_encrypted) ? encrypted_key($id_encrypted, 'decrypt') : 0;
        if ($id == false) {
            return redirect()->route('instructor.index')->with('error', __('Permission Denied.'));
        }
        $user = Auth::user();
        $Instructor = Instructor::find($id);

        return view('certify.instructor.edit', compact('Instructor'));
    }

    public function InstructorUpdate(Request $request)
    {
        $domain_id= get_domain_id();

        $post = $request->all();
        $instructor = Instructor::find($request->id);
        $image = '';

        if (!empty($request->image)) {
            $base64_encode = $request->image;
            $folderPath = "storage/instructor/";
            $image_parts = explode(";base64,", $base64_encode);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $image = "Instructor" . uniqid() . '.' . $image_type;;
            $file = $folderPath . $image;
            file_put_contents($file, $image_base64);
        } else {
            $image = $instructor->image;
        }

        $post['image'] = $image;
        $post['domain_id'] = $domain_id;
        $instructor->update($post);
        return redirect()->route('instructor.index')->with('success', __('Instructor Updated successfully.'));
    }

    public function InstructorDestroy($id=0)
    {
        $id = encrypted_key($id, 'decrypt') ?? $id;
         if (empty($id)) {
            return redirect()->back()->with('success', __('Id is mismatch.'));
        }

            $Instructor = Instructor::find($id);
            $Instructor->delete();
            return redirect()->route('instructor.index')->with('success', __('Instructor deleted successfully.'));

    }

    public function verifycertview()
    {
        return view('certify.verifycert');
    }

    public function verifycert(Request $request)
    {

        $enrollment = DB::table('stripe_payments')->where('enroll_key', $request->cert_code)->first();
        if (!empty($enrollment)) {
            $student = DB::table('users')->where('id', $enrollment->user_id)->first();
            $course = DB::table('certifies')->where('id', $enrollment->item_id)->first();
            if (Auth::user()->type == 'corporate') {
              alert()->success($student->name . " successfully completed " . $course->name . " course on " . date("F j, Y", strtotime($enrollment->completed_on)) . " and this is a valid certificate code.",'Success!')->autoclose(100000);
					return redirect()->route('certify.index');
            }
            
			
			alert()->success($student->name . " successfully completed " . $course->name . " course on " . date("F j, Y", strtotime($enrollment->completed_on)) . " and this is a valid certificate code.",'Success!')->autoclose(100000);
					return redirect()->route('certify.index'); 
        } else {
            if (Auth::user()->type == 'corporate') {
                    alert()->error('Unfortunately, we could not find a certificate with this code.','Error!')->autoclose(100000);
					return redirect()->route('certify.index');
            }
			    alert()->error('Unfortunately, we could not find a certificate with this code.','Error!')->autoclose(100000);
				return redirect()->route('certify.index');
        }
    }

    public function certificateivrcall()
    {

        header("content-type: text/xml");
        echo '<?xml version="1.0" encoding="UTF-8"?>';
        echo '<Response>';
        echo '<Gather action=.env("APP_URL") ."/verify/cert/ivr" numDigits="6">';
        if (env('CERTIFICATE_MESSAGE_TYPE') == "tts") {
            echo '<Say>' . env("CERTIFICATE_TTS") . '</Say>';
        } else {
            echo '<Play>' . env("APP_URL") . '/storage/' . env("CERTIFICATE_MP3") . '</Play>';
        }
        echo '</Gather>';
        echo '</Response>';
    }

    public function verifycertivr()
    {

        $enrollment = DB::table('stripe_payments')->where('enroll_key', $_POST["Digits"])->first();
        if (!empty($enrollment)) {
            $student = DB::table('users')->where('id', $enrollment->user_id)->first();
            $course = DB::table('certifies')->where('id', $enrollment->item_id)->first();

            $message = "This is a valid certificate! " . $student->name . "  successfully completed " . $course->name . " course on " . date("F j, Y", strtotime($enrollment->completed_on)) . " and this is a valid certificate code.";
        } else {
            $message = "This is an invalid code! Unfortunately, we could not find a certificate with this code.";
        }

        header("content-type: text/xml");
        echo '<?xml version="1.0" encoding="UTF-8"?>';
        echo '<Response>';
        echo '<Say>' . $message . '</Say>';
        echo '</Response>';
    }

    public function studentLearnStatus()
    {
        $user = Auth::user();
        if (isset($_GET['lectureId'])) {
            $lectureId = $_GET['lectureId'];
        }
        $lecture = Lecture::find($lectureId);
        $CertifyChapter = CertifyChapter::find($lecture->chapter);
        $checkIfExist = StudentLectureStatus::where(['student' => $user->id, 'lecture_id' => $lectureId, 'chapter_id' => $CertifyChapter->id])->first();
        if ($checkIfExist) {
            return $checkIfExist;
        } else {
            $StudentLectureStatus = StudentLectureStatus::create([
                'student' => $user->id,
                'chapter_id' => $CertifyChapter->id,
                'lecture_id' => $lectureId,
                'study_status' => 'Completed',
                'status' => 'Completed'
            ]);
            return $StudentLectureStatus;
        }
    }

//wallet
    public function wallet(Request $request)
    {
        $user = Auth::user();
        if ($request->ajax()) {
            $data = StripePayment::where(['item_type' => 'wallet', 'user_id' => $user->id])->orderByDesc('id');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('amount', function ($data) {
                    return '$' . $data->price;
                })->addColumn('date', function ($data) {
                    return \App\Utility::getDateFormated($data->created_at);
                })->addColumn('status', function ($data) {
                    return 'Success';
                })->addColumn('action', function ($data) {
                    $authuser = Auth::user();
                    $actionBtn = '<div class="actions text-center">
                                    <a class="dropdown-item destroyCertify text-danger" href="javascript:void(0)"
                                       data-id="'.$data->id.'" data-val="created_at-asc">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>';
                    return $actionBtn;
                })
                ->rawColumns(['action', 'date', 'price', 'status'])
                ->make(true);
        } else {
            $user = Auth::user();
            // if ($user->type == 'corporate') {
                $transactions = StripePayment::where(['item_type' => 'wallet', 'user_id' => $user->id])->orderByDesc('id')->get();
                $CompanyWallet = CompanyWallet::where('company_id', '=', $user->id)->first();
                return view('users.wallet', compact('user', 'CompanyWallet', 'transactions'));
            // } else {
                // return redirect()->back()->with('error', __('Permission Denied.'));
            // }
        }
    }

    public function withdraw(Request $request)
    {
        $user = Auth::user();
        if($request->ajax()){
            $CompanyWallet = CompanyWallet::where('company_id', '=', $user->id)->first();
            if($CompanyWallet->balance < $request->amount){
                return response()->json(array('response' => 'false', 'message' => 'Insufficient Balance!'));
            }
            $req = new WithdrawRequest;

                $req->user_id = $user->id;
                $req->amount = $request->amount;
                $req->status = 'Pending';
                $req->type = $request->withdraw_via;
                $req->save();
            $balance = $CompanyWallet->balance - $request->amount;
            if($req){
                CompanyWallet::where('company_id', '=', $user->id)->update(['balance'=>$balance]);
            }
            return response()->json(array('response' => 'success', 'message' => 'Request Submitted!'));
        }
    }
	public function withdraw_requests(Request $request){
        $user = Auth::user();

        if ($request->ajax()) {
            if($user->type=='owner'){
            $data = DB::table('withdraw_requests')->where('user_id',$user->id)->orderByDesc('id');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('user', function ($data) {
                    return Auth::user()->name;
                })->addColumn('amount', function ($data) {
                    return '$' . $data->amount;
                })->addColumn('date', function ($data) {
                    return \App\Utility::getDateFormated($data->created_at);
                })->addColumn('type', function ($data) {
                    return $data->type;
                })->addColumn('status', function ($data) {
                    return $data->status;
                })->addColumn('action', function ($data) {
                    $authuser = Auth::user();

                                $actionBtn ='<div class="dropdown">
                                 <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Action
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" id="cancel_req" href="javascript:void(0);" data-id="'.$data->id.'" data-user="'.$data->user_id.'">Cancel Request</a>';

                                $actionBtn .='</div>
                                    </div>';
                    return $actionBtn;
                })
                ->rawColumns(['user','action', 'date', 'price', 'status','type'])
                ->make(true);
            }elseif($user->type=='admin'){
                $data = DB::table('withdraw_requests')->orderByDesc('id');
                return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('user', function ($data) {
                    return User::userInfo($data->user_id)->name;
                })->addColumn('amount', function ($data) {
                    return '$' . $data->amount;
                })->addColumn('date', function ($data) {
                    return \App\Utility::getDateFormated($data->created_at);
                })->addColumn('type', function ($data) {
                    return $data->type;
                })->addColumn('status', function ($data) {
                    return $data->status;
                })->addColumn('action', function ($data) {
                    $authuser = Auth::user();

                                $actionBtn ='<div class="dropdown">
                                 <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Action
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" id="pay" href="javascript:void(0);" data-id="'.$data->id.'">Pay</a>
                                    <a class="dropdown-item" id="cancel_req" href="javascript:void(0);" data-id="'.$data->id.'" data-user="'.$data->user_id.'">Cancel Request</a>';
                                $actionBtn .='</div>
                                    </div>';
                    return $actionBtn;
                })
                ->rawColumns(['user','action', 'date', 'price', 'status','type'])
                ->make(true);
            }

        }else{
            return view('users.withdraw_requests');
        }
    }
public function withdraw_requests_cancel(Request $request){
    $user_id = $request->user_id;
    $req = WithdrawRequest::where('id',$request->req_id)->first();
    if($req->status == 'Pending'){
        $cancel = WithdrawRequest::where('id',$request->req_id)->update(['status'=>'Cancelled','cancel_reason'=>'Cancelled by user.','fulfill_date'=>date("Y-m-d H:i:s")]);
        if($cancel){
            $wallet = CompanyWallet::where('company_id', '=', $user_id)->first();
            $balance = $req->amount + $wallet->balance;
            CompanyWallet::where('company_id', '=', $user_id)->update(['balance'=>$balance]);
            return redirect()->back()->with('success', __("Request successfully cancelled."));
        }
    }else{
        return redirect()->back()->with('error', __("This Request no longger availabe!"));
    }
}
	public function walletdebit(Request $request)
    {
        $user = Auth::user();
        if ($request->ajax()) {
            $data = WalletExpenses::where([ 'user_id' => $user->id])->orderByDesc('id');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('title', function ($data) {
                    return $data->title;
                })->addColumn('type', function ($data) {
                    return $data->type;
				}) ->addColumn('amount', function ($data) {
                    return '$' . $data->amount;
                })->addColumn('status', function ($data) {
                    return 'Paid';
                })->addColumn('action', function ($data) {
                    $authuser = Auth::user();
                    $actionBtn = '<div class="actions text-center">
                                    <a class="dropdown-item destroyCertify text-danger" href="javascript:void(0)"
                                       data-id="'.$data->id.'" data-val="created_at-asc">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>';
                    return $actionBtn;
                })
                ->rawColumns(['action', 'date', 'price', 'status'])
                ->make(true);
        } else {
            $user = Auth::user();

                return view('users.walletdebit', compact('user'));

        }
    }


	  public function walletdebitDelete(Request $request)
    {
        $user = Auth::user();
        $tutionrequest = WalletExpenses::where('id', '=', $request->id)->delete();
        if ($tutionrequest) {
            return redirect()->back()->with('success', __("Debit history successfully deleted."));
        }
    }

    public function addminwallet(Request $request)
    {
        $user = Auth::user();
        if ($user->type == 'admin') {
            if ($request->ajax()) {
                $data = CompanyWallet::select('id','balance','status')->orderByDesc('id');
                return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('name', function ($data) {
                        if (getUserDetails($data->user)) {
                            return getUserDetails($data->user)->name;
                        } else {
                            return 'Guest User';
                        }
                    })->addColumn('balance', function ($data) {
                        return '$' . round($data->balance);
                    })->addColumn('status', function ($data) {
                        return 'Success';
                    })
                    ->rawColumns(['status'])
                    ->make(true);
            } else {
                return view('users.ledger ', compact('user'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function tutionrequest(Request $request)
    {

        $user = Auth::user();
        if ($request->ajax()) {
			
			
					
            $data = AssistanceRequest::select('assistance_requests.*','users.type as role','users.name as user_name','users.id as user_id','certifies.price as certprice', 'certifies.sale_price as certSaleprice','certifies.id as certId','certifies.name')
			->Join('certifies', 'certifies.id', '=', 'assistance_requests.certify')
            ->leftJoin('users', 'users.id', '=', 'assistance_requests.user')
            ->where('assistance_requests.assistance', '=', $user->id);
           
            return Datatables::of($data)
               ->addIndexColumn()
                       ->orderColumn('certify', function ($query, $order) {
                     $query->orderBy('certifies.id', $order);
                 })
                ->filterColumn('certify', function ($query, $keyword) use ($request) {
                    $sql = "certifies.name like ?";
                    $query->whereRaw($sql, ["%{$keyword}%"]);
					
                 })
                 ->orderColumn('price', function ($query, $order) {
				
					$query->orderBy('certSaleprice', $order);
					
				
                    
                 })
                ->addColumn('user_name', function ($data) {
                    if ($data->user_name) {
                        return '<div class="media align-items-center">
                                    <input type="hidden" class="user_name"
                                           value="' . $data->user_name . '">
                                    <input type="hidden" class="user_id"
                                           value="' . $data->user_id . '"/>
                                    <div class="media-body" style="color:black;" data-role="'.$data->role.'" data-city="'.$data->contact_page_city.'" data-state="'.$data->state_name.'">
                                       ' . $data->user_name . '
                                    </div>
                                </div>';
                    } else {
                        return 'Deleted User';
                    }
                })->addColumn('certify', function ($data) {
                    return $data->name;
                })->addColumn('type', function ($data) {
                    return $data->type;
				
					 })->addColumn('price', function ($data) {
						 
						 if($data->certSaleprice > 0){
							 $CertPrice=$data->certSaleprice;
						 }
						 else{
							 $CertPrice=$data->price;
						 }
                     return format_price($CertPrice);
                })->addColumn('status', function ($data) {
                    return '<span class="badge badge-dot mr-4">
                                <i class="' . (($data->status == 'Approve') ? 'bg-success' : 'bg-danger') . '"></i>
                                <span class="status">' . $data->status . '</span>
                            </span>';
                })->addColumn('action', function ($data) {
                    $authuser = Auth::user();
                    $actionBtn = '<div class="dropdown">
                                        <button class="btn btn-sm btn-white btn-icon-only rounded-circle"
                                                type="button" id="dropdownMenu2" data-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false">
                                            <span class="btn-inner--icon"><i class="fas fa-filter"></i></span>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                            <button class="dropdown-item" type="button">
                                                <a class="dropdown-item"
                                                   href="' . url('certify/show/' . encrypted_key($data->certify, 'encrypt')) . '"
                                                   data-val="created_at-asc">
                                                    <i class="fas fa-eye"></i>Preview Course
                                                </a>
                                            </button>';
                    if ($data->status == 'Pending') {
                        $actionBtn .= '<button class="dropdown-item" type = "button" >
                                                    <a class="dropdown-item"
                                                       href = "' . route('wallet.tutionrequest.status.change', ['id' => $data->id, 'status' => 'Decline']) . '"
                                                       data-val = "created_at-asc" >
                                                        Decline
                                                    </a >
                                                </button >';
             
                        $actionBtn .= '<button class="dropdown-item" type = "button" >
                                                    <a class="dropdown-item approveReq"
                                                       href = "javascript:void(0)"
                                                       data-certify = "' . $data->certify . '"
                                                       data-id = "' . $data->id . '"
                                                       data-val = "created_at-asc" >
                                                         Approve
                                                    </a >
                                                </button >';
                    } else {
						  if ($data->status == 'Pending') {
                        $actionBtn .= '<button class="dropdown-item" type = "button" >
                                                    <a class="dropdown-item approveReq"
                                                       href = "javascript:void(0)"
                                                       data-certify = "' . $data->certify . '"
                                                       data-id = "' . $data->id . '"
                                                       data-val = "created_at-asc" >
                                                        Approve
                                                    </a >
                                                </button >
                                                <button class="dropdown-item" type = "button" >
                                                    <a class="dropdown-item"
                                                       href = "' . route('wallet.tutionrequest.status.change', ['id' => $data->id, 'status' => 'Decline']) . '"
                                                       data-val = "created_at-asc" >
                                                       Decline
                                                    </a >
                                                </button >';
						  }
                    }
                    $actionBtn .= '<button class="dropdown-item" type="button">
                                                <a class="dropdown-item requestInfo" href="javascript:void(0)"
                                                   data-id="' . $data->id . '" data-val="created_at-asc">
                                                    Request Info
                                                </a>
                                            </button>
                                            <button class="dropdown-item" type="button">
                                                <a class="dropdown-item destroyCertify"
                                                   href="javascript:void(0)" data-id="' . $data->id . '"
                                                   data-val="created_at-asc">
                                                 Delete
                                                </a>
                                            </button>
                                        </div>
                                    </div>';
                    return $actionBtn;
                })
                ->rawColumns(['action', 'user_name', 'certify', 'status', 'type','price'])
                ->make(true);
        } else {

            if ($user->type == 'corporate') {

                $tutionrequest = AssistanceRequest::select('assistance_requests.*')

                ->where('assistance_requests.assistance', '=', $user->id)
                ->orderByDesc('assistance_requests.id')
                ->get();

             //   $bls_states = BlsState::select('state_code', 'state_name')->get();

                return view('certify.tutionrequest', compact('user', 'tutionrequest'));
            } else {
                return redirect()->back()->with('error', __('Permission Deniddded.'));
            }
        }

    }

		   public function clienttutionrequest(Request $request)
    {

        $user = Auth::user();
        if ($request->ajax()) {
            $data = AssistanceRequest::select('assistance_requests.*','users.type as role','users.name as user_name','users.id as user_id')

            ->leftJoin('users', 'users.id', '=', 'assistance_requests.assistance')
            ->where('assistance_requests.user', '=', $user->id)
            ->orderByDesc('assistance_requests.id');
			
			
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('user_name', function ($data) {
                    if ($data->user_name) {
                        return '<div class="media align-items-center">
                                    <input type="hidden" class="user_name"
                                           value="' . $data->user_name . '">
                                    <input type="hidden" class="user_id"
                                           value="' . $data->user_id . '"/>
                                    <div class="media-body" style="color:black;" data-role="'.$data->role.'" data-city="'.$data->contact_page_city.'" data-state="'.$data->state_name.'">
                                       ' . $data->user_name . '
                                    </div>
                                </div>';
                    } else {
                        return 'Deleted User';
                    }
                })->addColumn('certify', function ($data) {
                    return getCertityName($data->certify);
                })->addColumn('type', function ($data) {
                    return $data->type;
				})->addColumn('price', function ($data) {
					 return getCertityPrice($data->certify);
                })->addColumn('status', function ($data) {
                    return '<span class="badge badge-dot mr-4">
                                <i class="' . (($data->status == 'Approve') ? 'bg-success' : 'bg-danger') . '"></i>
                                <span class="status">' . $data->status . '</span>
                            </span>';
                })
                ->rawColumns(['action', 'user_name', 'certify', 'status', 'type'])
                ->make(true);
        } else {

            if ($user->type == 'mentee') {

                $tutionrequest = AssistanceRequest::select('assistance_requests.*')

                ->where('assistance_requests.assistance', '=', $user->id)
                ->orderByDesc('assistance_requests.id')
                ->get();

             //   $bls_states = BlsState::select('state_code', 'state_name')->get();

                return view('certify.menteerequest', compact('user', 'tutionrequest'));
            } else {
                return redirect()->back()->with('error', __('Permission Deniddded.'));
            }
        }

    }
	
    public function tutionrequestStatusChange($id, $status)
    {
        $user = Auth::user();
        $tutionrequest = AssistanceRequest::where('id', '=', $id)->update(['status' => $status]);
        $data = AssistanceRequest::where('id', '=', $id)->first();
        $userdata = User::where('id', '=', $data->user)->first();
        if ($tutionrequest) {
            $ojb = array(
                'Content' => "",
            );
            $template_name = "Corporate Request declined";
            $mailTo = $userdata->email;
            $resp = \App\Utility::send_emails( $mailTo, $userdata->name, null, $ojb,'corporate_request_declined',$userdata);
            return redirect()->back()->with('success', __("Application Declined successfully ."));
        }
    }

    public function tutionrequestDelete(Request $request)
    {
        $user = Auth::user();
        $tutionrequest = AssistanceRequest::where('id', '=', $request->id)->delete();
        if ($tutionrequest) {
            return redirect()->back()->with('success', __("Application delete successfully ."));
        }
    }

    public function transactionDelete(Request $request)
    {
        $user = Auth::user();
        $tutionrequest = StripePayment::where('id', '=', $request->id)->delete();
        if ($tutionrequest) {
            return redirect()->back()->with('success', __("Transaction successfully  deleted."));
        }
    }

    public function getCertfyPrice(Request $request)
    {
        $user = Auth::user();
        $price = Certify::find($request->id);
        if ($price) {
            if ($price->sale_price > 0) {
                return $price->sale_price;
            } else {
                return $price->price;
            }
        } else {
            return '0';
        }
    }

    public function checkWalletPrice(Request $request)
    {
        $user = Auth::user();
        //$CompanyWallet = CompanyWallet::where('company_id', '=', $user->id)->first();format_price($user->wallet_balance, 2)
        $CompanyWallet =$user->wallet_balance;
		if(!empty($CompanyWallet)){

        if ($CompanyWallet > 0) {
			$price = preg_replace('/[^0-9-.]+/',  '',$request->price);
            if ($CompanyWallet >= $price) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
		}
		else{
			return false;
		}
    }

    public function tutionrequestStatusChangeApprove(Request $request)
    {


        $user = Auth::user();
        $CompanyWallet =$user->wallet_balance;
        $tutionrequest = AssistanceRequest::where('id', '=', $request->id)->update(['status' => 'Approve']);
        $data = AssistanceRequest::where('id', '=', $request->id)->first();
        $userdata = User::where('id', '=', $data->user)->first();
        if ($tutionrequest) {
            $CorporateCoupon = new CorporateCoupon();
            $CorporateCoupon = $CorporateCoupon->genrateCoupon($request);
            if ($CorporateCoupon) {
                $user->wallet_balance=$user->wallet_balance - $request->amount ;
             $user->save();
                $coupon = CorporateCoupon::find($CorporateCoupon);
                $buttonLink = env("APP_URL") . "login";
                $commentline =$request->comment.'<br><br> Coupon Code :'.$coupon->coupon;
                $emalbody=[
                    'Content'=>$commentline,
                ];
                $template_name = "Corporate Request Approval";
                $mailTo = $userdata->email;
              //  dd($mailTo, $userdata->name, $emalbody,$userdata);
                
             $resp = \App\Utility::send_emails( $mailTo, $userdata->name, null, $emalbody,'corporate_request_approval',$userdata);
           dd($resp);
            }
            return redirect()->back()->with('success', __("Application Approved successfully ."));
        } else {
            return redirect()->back()->with('error', __("Something went wrong."));
        }
    }

    public function SendRequestController(Request $request)
    {
        $data = AssistanceRequest::where('id', '=', $request->id)->first();
        $userdata = User::where('id', '=', $data->user)->first();
        $SendDetailsRequest = new SendDetailsRequest();
        $lastId = $SendDetailsRequest->storeData($request, $data);
        $buttonLink = env("APP_URL") . "login";
        $lastId = base64_encode($lastId);

        if ($request->optionType == 'moreInfo') {
            $link = "https://".env('MAIN_URL')."/". $lastId . "/moreinfo";
        } else {
            $link = "https://".env('MAIN_URL')."/". $lastId . "/requestfile";
        }
        $ojb = array(
            'Content' => $request->comment . '<br><br> Request Link : ' . $link,
        );
        $template_name = "Corporate request Information";
        $mailTo = 'karanmehra.km11@gmail.com';
       
		   $resp = \App\Utility::send_emails( $mailTo, $userdata->name, null, $ojb,'corporate_request_information',$userdata);

        return redirect()->back()->with('success', __("Request successfully  sent."));
    }

    public function tutionCouponHistory(Request $request)
    {
        $user = Auth::user();

        if ($request->ajax()) {
            $data = CorporateCoupon::where('user', '=', $user->id)
                ->orderByDesc('id');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('name', function ($data) {
                    if(getUserDetails($data->redeemer)){
                        return getUserDetails($data->redeemer)->name;
                    }else{
                        return  'User Deleted';
                    }

                })->addColumn('certify', function ($data) {
                    if(getCertifyDetails($data->certify)){
                        return getCertifyDetails($data->certify)->name;
                    }else{
                        return  'Certify Deleted';
                    }
                })->addColumn('price_limit', function ($data) {
                    return '$'.$data->price_limit;
                })->addColumn('status', function ($data) {
                    if($data->status == 'used') {
                        return '<span class="badge badge-dot mr-4">
                                <i class="bg-success"></i>
                                <span class="status">Redeemed</span>
                            </span>';
                    }else{
                       return  '<span class="badge badge-dot mr-4">
                                <i class="bg-danger"></i>
                                <span class="status">Pending</span>
                            </span>';
                    }
                })->addColumn('action', function ($data) {
                    $authuser = Auth::user();
                    $actionBtn = '<div class="actions text-center">
                                    <a href="javascript:void(0)"
                                       class="action-item text-danger destroyCertify" data-id="'.$data->id.'"
                                       data-toggle="tooltip" data-original-title="Delete">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </div>';
                    return $actionBtn;
                })
                ->rawColumns(['action', 'name', 'certify', 'price_limit', 'status'])
                ->make(true);
        } else {
            if ($user->type == 'corporate') {
                $couponHistory = CorporateCoupon::where('user', '=', $user->id)->orderByDesc('id')->get();
                return view('certify.couponHistory', compact('user', 'couponHistory'));
            } else {
                return redirect()->back()->with('error', __('Permission Denied.'));
            }
        }
    }

    public function tutionCouponHistoryDelete(Request $request)
    {
        $user = Auth::user();
        $couponHistory = CorporateCoupon::find($request->id);
        $couponHistory = $couponHistory->delete();
        if ($couponHistory) {
            return redirect()->back()->with('success', __("Record successfully Detected."));
        } else {
            return redirect()->back()->with('error', __("Something went wrong"));
        }
    }

    public function checkCoupon(Request $request)
    {
        $user = Auth::user();
        $coupon = CorporateCoupon::where(['certify' => $request->certifyId, 'coupon' => $request->coupon, 'status' => 'not_used' , 'redeemer' => $user->id])->first();
        return $coupon;
    }

    public function applyCoupon(Request $request)
    {
        $user = Auth::user();
        $StripePayment = new StripePayment();
        $StripePayment = $StripePayment->freeCourse($request);
        if ($StripePayment) {
            return redirect()->back()->with('success', __("Coupon applied."));
        } else {
            return redirect()->back()->with('error', __("Something went wrong."));
        }
    }

    public function conference()
    {
        $user = Auth::user();

        return view('conference.main');
    }

    public function conferenceschedule(Request $request)
    {
        $user = Auth::user();
         return view('conference.schadule');
         }

    public function conferencehistory()
    {
        $user = Auth::user();

        return view('conference.history');
    }

    public function certifyUnpublished()
    {
        $authuser = Auth::user();
        $title = 'Unpublished Certify';
        $Certifies = Certify::where('user_id', '=', $authuser->id)->where('status', '=', 'Unpublished')->orderByDesc('id')->paginate(5);
        return view('certify.inactiveCertify', compact('authuser', 'Certifies', 'title'));
    }

    public function certifypublished()
    {
        $authuser = Auth::user();
        $title = 'Published Certify';
        $Certifies = Certify::where('user_id', '=', $authuser->id)->where('status', '!=', 'Unpublished')->orderByDesc('id')->paginate(5);
        return view('certify.inactiveCertify', compact('authuser', 'Certifies', 'title'));
    }
    public function testcatalog()
    {
        $authuser = Auth::user();
        $title = 'Test Courses Catalog';
       return view('certify.testcatalog', compact('authuser', 'title'));
    }

 public function sendCatalogTestEmail(Request $request)
    {   $authuser = Auth::user();
    if ($request->email && ($authuser->type=="admin" || $authuser->type=="owner")) {
            $res=Certify::sendWeeklyRecommendedCourses($request->email);

            if(!empty($res['error'])){
                return redirect()->back()->with('error', __($res['error']));
            }elseif(!empty ($res['success'])){
            return redirect()->back()->with('success', __($res['success']));
            }else{
                return redirect()->back()->with('warning', __("Unknown error occured"));
            }
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }
	public function syndicate_requests(){
	  $authuser = Auth::user();
	  $courses= Certify::where('syndicate','Enabled')->where('syndicate_approval','PENDING')->get();
	 return view('certify.syndicate_requests', compact('authuser', 'courses'));
	}






    public function syndicateApprove()
    {
        $authuser = Auth::user();
        if (isset($_GET['certifyId']) && !empty($_GET['certifyId'])) {
            $certifyid = $_GET['certifyId'];
            $certify = Certify::find($certifyid);
            if ($certify) {
                $certify->syndicate_approval = 'APPROVE';
                $certify->save();
            }
            return true;
        } else {
            return false;
        }
    }

	   public function frontendview(){
		       $authuser = Auth::user();
        if (isset($_GET['certifyId']) && !empty($_GET['certifyId'])) {
		   $certifyid = $_GET['certifyId'];
            $certify = Certify::find($certifyid);
			  if ($certify) {
				$Showsyndicate= new Showsyndicate();
				$Showsyndicate['user_id'] = $authuser->id;
				$Showsyndicate['certify_id'] = $certify->id;	
			$Showsyndicate['domain_id'] =  get_domain_id();;
				$Showsyndicate->save();
			  }
		 return true;
        } else {
            return false;
        }


	   }

	     public function deletefrontendview(){
		       $authuser = Auth::user();
        if (isset($_GET['certifyId']) && !empty($_GET['certifyId'])) {
		   $certifyid = $_GET['certifyId'];
            $certify = Showsyndicate::where('certify_id',$certifyid)->delete();

		 return true;
        } else {
            return false;
        }


	   }

	       public function certifyApprove(Request $request) {
        if ($request->status == 'approve') {
            $action = 1;
        } else {
            $action = 2;
        }
        AssistanceRequest::where('id', $request->id)->update(['action' => $action]);
        $tutionrequest = AssistanceRequest::select('id', 'certify')->where('action', 0)->where('user', '=', $request->user_id)->orderByDesc('id')->get();
        $html = '<div class="row"><div class="col-8"><h3>Active Requests</h3></div><div class="col-4 "><h5 class="right"><a href="javascript::void(0);" class="cls_history">History</a></h5></div></div>';
        if (!$tutionrequest->isEmpty()) {
            $html .= '<div class="opportunity"><ul class="opportunity_ul">';
            foreach ($tutionrequest as $tR) {
                $html .= '<li class="list-group-item d-flex justify-content-between align-items-center">';
                $html .= '<img src="' . asset("storage") . '/certify/' . getCertifyDetails($tR->certify)->image . '" class="avatar-xl" >';
                $html .= '<span class="px-4">$'.getCertifyDetails($tR->certify)->price . '  ' . getCertifyDetails($tR->certify)->name.'</span>';
                $html .= '<a href="javascript::void(0)" data-toggle="tooltip" title="Approve" class="certify_approve" data-id="' . $tR->id . '"><i class="fa fa-check-circle fa-2x"></i></a><a href="javascript::void(0)" data-id="' . $tR->id . '" data-toggle="tooltip" title="Reject" class="certify_reject"><i class="fa fa-times-circle fa-2x" ></i></a></li>';
            }
            $html .= '</ul></div>';
            $response = array('result' => true, 'html' => $html);
        } else {
            $html .= '<h5>No courses found.</h5>';
            $response = array('result' => false, 'html' => $html);
        }
        return json_encode($response);
    }
	
	
	public function dashboard(){
		
		$user = Auth::user();
        if ($user->type == 'corporate') {
            if (!empty($_GET['chart_filter'])) {
                $type = $_GET['chart_filter'];
            } else {
                $type = 'Male';
            }
            $home_data = [];
            $requests = AssistanceRequest::where('assistance', $user->id)->count();
            $totalpaid = CorporateCoupon::where('user', $user->id)->sum('price_limit');
            $delined = AssistanceRequest::where('assistance', $user->id)->where('status', 'Decline')->count();
            $pending = AssistanceRequest::where('assistance', $user->id)->where('status', 'Pending')->count();

            $total_request = AssistanceRequest::where('assistance', $user->id)->count();
			
			 $seven_days = AssistanceRequest::getLastSevenDays();
            $task_overview = [];
            $timesheet_logged = [];
            foreach ($seven_days as $date => $day) {

                $time = AssistanceRequest::where([['gender', '=', $type], ['assistance', '=', $user->id], ["date", 'LIKE', "%" . $date . "%"]])->get()->pluck('time')->toArray();
                $points = AssistanceRequest::where([['gender', '=', $type], ['assistance', '=', $user->id], ["date", 'LIKE', "%" . $date . "%"]])->count('id');


                $timesheet_logged[__($day)] = str_replace(':', '.', AssistanceRequest::affiliate_calculateTimesheetHours($time, $points));
            }
			 $home_data['task_overview'] = $task_overview;
            $home_data['timesheet_logged'] = $timesheet_logged;
			 return view('certify.corporate_dashboard', compact('user', 'requests', 'pending', 'delined', 'home_data', 'type','totalpaid'));
	}
	
	
}


}