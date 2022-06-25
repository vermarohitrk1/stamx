<?php

namespace App\Http\Controllers;

use Illuminate\Support\Arr;
use Stripe;
use App\User;
use App\Photoboothsharecount;
use App\Page;
use App\Blog;
use App\Plan;
use App\Order;
use App\Certify ;
use App\MyCourse;
use App\Book;
use App\SendDetailsRequest;
use App\Photobooth;
use App\Faq;
use App\BookCategory;
use App\Menu;
use App\AssistanceRequest;
use App\BlogCategory;
use App\SiteSettings;
use App\Virtualbooth;
use App\VirtualboothEvent;
use App\VirtualboothEventsFrames;

use App\Partner;
use Validator,
    Redirect,
    File,
    Response;
use	Cloudinary;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\ClientInterface;
use Carbon\Carbon;
use DataTables;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Http\Request;

use DateTime;
use DateInterval;
use DatePeriod;
use Mail;
use App\StripePayment;

use Illuminate\Support\Facades\Storage;


class FrontendController extends Controller {

    public function __construct() {

    }

    public function index() {
       // $domain_id = get_domain_id();
        $user = get_domain_user();
        $domain_id = get_domain_id();
       // $mainMenu = Menu::getWebsiteMenus('main_menu');
        $domain_theme=\App\SiteSettings::getValByName('domain_theme');
        $domain_theme=$domain_theme['domain_theme']??'';
        $partners = Partner::where('status', 'Active')->where('custom_url',$domain_id)->get();

        $recent_blogs = Blog::where('status', 'Published')->where(['domain_id' => $domain_id])->orderBy('created_at', 'DESC')->limit(3)->get();
        $addons = \App\Addon::select('id','icon','title','addon_key','status','usage_status','features','description','category')->where('status','Published')->where('usage_status','Enabled')->get();
        $podcasts = \App\Podcast::where('user_id', $user->id)->get();
        if(!empty($domain_theme)){
           return view('frontend.'.$domain_theme.'.index', compact('user','partners','recent_blogs','podcasts','addons'));
        }else{
        return view('frontend.index', compact('user','partners','podcasts','addons'));
        }
    }

    public function index2() {

        $partners = Partner::where('status', 'Active')->get();

		if( env('FRONTEND_THEME') =='home1'){
		$home='frontend.home1.index';
		}
		elseif( env('FRONTEND_THEME') =='home2'){
		$home='frontend.home2.index';
		}
		elseif( env('FRONTEND_THEME') =='home3'){
		$home='frontend.home3.index';
		}
		elseif( env('FRONTEND_THEME') =='home4'){
		$home='frontend.home4.index';
		}
		else{

			$home='frontend.index';
		}

        return view($home, compact('partners'));
    }

    /*     * page */

    public function page($slug) {
        $user = get_domain_user();
       // $user_id = Auth::user()->id;
        // $modules = Module::where('slug', 'pages')->where('user_id', $user_id)->first();
        $page = Page::where('slug', $slug)->where('user_id', $user->id)->where('status', 'Published')->first();

        if ($page) {
            return view('frontend.page', compact('page'));
        } else {
            return redirect('/');
        }
    }

    /*
      Books
     */

    public function books() {
        $domain_id = get_domain_id();
        $user = get_domain_user();

        $books = Book::where('status', 'Published')->orderBy('created_at', 'DESC')->limit(5)->get();
        $BookCategory = BookCategory::leftjoin('books','books_categories.id','=','books.category')
                ->where('books.status', '=', 'Published')
                ->where('books.user_id',$user->id)
                ->select('books_categories.*')
                ->groupBy('books_categories.id')
                ->get();
       
        $recent_blogs_group = Book::selectRaw('category,count(id) as count')->where('status', "Published")->where(['user_id' => $domain_id])->groupBy('category')->get();
        $tags_array = $books->pluck('tags');


        return view('frontend.mentoringtheme.book.books', compact('books', 'recent_blogs_group', 'tags_array', 'BookCategory'));
    }

    public function bookfilter(Request $request) {
        $user_id = get_domain_id();
 $user = get_domain_user();
        $date = date('Y-m-d h:m:s');

        $build_query = Book::where('status', '=', 'Published')->where('user_id',$user->id)->orderBy(DB::raw('RAND()'));


        // $build_query->where('user_id', $user_id);


        if (!empty($request->search)) {
            $build_query->where('title', 'LIKE', '%' . $request->search . '%');
        }

//        if (!empty($request->category) && $request->category != 'All') {
//            $build_query->where('category', $request->category);
//        }
       
         if (!empty($request->category)) {
            $build_query->whereIn('category', $request->category);
        }
        if (!empty($request->type)) {

            foreach($request->type as $type){
                if($type == 'featured'){
                    $build_query->where($type, 1);
                }elseif($type == 'latest'){
                    $build_query->reorder('created_at', 'DESC');
                }elseif($type == 'tranding'){
                    $build_query->reorder('trending', 'DESC');
                }
            }

        }

        if (isset($request->time)) {
            $time = $request->time;
        } else {
            $time = '';
        }
        if (!empty($time)) {
            if (in_array('onemonth', $time)) {
                $timeFormatted = date('Y-m-d h:m:s', strtotime('-1 months', strtotime($date)));
            } elseif (in_array('fourteenday', $time)) {
                $timeFormatted = date('Y-m-d h:m:s', strtotime('-14 days', strtotime($date)));
            } elseif (in_array('sevenday', $time)) {
                $timeFormatted = date('Y-m-d h:m:s', strtotime('-7 days', strtotime($date)));
            } elseif (in_array('oneday', $time)) {
                $timeFormatted = date('Y-m-d h:m:s', strtotime('-1 days', strtotime($date)));
            } elseif (in_array('lasthour', $time)) {
                $timeFormatted = date('Y-m-d h:m:s', strtotime('-1 hours', strtotime($date)));
            }
        }
        if (!empty($timeFormatted)) {
            $build_query->where('created_at', '>=', $timeFormatted);
        }
       // $build_query->inRandomOrder();
        $data = $build_query->paginate(6);


        return view('frontend.mentoringtheme.book.FilterList', compact('data'));
    }

    public function books_detail(Request $request, $id = null) {
        $user_id = get_domain_id();
        $id = !empty($request->id) ? encrypted_key($request->id, 'decrypt') : 0;
        $book = Book::where("id", $id)->first();


        $book_featured = Book::where('featured', 1)->inRandomOrder()->get();
        $book_treading = Book::orderBy('trending','DESC')->inRandomOrder()->limit(5)->get();
        $book_favourite = Book::where('favourite_read', 1)->inRandomOrder()->get();

        $BookCategory = BookCategory::all();

        $BookCategorylimit = BookCategory::paginate(5);
        foreach($BookCategory as $cat){
            $cat->count = Book::where('category',$cat->id)->count();
        }
        $checkExist = ''; // $checkExist = Setting::where('name', 'amazon_affiliate')->where('created_by', $user_id)->first();
        // $itunesExists = Setting::where('name', 'itunes_id')->where('created_by', $user_id)->first();
        $afflink = "";
        $itunes = "";
        if (!empty($book->buylink)) {
            if (strlen($book->buylink) == 10) {
                $productid = $book->buylink;
            } else {
                preg_match("/\/([a-zA-Z0-9]{10})(\/|$)/", $book->buylink, $parsetest);
                $productid = !empty($parsetest[1]) ? $parsetest[1] : '';
            }
            if (strlen($productid) == 10 && ctype_alnum($productid) && !empty($checkExist->value)) {
                $afflink = "http://www.amazon.com/dp/" . $productid . "/?tag=" . $checkExist->value;
            } elseif (strlen($productid) == 10 && ctype_alnum($productid)) {
                $afflink = "http://www.amazon.com/dp/" . $productid . "/";
            }
        }

        if (!empty($book->itunes_link)) {
            if (strlen($book->itunes_link) == 10) {
                $productid = $book->itunes_link;
            } else {
                $link = explode('/id', parse_url($book->itunes_link, PHP_URL_PATH));
                $link_id = !empty($link[1]) ? $link[1] :'';
                $data = file_get_contents('https://itunes.apple.com/lookup?id=' . $link_id . '&entity=ebook');
                $response = json_decode($data);
                $geo_link =!empty($response->results[0]->trackViewUrl) ? preg_replace('/itunes/ms', "geo.itunes", $response->results[0]->trackViewUrl):'';
                if (!empty($itunesExists->value)) {
                    $itunes_id = $itunesExists->value;
                    $itunes = $geo_link . '&at=' . $itunes_id;
                } else {
                    $itunes = $geo_link;
                }
            }
        }

        //$books = Book::where('status', "Published")->where('user_id', $user_id)->orderBy("id", "desc")->paginate(2);
        return view('frontend.mentoringtheme.book.details', compact('book', 'book_favourite', 'book_featured', 'BookCategory', 'book_treading', 'afflink', 'itunes'));
//        return view('frontend.pages.books_detail', compact('book', 'books', 'book_collection', 'BookCategory', 'modules', 'afflink'));
    }
    public function book_trending(Request $request) {
        $trending =  Book::find($request->id)->increment('trending',1);
        if($trending){
            return response()->json(['responce'=>'success'],200);
        }
    }

    /*
      end books section
     */

    public function blogs() {
        $domain_id = get_domain_id();
        $user = get_domain_user();
        $recent_blogs = Blog::where('status', 'Published')->where(['domain_id' => $domain_id])->orderBy('created_at', 'DESC')->limit(5)->get();
        $recent_blogs_group = Blog::selectRaw('category,count(id) as count')->where('status', "Published")->where(['domain_id' => $domain_id])->groupBy('category')->get();
        $tags_array = $recent_blogs->pluck('tags');


        return view('frontend.mentoringtheme.blog.searchblogs', compact('recent_blogs', 'recent_blogs_group', 'tags_array'));
    }

    public function blogs_detail(Request $request, $id = null) {
        $id = !empty($request->id) ? encrypted_key($request->id, 'decrypt') : 0;
        if ($id == false) {
            return Redirect::to('/blogs');
        }

        $row = Blog::where("id", $id)->first();
        $tags = explode(',', $row->tags);
        $domain_id = get_domain_id();
        $user = get_domain_user();
        $recent_blogs = Blog::where('status', 'Published')->where(['domain_id' => $domain_id])->orderBy('created_at', 'DESC')->limit(5)->get();
        $recent_blogs_group = Blog::selectRaw('category,count(id) as count')->where('status', "Published")->where(['domain_id' => $domain_id])->groupBy('category')->get();
        $tags_array = $recent_blogs->pluck('tags');

        return view('frontend.mentoringtheme.blog.blogdetails', compact('row', 'tags', 'recent_blogs', 'recent_blogs_group', 'tags_array'));
    }

    public function blogfilter(Request $request) {
        $domain_id = get_domain_id();
        $date = date('yy-m-d h:m:s');
        $dbdate=date('Y-m-d');
        $build_query = Blog::whereRaw('(expiry_status IS Null OR expiry_date >="'.$dbdate.'")')->whereRaw('(status="Published" OR prepublish_date <="'.$dbdate.'")')->orderBy('id', 'DESC');

        if (!empty($domain_id)) {
            $build_query->where('domain_id', $domain_id);
        }

        if (!empty($request->search)) {
            $build_query->where('title', 'LIKE', '%' . $request->search . '%');
            $build_query->Orwhere('article', 'LIKE', '%' . $request->search . '%');
        }
        if (!empty($request->tag)) {
            $build_query->where('tags', 'LIKE', '%' . $request->tag . '%');
        }

        if (!empty($request->category) && $request->category != 'All') {
            $build_query->where('category', $request->category);
        }


        if (isset($request->time)) {
            $time = $request->time;
        } else {
            $time = '';
        }
        if (!empty($time)) {
            if (in_array('onemonth', $time)) {
                $timeFormatted = date('yy-m-d h:m:s', strtotime('-1 months', strtotime($date)));
            } elseif (in_array('fourteenday', $time)) {
                $timeFormatted = date('yy-m-d h:m:s', strtotime('-14 days', strtotime($date)));
            } elseif (in_array('sevenday', $time)) {
                $timeFormatted = date('yy-m-d h:m:s', strtotime('-7 days', strtotime($date)));
            } elseif (in_array('oneday', $time)) {
                $timeFormatted = date('yy-m-d h:m:s', strtotime('-1 days', strtotime($date)));
            } elseif (in_array('lasthour', $time)) {
                $timeFormatted = date('yy-m-d h:m:s', strtotime('-1 hours', strtotime($date)));
            }
        }
//        echo '<pre>';
//        print_r($timeFormatted);
//        exit;
        if (!empty($timeFormatted)) {
            $build_query->where('created_at', '>=', $timeFormatted);
        }

        $data = $build_query->paginate(6);


        if (!empty($request->view) && $request->view == 'list') {
            return view('frontend.demo23.blogs.FilterList', compact('data'));
        } else {
            return view('frontend.mentoringtheme.blog.FilterGrid', compact('data'));
        }

//
//        return view('frontend.pages.jobsFilter', compact('jobs'));
    }

    public function subscribe(Request $request) {
	if(empty(check_email_is_valid($request->email))){
                return redirect()->back()->with('error', __('Invalid Email'));
                }
        if (!empty($request->email)) {
            $data= array(
                    'email' => $request->email
                );

			$encrptEmail=	encrypted_key($request->email, 'encrypt');
			$link='https://'.env('MAIN_URL').'/verify/newsletter?email='.$encrptEmail;
           //send email template
            if(!empty($data['email'])){
            $body=[
                'Email'=>$link,
            ];
            $resp = \App\Utility::send_emails($data['email'], 'Subscriber', null, $body,'signup_newsletter',$data['email']);

            return redirect()->back()->with('success', __('Please verify the email id for subscription.'));

		//dd($semdmail);
            }else{
             return redirect()->back()->with('error', $response['message']??"Unknown Error");
            }

        } else {
            return redirect()->back()->with('error', __('Email is Required.'));
        }
    }

    public function unsubscribe(Request $request) {
        if (!empty($request->email)) {
            $domain_user = get_domain_user();
            $user_id = $domain_user->id ?? 0;
            \App\Contacts::where('email', $request->email)->where('user_id', $user_id)
                    ->each(function ($oldRecord) {
                        $newPost = $oldRecord->replicate();
                        $newPost->setTable('unsubscribers');
                        $newPost->save();

                        $oldRecord->delete();
                    });
            return redirect()->back()->with('success', __('Newsletter UnSubscribed Successfully.'));
        }
    }

	public function verifynewsletter(){
		$decrypt=	encrypted_key($_GET['email'], 'decrypt');

		   $data= array(
                    'email' => $decrypt
                );
		 $response= \App\Contacts::create_contact($data, 'Newsletters');
	  return redirect('/')->with('success', __('Newsletter Subscribed Successfully.'));
	}
    public function profiles(Request $request) {
        $search=$request->search_input??'';
        $search_cat=$request->search_category??'';
        $domain_id = get_domain_id();
        $roles = get_permission_roles('add_in_search_profiles');

        return view('frontend.mentoringtheme.profiles.searchprofile', compact('roles','search','search_cat'));
    }
public function profilereviewpost(Request $request) {

        $user = Auth::user();
        $success = 'error';
        $message = "Please login first to submit review.";
        if (!empty($request->rating) && !empty($request->review) && !empty($request->id)) {
            if (!empty($user->id)) {
                 $slots= \App\MeetingScheduleSlot::where('user_id',Auth::user()->id??0)->count();
                $user_rating = \App\UserProfileRating::where("user_id", Auth::user()->id??0)->where("profile_id", $request->id)->count();


                if($user_rating<$slots){
                   $user_rating=0;
               }


                    $rating = new \App\UserProfileRating();
                    $rating['user_id'] = $user->id;
                    $rating['profile_id'] = $request->id;
                    $rating['rating'] = $request->rating;
                    $rating['comment'] = $request->review;
                    $rating->save();

                    $product_avg_rating = \App\UserProfileRating::where("profile_id", $request->id)->avg('rating');
                    $product_details = \App\User::find($request->id);
                    $product_details->average_rating = $product_avg_rating;
                    $product_details->save();
                    $message = "Successfully submitted";


                $success = 'success';
            }
        } else {
            $message = "Please fill required fields";
        }

         return redirect()->back()->with($success, $message);

    }
    public function photoboothsharecount(Request $request) {
       $data =  Photoboothsharecount::create(
            [
                'count' => $request->type,
                'url' => $request->url,
                'name' => $request->name,
                'email' => $request->email,
                'frame_id' => $request->frame_id,

            ]
    );
  //  dd( $data );
    if($data){
        return json_encode([
            'status' => 'success',
            'data' => $data,
        ]);

    }
    else{
        return json_encode([
            'status' => 'error',
            'data' => $data,
        ]);
    }
    }
    public function profilefilter(Request $request) {
        $role =array();
        $member = 0;
        if(isset( $request->role)){
        if (in_array("member", $request->role)){
            $role =  $request->role;
            $member = 1;


         }
        else{

            $role = $request->role;
        }
    }

        $domain_id = get_domain_id();
        $domain_user = get_domain_user();
        $date = date('Y-m-d h:m:s');

        $build_query = \App\User::select('users.*')->where('profile_completion_percentage','>=',80)->where('avatar','!=',null);

        if(Auth::user()){
            $build_query->where('id', '!=', Auth::user()->id);
        }
        $roles = get_permission_roles('add_in_search_profiles');
        if(!empty($roles)) {
            $build_query->whereIn('users.type', $roles);
        }
        if (!empty($request->type)) {

            switch ($request->type){
                case 'instructor':
                    $build_query->join('instructors as i', "i.user_id", 'users.id');
                  $build_query->where('i.domain_id', $domain_id);
                    break;
            }

        }elseif(!empty($domain_user)) {
            // $build_query->where('users.created_by', $domain_user->id);
            // $build_query->orwhere('users.id', $domain_user->id);       // providing wrong data
        }

        if (!empty($request->search)) {
            $build_query->where('users.name', 'LIKE', '%' . $request->search . '%');
            $build_query->orwhere('users.state', 'LIKE', '%' . $request->search . '%');
            $build_query->orwhere('users.country', 'LIKE', '%' . $request->search . '%');
        }

        if (!empty($role)) {
			// foreach($role as $_role){
		// $_rolee=$_role;
				// if($_rolee =='mentor' && $_rolee =='mentee' ){
			// dd('sdsds');

		// }
			//}

            $pos = array_search('member', $role);


        //    unset($role[$pos]);
	if($member){
		 if (in_array("mentor", $role)){


			  $build_query->where('users.type','mentor')->Where('users.board_member', $member);
		 }
		 elseif(in_array("mentee",  $role)){
			  $build_query->where('users.type','mentee')->Where('users.board_member', $member);
		 }
		 elseif(in_array("corporate",  $role)){
			  $build_query->where('users.type','corporate')->Where('users.board_member', $member);
		 }
		 else{
			  $build_query->Where('users.board_member', $member);
		 }

	}
	else{

		 $build_query->whereIn('users.type', $role);
	}

        }
        if (!empty($request->gender)) {
            $build_query->whereIn('users.gender', $request->gender);
        }
        if (!empty($request->rating)) {
            $build_query->whereIn('users.average_rating', $request->rating);
        }
        if (!empty($request->sortby)) {
           $build_query->orderBy($request->sortby, 'DESC');
        } else {
            $build_query->orderBy('users.id', 'DESC');
        }



        if (!empty($request->min_amount)) {
            $build_query->where('price', ">=", $request->min_amount);
        }
        if (!empty($request->max_amount)) {
            $build_query->where('price', "<=", $request->max_amount);
        }


        $data = $build_query->paginate(10);

            if($request->viewtype=="grid"){
                 $responseHtml= view('frontend.mentoringtheme.profiles.FilterGrid', compact('data'))->render();
            }elseif($request->viewtype=="map"){

                $alladdress = array();
                $content = array();
                 foreach($data as $user){
                     $address[$user->city] = array();
                     $content['content']= "Name: ". $user->name . " Address: ". $user->address1;
                     $address[$user->city]['latitude'] = $user->address_lat;
                     $address[$user->city]['longitude'] = $user->address_long;
                    $address[$user->city]['tooltip'] =  $content;

                    $alladdress[$user->city] =  $address[$user->city];
                 }
                 $data = json_encode($alladdress);

                 $responseHtml = view('frontend.mentoringtheme.profiles.map', compact('data'))->render();
            }else{
                    $responseHtml= view('frontend.mentoringtheme.profiles.FilterList', compact('data'))->render();
            }
            $responseMapHtml=array();

             if($data->count() > 0){
                 foreach($data as $row){
                 $mapEntity=array(
                               "id"=>$row->id,
                         "doc_name"=>$row->name,
                         "speciality"=>$row->getJobTitle(),
                         "address"=>$row->state.", ".$row->country,
                         "lat"=>$row->address_lat,
                         "lng"=>$row->address_long,
                         "icons"=>"default",
                         "profile_link"=>route('profile',["id"=>encrypted_key($row->id,"encrypt")]),
                         "rating"=>$row->average_rating,
                         "total_review"=>$row->getProfilefeebackCount(),
                         "image"=>$row->getAvatarUrl()
                 );
                 array_push($responseMapHtml, $mapEntity);
                 }
             }

            return response()->json([
                'map' => $responseMapHtml,
                'html' => $responseHtml,
            ]);
    }
    public function profilereviews(Request $request) {

        $build_query = \App\UserProfileRating::where('profile_id', $request->id)->orderBy('created_at', 'DESC')->with('reply','user');


        $data = $build_query->paginate(10);// dd($data);
            $responseHtml= view('frontend.mentoringtheme.profiles.FilterReviews', compact('data'))->render();

            return response()->json([
                'html' => $responseHtml,
            ]);
    }

    public function Schedulebookingfilter(Request $request) {
        $domain_id = get_domain_id();
        $today = date('Y-m-d');

        $start_date=!empty($request->start_date) ? $request->start_date :$today;
        $begin = new DateTime($start_date);
        $end = new DateTime(date('Y-m-d', strtotime($start_date . ' + 7 days')));

        $interval = DateInterval::createFromDateString('1 day');
        $period = new DatePeriod($begin, $interval, $end);
        $duration=array();
        foreach ($period as $i=>$dt) {
            $date = $dt->format("Y-m-d");
           $duration[$i]['day']=$dt->format("D");
           $duration[$i]['year']=$dt->format("Y");
           $duration[$i]['date']=$dt->format("d");
           $duration[$i]['month']= strtoupper($dt->format("M"));
           $duration[$i]['db_date']=$dt->format("Y-m-d");
        }

        $build_query = \App\MeetingScheduleSlot::select('meeting_schedules_slots.*', 'ms.title','ms.price as slot_price')
                ->join('meeting_schedules as ms', 'ms.id', 'meeting_schedules_slots.meeting_schedule_id')
                ->whereBetween('meeting_schedules_slots.date', [$duration[0]['db_date'], $duration[6]['db_date']])
//                ->where('meeting_schedules_slots.user_id', NULL)
                ->where('ms.user_id', $request->id);

        if (!empty($request->sortby)) {
            switch ($request->sortby) {
                case "low";
                    $build_query->orderBy('price', 'ASC');
                    break;
            }
        }




               $build_query->groupBy('meeting_schedules_slots.date','meeting_schedules_slots.start_time', 'meeting_schedules_slots.end_time');
               $build_query->orderBy('meeting_schedules_slots.date', 'asc');
        $data = $build_query->get();
        $uid=$request->id;


        return view('frontend.mentoringtheme.profiles.BookingFilterGrid', compact('data','duration','today','uid'));
    }

    public function learn(Request $request) {
        $search_category=$request->category??0;

        $domain_id = get_domain_id();
        $CertifyCategory = \App\CertifyCategory::getCourseCategories();
        $max_price = \App\Certify::where('domain_id', $domain_id)->where('status', "Published")->max('price');
        return view('frontend.mentoringtheme.courses.searchcourses', compact('CertifyCategory', 'max_price','search_category'));
    }

    public function learnDetail($id_encrypted = null) {
        $id = !empty($id_encrypted) ? encrypted_key($id_encrypted, 'decrypt') : 0;


        if ($id == false) {
            return redirect()->back()->with('error', __('Permission denied.'));
        }


        $domain_id = get_domain_id();
        $array = [$id];
        $authuser = Auth::user();
        $row = Certify::where("id", $id)->first();

        $learns = \App\Certify::where("category", $row->category)->where("id", '!=', $id)->limit(6)->get();
        $learnCategories = \App\CertifyCategory::all();
        return view('frontend.mentoringtheme.courses.coursedetails', compact('row', 'learnCategories', 'learns'));
    }

    public function learnFilter(Request $request) {
        $domain_id = get_domain_id();
        $date = date('Y-m-d h:m:s');

        $build_query =  DB::table('certifies')
		    ->select('certifies.*', 'show_syndicate.id as show_syndicateemail ,show_syndicate.certify_id ')
        ->leftJoin('show_syndicate', 'show_syndicate.certify_id', '=', 'certifies.id')
		->where('status', '=', 'Published')
		->where('certifies.domain_id','=',$domain_id)
		->Orwhere('show_syndicate.domain_id','=', $domain_id)
		->groupBy('certifies.id');


        if (!empty($request->search)) {
            $build_query->where('certifies.name', 'LIKE', '%' . $request->search . '%');
        }

        if (!empty($request->category)) {
            $build_query->whereIn('certifies.category', $request->category);
        }
        if (!empty($request->type)) {
            if (in_array('free', $request->type)) {
                $build_query->where('certifies.price', "<", 1);
            }
            if (in_array('board', $request->type)) {
                $build_query->where('certifies.boardcertified', 1);
            }
        }
        if (!empty($request->sortby)) {
            switch ($request->sortby) {
                case "low";
                    $build_query->orderBy('certifies.price', 'ASC');
                    break;
                case "high";
                    $build_query->orderBy('certifies.price', 'DESC');
                    break;
                case "latest";
                    $build_query->orderBy('certifies.created_at', 'DESC');
                    break;
                case "oldest";
                    $build_query->orderBy('certifies.created_at', 'ASC');
                    break;
            }
        } else {
            $build_query->orderBy('certifies.id', 'DESC');
        }

        if (isset($request->time)) {
            $time = $request->time;
        } else {
            $time = '';
        }
        if (!empty($time)) {
            if (in_array('onemonth', $time)) {
                $timeFormatted = date('Y-m-d h:m:s', strtotime('-1 months', strtotime($date)));
            } elseif (in_array('fourteenday', $time)) {
                $timeFormatted = date('Y-m-d h:m:s', strtotime('-14 days', strtotime($date)));
            } elseif (in_array('sevenday', $time)) {
                $timeFormatted = date('Y-m-d h:m:s', strtotime('-7 days', strtotime($date)));
            } elseif (in_array('oneday', $time)) {
                $timeFormatted = date('Y-m-d h:m:s', strtotime('-1 days', strtotime($date)));
            } elseif (in_array('lasthour', $time)) {
                $timeFormatted = date('Y-m-d h:m:s', strtotime('-1 hours', strtotime($date)));
            }
        }
        if (!empty($timeFormatted)) {
            $build_query->where('certifies.created_at', '>=', $timeFormatted);
        }

        if (!empty($request->min_amount)) {
            $build_query->where('certifies.price', ">=", $request->min_amount);
        }
        if (!empty($request->max_amount)) {
            $build_query->where('certifies.price', "<=", $request->max_amount);
        }


        $data = $build_query->paginate(8);


        return view('frontend.mentoringtheme.courses.FilterGrid', compact('data'));
    }


    public function learnCompanyFind(Request $request)
    {
        $data = '';
        $assistence = new MyCourse();
        if ($request->search == '') {
            $assistence = $assistence->getAllAssistenceOfCourse($request->certify);
        } else {
            $assistence = $assistence->getAllAssistenceOfCourseFind($request);
        }

        foreach ($assistence as $user) {
            $data .= "<option value=" . $user->user . ">" . getUserDetails($user->user)->name . "</option>";
        }
        return $data;
    }

	    public function assistenceRequestCreate(Request $request)
    {
        $AssistanceRequest = new AssistanceRequest();
        $AssistanceRequest = $AssistanceRequest->addData($request);
        $notification = array(
            'message' => 'Your request successfully  sent!',
            'alert-type' => 'success'
        );
        return Redirect::to('/search/courses')->with($notification);
    }
    public function UserProfileBooking($id_encrypted = null) {
        $id = !empty($id_encrypted) ? encrypted_key($id_encrypted, 'decrypt') : 0;
        if ($id == false) {
            return redirect()->back()->with('error', __('Permission denied.'));
        }


        $domain_id = get_domain_id();
        $authuser = Auth::user();
        $user = User::find($id);

        return view('frontend.mentoringtheme.profiles.booking', compact('id', 'user' ));
    }
    public function ProfileBookingCheckout(Request $request) {

        $permissions=permissions();
        $slot_id = !empty($request->selected_slots) ? $request->selected_slots : 0;
        $uid = !empty($request->uid) ? $request->uid : 0;

        if (empty($uid) || empty($slot_id) || !in_array("book_appointment",$permissions) ) { //|| !checkPlanModule('meeting_schedules_slots')
            return redirect()->back()->with('error', __('Permission denied.'));
        }


        $domain_id = get_domain_id();
        $authuser = Auth::user();
        $user=User::find($uid);
        $id=$user->id;
        $slots=  \App\MeetingScheduleSlot::select('meeting_schedules_slots.*', 'ms.title','ms.user_id as slot_user_id','ms.price as slot_price','ms.price_description','ms.description')
                ->join('meeting_schedules as ms', 'ms.id', 'meeting_schedules_slots.meeting_schedule_id')
                ->whereRaw('meeting_schedules_slots.id IN('.$slot_id.')')->get();

        return view('frontend.mentoringtheme.profiles.checkout', compact('id','slots' ,'user'));
    }
    public function program() {
        $authuser = Auth::user();
        $data = \App\Program::with('program_category')->get();
       // dd($data);
        $category = \App\ProgramCategory::get();

        return view('frontend.program.listing')->with(['data'=>$data , 'category'=>$category ]);
    }
    public function programfilter(Request $request) {

        $user_id = get_domain_id();

        $date = date('yy-m-d h:m:s');

        $build_query = \App\Program::orderBy('id', 'DESC')->with(['program_category','user']);


        // $build_query->where('user_id', $user_id);

//dd($request->category);
        if (!empty($request->search)) {
            $build_query->where('title', 'LIKE', '%' . $request->search . '%');
        }

        if (!empty($request->category)) {
            $build_query->whereIn('category_id', $request->category);
        }

       $data = $build_query->paginate(6);
//dd( $data);
$category = \App\ProgramCategory::get();
$p_cat =array();
foreach($category as $key => $cat){
    $p_cat[$key+1]=$cat->name;
}
//dd( $p_cat);
//        echo '<pre>';
//        print_r($data);
//        exit;
        return view('frontend.program.filterListing', compact('data'))->with(['data'=>$data, 'category'=>$p_cat]);
    }
    function checkDateFormat($date)
{
  // match the format of the date
  if (preg_match ("/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/", $date, $parts))
  {

    // check whether the date is valid or not
    if (checkdate($parts[2],$parts[3],$parts[1])) {
      return true;
    } else {
      return false;
    }

  } else {
    return false;
  }
}
    public function programdetails($id_encrypted = null) {
        $id = !empty($id_encrypted) ? encrypted_key($id_encrypted, 'decrypt') : 0;
  $erordate = 0 ;
        $authuser = Auth::user();
        $data =  \App\Program::find($id);
        $quedata = \App\Programable_question::get();
        $questions = array();
        $state='';
        foreach($quedata as $key => $question){
            $inc = $key+1;
          $questions['question_'.$question->id] = $question->question;
        }
        $statecount = 0;
        if($data->state != null){
            $state = json_decode($data->state, true);
            $statecount = count($state);
        }

        $recent_blogs = \App\Program::orderBy('created_at', 'DESC')->with('user')->limit(5)->get();
  $graph_data = json_decode($data->audit_report, true);
       $graphic = array();
       $graphicData = array();
       $graphictable=array();
   // dd($graph_data);
      if($graph_data != null){
       if (array_key_exists("date", $graph_data)) {
     $datesadsdsds =    $this->checkDateFormat( $graph_data['date']);
     if($datesadsdsds == true){
            $graphictable[0]['date'] =   $graph_data['date'] ;
//            $graphictable[0]['city'] = $graph_data['city'];
            $graphictable[0]['participants'] = $graph_data['participants'];
             $graphictable[0]['male_participants'] = $graph_data['male_participants']??0;
            $graphictable[0]['female_participants'] = $graph_data['female_participants']??0;
            $graphictable[0]['other_participants'] = $graph_data['other_participants']??0;
            $graphictable[0]['participant_cost'] = $graph_data['participant_cost']??0;
            $graphictable[0]['state'] = $graph_data['state'];
            $graphictable[0]['method'] = $graph_data['method'];
//            $graphictable[0]['framework'] = $graph_data['framework'];



//            $graphic['x'] =    preg_replace("/\s+/", "", strval($graph_data['date']))  ;
//            $graphic['y'] = $graph_data['participants'];
//            $graphicData[0] =  $graphic;

     }
     else{
      $erordate = 1;
     }



       }
       else{



        foreach($graph_data  as $key => $graph){
            $datesadsdsds =   $this->checkDateFormat( preg_replace("/\s+/", "", strval($graph['date'])) );
     if($datesadsdsds == true){

       $graphictable[$key]['date'] = preg_replace("/\s+/", "", strval($graph['date']))  ;
//            $graphictable[$key]['city'] = $graph['city'];
            $graphictable[$key]['participants'] = $graph['participants'];
               $graphictable[$key]['male_participants'] = $graph['male_participants']??0;
            $graphictable[$key]['female_participants'] = $graph['female_participants']??0;
            $graphictable[$key]['other_participants'] = $graph['other_participants']??0;
            $graphictable[$key]['participant_cost'] = $graph['participant_cost']??0;
            $graphictable[$key]['state'] = $graph['state'];
            $graphictable[$key]['method'] = $graph['method'];
//            $graphictable[$key]['framework'] = $graph['framework'];



//            $graphic['x'] =    preg_replace("/\s+/", "", strval($graph['date']))  ;
//            $graphic['y'] = $graph['participants'];
//            $graphicData[$key] =  $graphic;

     }
     else{
      $erordate = 1;
     }


           }
       }
    }


      //  dd($questions);
        return view('frontend.program.single')->with(['states'=>$state,'program_id'=>$id,'erordate'=>$erordate,'data'=>$data,'questions'=>$questions,'recent_blogs'=>$recent_blogs, 'graph_data'=>$graphicData,'graphictable'=>$graphictable,'statecount'=>$statecount]);
    }
    public function programdetailsgraph(Request $request) {
        $id = $request->id??0;
        $duration = $request->duration??'';
        $city = $request->city??'';
        $state = $request->state??'';
        $participant = $request->participant??'';
        $graphtype = $request->graph??'';
        $method = $request->method??'';

        if(!empty($duration)){
         $tilldate= Carbon::now()->addMonth($duration)->toDateString();
        }

  $erordate = 0 ;
        $authuser = Auth::user();
        $data =  \App\Program::find($id);

       $i=0;
  $graph_data = json_decode($data->audit_report, true);
       $graphic = array();
       $graphicData = array();
       $graphictable=array();
   // dd($graph_data);
      if($graph_data != null){
       if (array_key_exists("date", $graph_data)) {
     $datesadsdsds =    $this->checkDateFormat( $graph_data['date']);
     if($datesadsdsds == true){
            $graphictable[0]['date'] =   $graph_data['date'] ;
//            $graphictable[0]['city'] = $graph_data['city'];
            $graphictable[0]['participants'] = $graph_data['participants'];
            $graphictable[0]['male_participants'] = $graph_data['male_participants']??0;
            $graphictable[0]['female_participants'] = $graph_data['female_participants']??0;
            $graphictable[0]['other_participants'] = $graph_data['other_participants']??0;
            $graphictable[0]['participant_cost'] = $graph_data['participant_cost']??0;
            $graphictable[0]['state'] = $graph_data['state'];
            $graphictable[0]['method'] = $graph_data['method'];
//            $graphictable[0]['framework'] = $graph_data['framework'];

            $graphdate=preg_replace("/\s+/", "", strval($graph_data['date']))  ;
            if((empty($tilldate) || strtotime($graphdate) > strtotime($tilldate)) && (empty($city) || $city==$graph_data['city']) && (empty($method) || $method==$graph_data['method']) && (empty($state) || $state==$graph_data['state'])  && (empty($participant) || (!empty($graph_data['male_participants']) && $participant=="males") || (!empty($graph_data['female_participants']) && $participant=="females") || (!empty($graph_data['other_participants']) && $participant=="others") || ($participant=="roi") )){
                $singlecost=$graph_data['participant_cost']??0;
                 $totalcost=$graph_data['participants']*$singlecost;
                 $price=$data->price??0;
                 $roi=$price-$totalcost;

            $graphic['x'] =  $graphdate;
            switch ($participant){
                case 'males':
            $graphic['male'] = $graph_data['male_participants']??0;
            $graphic['female'] = 0;
             $graphic['other'] = 0;
            $graphic['y'] = $graph_data['participants'];
             $graphic['roi'] =0;
                    break;
                case 'females':
             $graphic['male'] = 0;
            $graphic['female'] = $graph_data['female_participants']??0;
             $graphic['other'] = 0;
            $graphic['y'] = $graph_data['participants'];
             $graphic['roi'] =0;
                    break;
                case 'others':
             $graphic['male'] = 0;
            $graphic['female'] = 0;
             $graphic['other'] = $graph_data['other_participants']??0;
            $graphic['y'] = $graph_data['participants'];
            $graphic['roi'] =0;
                    break;
                case 'roi':
             $graphic['male'] = 0;
            $graphic['female'] = 0;
             $graphic['other'] = 0;
            $graphic['y'] = 0;
            $graphic['roi'] = number_format($roi,2);
                    break;
                default:
             $graphic['male'] = $graph_data['male_participants']??0;
            $graphic['female'] = $graph_data['female_participants']??0;
             $graphic['other'] = $graph_data['other_participants']??0;
            $graphic['y'] = $graph_data['participants'];
            $graphic['roi'] = number_format($roi,2);
                    break;
            }

            $graphicData[0] =  $graphic;
            $i++;
            }

     }
     else{
      $erordate = 1;
     }



       }
       else{



        foreach($graph_data  as $key => $graph){
            $datesadsdsds =   $this->checkDateFormat( preg_replace("/\s+/", "", strval($graph['date'])) );
     if($datesadsdsds == true){

       $graphictable[$key]['date'] = preg_replace("/\s+/", "", strval($graph['date']))  ;
//            $graphictable[$key]['city'] = $graph['city'];
            $graphictable[$key]['participants'] = $graph['participants'];
              $graphictable[$key]['male_participants'] = $graph['male_participants']??0;
            $graphictable[$key]['female_participants'] = $graph['female_participants']??0;
            $graphictable[$key]['other_participants'] = $graph['other_participants']??0;
            $graphictable[$key]['participant_cost'] = $graph['participant_cost']??0;
            $graphictable[$key]['state'] = $graph['state'];
            $graphictable[$key]['method'] = $graph['method'];
//            $graphictable[$key]['framework'] = $graph['framework'];

            $graphdate= preg_replace("/\s+/", "", strval($graph['date']))  ;



             if((empty($tilldate) || strtotime($graphdate) > strtotime($tilldate)) && (empty($city) || $city==$graph['city']) && (empty($method) || $method==$graph['method']) && (empty($state) || $state==$graph['state'])  && (empty($participant) || (!empty($graph['male_participants']) && $participant=="males") || (!empty($graph['female_participants']) && $participant=="females") || (!empty($graph['other_participants']) && $participant=="others") || ($participant=="roi") || ($participant=="program") )){
                $singlecost=$graph['participant_cost']??0;
                 $totalcost=$graph['participants']*$singlecost;
                 $price=$data->price??0;
                 $roi=$price-$totalcost;

            $graphic['x'] =  $graphdate;
            switch ($participant){
                case 'males':
            $graphic['male'] = $graph['male_participants']??0;
            $graphic['female'] = 0;
             $graphic['other'] = 0;
            $graphic['y'] = $graph['participants'];
             $graphic['roi'] =0;
               $graphic['cost'] = 0;
            $graphic['singlecost'] = 0;
            $graphic['raised'] = 0;
                    break;
                case 'females':
             $graphic['male'] = 0;
            $graphic['female'] = $graph['female_participants']??0;
             $graphic['other'] = 0;
            $graphic['y'] = $graph['participants'];
             $graphic['roi'] =0;
               $graphic['cost'] = 0;
            $graphic['singlecost'] = 0;
            $graphic['raised'] = 0;
                    break;
                case 'others':
             $graphic['male'] = 0;
            $graphic['female'] = 0;
             $graphic['other'] = $graph['other_participants']??0;
            $graphic['y'] = $graph['participants'];
            $graphic['roi'] =0;
              $graphic['cost'] = 0;
            $graphic['singlecost'] = 0;
            $graphic['raised'] = 0;
                    break;
                case 'roi':
             $graphic['male'] = 0;
            $graphic['female'] = 0;
             $graphic['other'] = 0;
            $graphic['y'] = 0;
            $graphic['roi'] = number_format($roi,2);
             $graphic['cost'] = 0;
            $graphic['singlecost'] = 0;
            $graphic['raised'] = 0;
                    break;
                case 'program':
             $graphic['male'] = 0;
            $graphic['female'] = 0;
             $graphic['other'] = 0;
            $graphic['y'] = $graph['participants'];
            $graphic['roi'] = number_format($roi,2);
            $graphic['cost'] = number_format($price,2);
            $graphic['singlecost'] = number_format($singlecost,2);
            $graphic['raised'] = number_format($totalcost,2);
                    break;
                default:
             $graphic['male'] = $graph['male_participants']??0;
            $graphic['female'] = $graph['female_participants']??0;
             $graphic['other'] = $graph['other_participants']??0;
            $graphic['y'] = $graph['participants'];
            $graphic['roi'] = number_format($roi,2);
             $graphic['cost'] = number_format($price,2);
            $graphic['singlecost'] = number_format($singlecost,2);
            $graphic['raised'] = number_format($totalcost,2);
                    break;
            }

            $graphicData[$i] =  $graphic;
            $i++;
            }


     }
     else{
      $erordate = 1;
     }


           }
       }
    }

if($graphtype=="Donut"){
    $donutarray =array();
    if(!empty($participant) && $participant=="roi"){
        if(!empty($graphicData)){
    foreach ($graphicData as $i=>$row){
        $donutarray[$i]['label'] =($row['roi']<0 ? "-":'')."ROI (USD) on ".\App\Utility::getDateFormated($row['x']);
        $donutarray[$i]['value'] =abs($row['roi'])??0;
    }
    }else{
        $donutarray=array(
        array('label'=>"ROI",'value'=>0),
    );
    }

    }elseif(!empty($participant) && $participant=="program"){
         $donutarray=array(
        array('label'=>"ROI (USD)",'value'=>0),
        array('label'=>"Program Cost (USD)",'value'=>0),
        array('label'=>"Amount Raised (USD)",'value'=>0),
    );
         $totalparticipants=0;

        if(!empty($graphicData)){
    foreach ($graphicData as $i=>$row){

         $donutarray[1]['value'] =(float)  $row['cost'];

        $donutarray[2]['value'] +=(float) $row['raised'];
         $totalparticipants +=$row['y'];

    }
                 $roi=$donutarray[1]['value']-$donutarray[2]['value'];

    $donutarray[0]['label'] =($roi<0 ? "-":'').$donutarray[0]['label'];
        $donutarray[0]['value'] =abs($roi)??0;

        $donutarray[2]['label'] =$donutarray[2]['label']." ".$totalparticipants."*ppc";

    }else{
        $donutarray=array(
        array('label'=>"ROI",'value'=>0),
    );
    }


    }else{
    $donutarray=array(
        array('label'=>"Total Males",'value'=>0),
        array('label'=>"Total Females",'value'=>0),
        array('label'=>"Total Others",'value'=>0),
        array('label'=>"Total Participants",'value'=>0),
    );


    if(!empty($graphicData)){
    foreach ($graphicData as $i=>$row){
        $donutarray[0]['value'] +=$row['male'];
        $donutarray[1]['value'] +=$row['female'];
        $donutarray[2]['value'] +=$row['other'];
        $donutarray[3]['value'] +=$row['y'];
    }
    }
    }
   $graphicData= $donutarray;
}

     return response()->json([
                'graph' => $graphicData,
            ]);

    }
    public function programcomparisons() {
       $id = request()->id1;
       $id2 = request()->id2;
       $id3 = request()->id3;
       //dd($id,$id2, $id3);

        $authuser = Auth::user();
        $data =  \App\Program::with('user')->whereIn('id',[$id, $id2, $id3])->get();
    //   dd($data);
        $quedata = \App\Programable_question::get();
        $questions = array();
        foreach($quedata as $key => $question){
            $inc = $question->id;
          $questions['question_'.$inc] = $question->question;
        }


    // dd($questions);
        return view('frontend.program.comparison')->with(['data'=>$data,'questions'=>$questions]);
    }

    //frontend podcasts
    public function podcasts($id_encrypted = 0)
    {
        $user_id = get_domain_id();
        $id = !empty($id_encrypted) ? encrypted_key($id_encrypted, 'decrypt') : 0;
        if (!empty($id)) {
            $podcasts = \App\Podcast::where('user_id', $id)->where('parent_episode_id', 0)->get();

            return view('frontend.mentoringtheme.podcasts.search', compact('podcasts', 'id_encrypted'));
        }
        return redirect()->back()->with('error', __('Permission Denied.'));
    }

    //frontend podcasts ajax data
    public function podcastsfilter(Request $request)
    {
        $user_id = !empty($request->id_encrypted) ? encrypted_key($request->id_encrypted, 'decrypt') : 0;
        $date = date('Y-m-d h:m:s');

        $build_query = \App\Podcast::orderBy('id', 'DESC');

        if (!empty($user_id)) {
            $build_query->where('user_id', $user_id);
        }

        if (!empty($request->search)) {
            $build_query->where('title', 'LIKE', '%' . $request->search . '%');
        }

        if (!empty($request->category) && $request->category != 'All') {
            $build_query->where('parent_episode_id', $request->category)->orWhere('id', $request->category);
        }
        if (!empty($request->type)) {
            $build_query->whereIn('type', $request->type);
        }
        if (!empty($request->experience)) {
            $build_query->whereIn('experience_level', $request->experience);
        }
        if (!empty($request->min_amount)) {
            $build_query->where('pay', ">=", $request->min_amount);
        }
        if (!empty($request->max_amount)) {
            $build_query->where('pay', "<=", $request->max_amount);
        }

        if (isset($request->time)) {
            $time = $request->time;
        } else {
            $time = '';
        }
        if (!empty($time)) {
            if (in_array('onemonth', $time)) {
                $timeFormatted = date('Y-m-d h:m:s', strtotime('-1 months', strtotime($date)));
            } elseif (in_array('fourteenday', $time)) {
                $timeFormatted = date('Y-m-d h:m:s', strtotime('-14 days', strtotime($date)));
            } elseif (in_array('sevenday', $time)) {
                $timeFormatted = date('Y-m-d h:m:s', strtotime('-7 days', strtotime($date)));
            } elseif (in_array('oneday', $time)) {
                $timeFormatted = date('Y-m-d h:m:s', strtotime('-1 days', strtotime($date)));
            } elseif (in_array('lasthour', $time)) {
                $timeFormatted = date('Y-m-d h:m:s', strtotime('-1 hours', strtotime($date)));
            }
        }

        if (!empty($timeFormatted)) {
            $build_query->where('created_at', '>=', $timeFormatted);
        }

        $data = $build_query->paginate(6);

        if(count($data)>0){

            foreach($data as $row){

                $row->guestperts=0; //\App\Guestpert::where('podcast_id',$row->id)->count();

            }
        }
          $authuser = !empty(auth()->user()->id) ? auth()->user()->id : 0;

        if (!empty($request->view) && $request->view == 'list') {
            return view('frontend.mentoringtheme.podcasts.FilterList', compact('data','authuser'));
        } else {
            return view('frontend.mentoringtheme.podcasts.FilterGrid', compact('data','authuser'));
        }


//        return view('frontend.pages.podcastsfilter', compact('data'));
    }
     public function podcast_detail($id_encrypted = 0)
    {
        $user_id = get_domain_id();
        $id = !empty($id_encrypted) ? encrypted_key($id_encrypted, 'decrypt') : 0;
        if (!empty($id)) {
        $data = \App\Podcast::where("id", $id)->first();
        $episods =  \App\Podcast::where("parent_episode_id", $data->id)->orderBy('episode','ASC')->get();
        $related=\App\Podcast::where("parent_episode_id", 0)->orderBy(DB::raw('RAND()'))->limit(5)->get();

        return view('frontend.mentoringtheme.podcasts.details', compact('data','user_id','episods','related'));
     }
        return redirect()->back()->with('error', __('Permission Denied.'));
    }
	public function pricing (){

		$user_id = get_domain_id();
		$authuser = Auth::user();
		  $plans = Plan::all();

		  $allPlans = [];
          $duration='';
        foreach ($plans as $_plans) {
            $duration = $_plans['duration'];
            $eachPlans = Plan::where('duration', $duration)->get();
            $allPlans[$duration] = $eachPlans;
        }

        $allDuration = array_keys($allPlans);

        $faqs= Faq::where('category_id',4)->limit(10)->orderBy('created_at','DESC')->get();

		return view('frontend.mentoringtheme.pricing.pricing', compact('user_id', 'authuser','plans','allPlans','allDuration', 'faqs' ,'duration'));
	}

	  public function ownerstripePost(Request $request) {
        $objUser =Auth::user();

        if ($objUser->type != 'admin') {
			$stripe_key=\App\SiteSettings::getValByName('payment_settings');
		if(empty($stripe_key['STRIPE_SECRET'])){
			 return redirect()->back()->with('error', __('Spmething went wrong please try after sometime!'));
		}
            $planID = \Illuminate\Support\Facades\Crypt::decrypt($request->code);
			 $plan = Plan::find($planID);
            $validator = \Validator::make(
                            $request->all(), [
                        'name' => 'required|max:120',
                            ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();
              //  return redirect()->route('payment', $request->code)->with('error', $messages->first());
            }

            if ($plan) {

				if($request->type=='week'){
				$price=$plan->weekly_price;
				}
				elseif($request->type=='month'){
				$price=$plan->monthly_price;
				}
				else{
				$price=	$plan->annually_price;
				}

                try {
                    $type =$request->type;
                    $setupFee = $plan->setup_fee;

                    $price = $setupFee + $price;

                    $orderID = strtoupper(str_replace('.', '', uniqid('', true)));
                    if ($price > 0.0) {
                        Stripe\Stripe::setApiKey($stripe_key['STRIPE_SECRET']);
                        $data = Stripe\Charge::create(
                                        [
                                            "amount" => 100 * $price,
                                            "currency" => strtolower('usd'),
                                            "source" => $request->stripeToken,
                                            "description" => " Plan - " . $plan->name . " (" . $type . ")",
                                            "metadata" => ["order_id" => $orderID],
                                        ]
                        );
                    } else {
                        $data['amount_refunded'] = 0;
                        $data['failure_code'] = '';
                        $data['paid'] = 1;
                        $data['captured'] = 1;
                        $data['status'] = 'succeeded';
                    }
                    if ($data['amount_refunded'] == 0 && empty($data['failure_code']) && $data['paid'] == 1 && $data['captured'] == 1) {
                        $authUser = \Auth::user();

                        $stripe = new \Stripe\StripeClient($stripe_key['STRIPE_SECRET']);
                        $stripe = $stripe->customers->create([
                            'description' => $authUser->name,
                            'email' => $authUser->email,
                            "description" => " Plan - " . $plan->name . " (" . $type . ")",
                            "metadata" => ["order_id" => $orderID],
                        ]);
                        Order::create(
                                [
                                    'order_id' => $orderID,
                                    'name' => $request->name,
                                    'card_number' => $data['payment_method_details']['card']['last4'],
                                    'card_exp_month' => $data['payment_method_details']['card']['exp_month'],
                                    'card_exp_year' => $data['payment_method_details']['card']['exp_year'],
                                    'plan_name' => $plan->name,
                                    'plan_id' => $plan->id,
                                    'type' => $type,
                                    'price' => $price,
                                    'price_currency' => $data['currency'],
                                    'txn_id' => $data['balance_transaction'],
                                    'payment_type' => 'STRIPE',
                                    'payment_status' => $data['status'],
                                    'status' => Order::STATUS_ACTIVE,
                                    'receipt' => $data['receipt_url'],
                                    'user_id' => $objUser->id,
                                    //'parent_id' => $parent->parent_id,
                                    'customer_id' => $stripe->id,
                                ]
                        );

                        if ($data['status'] == 'succeeded' || $data['status'] == 'paid') {
                         $assignPlan = $objUser->assignPlan($plan->id, $type, $stripe->id);

					 if ($assignPlan['is_success']) {
						if (checkPlanModule("subdomain")){
							$role_permissions= get_role_data($objUser->type, "permissions");

							if(in_array("manage_sub_domain", $role_permissions)){

									$sub_name= substr($objUser->name,0,3);
									$sub_number=    rand(10,999);
									$custom_url= $sub_name.$sub_number;
									$domain_data=array(
									'user_id' => $objUser->id
									);

									$domain_data['custom_url']=$custom_url;

								if(!empty($domain_data['custom_url'])){
									\App\UserDomain::create($domain_data);
								}
							}
						}
					 }

                     $userdata= $objUser;
                     $emalbody=[
                        'note'=>'Plan activated Successfully!',
                     ];

                     $resp = \App\Utility::send_emails($userdata->email, $userdata->name, null, $emalbody,'plan_subscription',$userdata);


                               return redirect()->route('home')->with('success', __('Plan activated Successfully!'));
                        } else {
                            $userdata= $objUser;
                            $emalbody=[
                                'note'=>'Your Payment has failed!',

                            ];

                    $resp = \App\Utility::send_emails($userdata->email, $userdata->name, null, $emalbody,'plan_subscription_fail',$userdata);

                            return redirect()->back()->with('error', __('Your Payment has failed!'));
                        }
                    } else {
                        $userdata= $objUser;
                        $emalbody=[
                            'note'=>'Transaction has been failed!',

                        ];

                $resp = \App\Utility::send_emails($userdata->email, $userdata->name, null, $emalbody,'plan_subscription_fail',$userdata);

                        return redirect()->back()->with('error', __('Transaction has been failed!'));
                    }
                } catch (\Exception $e) {
                    return redirect()->back()->with('error', __($e->getMessage()));
                }
            } else {
                return redirect()->back()->with('error', __('Plan is deleted.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission DeniedDenied.'));
        }
	  }


	  public function stripePost(Request $request) {
        $objUser =Auth::user();

        if ($objUser->type != 'admin') {

		 $stripe_key=\App\SiteSettings::getValByName('payment_settings');
		if(empty($stripe_key['STRIPE_SECRET'])){
			 return redirect()->back()->with('error', __('Spmething went wrong please try after sometime!'));
		}
            $planID = $request->code;


            $plan = Plan::find($planID);
         //   $parent = UserContact::where('user_id', $objUser->id)->first();

            $validator = \Validator::make(
                            $request->all(), [
                        'name' => 'required|max:120',
                            ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();
              //  return redirect()->route('payment', $request->code)->with('error', $messages->first());
            }

            if ($plan) {

				if($request->type=='week'){
				$price=$plan->weekly_price;
				}
				elseif($request->type=='month'){
				$price=$plan->monthly_price;
				}
				else{
				$price=	$plan->annually_price;
				}

                try {
                    $type =$request->type;
                    $setupFee = $plan->setup_fee;

                    $price = $setupFee + $price;

                    $orderID = strtoupper(str_replace('.', '', uniqid('', true)));
                    if ($price > 0.0) {
                        Stripe\Stripe::setApiKey($stripe_key['STRIPE_SECRET']);
                        $data = Stripe\Charge::create(
                                        [
                                            "amount" => 100 * $price,
                                            "currency" => strtolower('usd'),
                                            "source" => $request->stripeToken,
                                            "description" => " Plan - " . $plan->name . " (" . $type . ")",
                                            "metadata" => ["order_id" => $orderID],
                                        ]
                        );
                    } else {
                        $data['amount_refunded'] = 0;
                        $data['failure_code'] = '';
                        $data['paid'] = 1;
                        $data['captured'] = 1;
                        $data['status'] = 'succeeded';
                    }
                    if ($data['amount_refunded'] == 0 && empty($data['failure_code']) && $data['paid'] == 1 && $data['captured'] == 1) {
                        $authUser = \Auth::user();
                        $stripe = new \Stripe\StripeClient($stripe_key['STRIPE_SECRET']);
                        $stripe = $stripe->customers->create([
                            'description' => $authUser->name,
                            'email' => $authUser->email,
                            "description" => " Plan - " . $plan->name . " (" . $type . ")",
                            "metadata" => ["order_id" => $orderID],
                        ]);
                        Order::create(
                                [
                                    'order_id' => $orderID,
                                    'name' => $request->name,
                                    'card_number' => $data['payment_method_details']['card']['last4'],
                                    'card_exp_month' => $data['payment_method_details']['card']['exp_month'],
                                    'card_exp_year' => $data['payment_method_details']['card']['exp_year'],
                                    'plan_name' => $plan->name,
                                    'plan_id' => $plan->id,
                                    'type' => $type,
                                    'price' => $price,
                                    'price_currency' => $data['currency'],
                                    'txn_id' => $data['balance_transaction'],
                                    'payment_type' => 'STRIPE',
                                    'payment_status' => $data['status'],
                                    'status' => Order::STATUS_ACTIVE,
                                    'receipt' => $data['receipt_url'],
                                    'user_id' => $objUser->id,
                                    //'parent_id' => $parent->parent_id,
                                    'customer_id' => $stripe->id,
                                ]
                        );

                        if ($data['status'] == 'succeeded' || $data['status'] == 'paid') {
                         $assignPlan = $objUser->assignPlan($plan->id, $type, $stripe->id);


						 if (checkPlanModule("subdomain")){
							$role_permissions= get_role_data($objUser->type, "permissions");

							if(in_array("manage_sub_domain", $role_permissions)){

									$sub_name= substr($objUser->name,0,3);
									$sub_number=    rand(10,999);
									$custom_url= $sub_name.$sub_number;
									$domain_data=array(
									'user_id' => $objUser->id
									);

									$domain_data['custom_url']=$custom_url;

								if(!empty($domain_data['custom_url'])){
									\App\UserDomain::create($domain_data);
								}
							}
						}
                            // if ($assignPlan['is_success']) {
                                // $template_name = "Plan";
                                // $mailTo = $authUser->email;
                                // $uArr = array(
                                    // 'plan' => $plan->name,
                                    // 'username' => $request->name
                                // );


                               // app('App\Http\Controllers\AffiliateController')->enroll_affiliate_points($plan->id, User::TYPE_OWNER);
                                // return redirect()->route('profile')->with('success', __('Plan activated Successfully!'));
                            // } else {
                                // return redirect()->route('profile')->with('error', __($assignPlan['error']));
                            // }
                            return redirect()->route('home')->with('success', __('Plan activated Successfully!'));
                        } else {
                            return redirect()->back()->with('error', __('Your Payment has failed!'));
                        }
                    } else {
                        return redirect()->back()->with('error', __('Transaction has been failed!'));
                    }
                } catch (\Exception $e) {
                    return redirect()->back()->with('error', __($e->getMessage()));
                }
            } else {
                return redirect()->back()->with('error', __('Plan is deleted.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission DeniedDenied.'));
        }
	  }

	  public function planupdte(Request $request){

		 $user = Auth::user();
		   if ($user->type != 'admin') {
                    if (!empty($user->customer_id)) {
                        try {

                            $planID = $request->id;
                            $plan = Plan::find($planID);

							if($request->type=='week'){
							$price=$plan->weekly_price;
							}
							elseif($request->type=='month'){
							$price=$plan->monthly_price;
							}
							else{
							$price=	$plan->annually_price;
							}

							$type=$request->type;

                            $price = $price + $plan->setup_fee;
                            $orderID = strtoupper(str_replace('.', '', uniqid('', true)));
                            if ($price > 0.0) {
                                Stripe\Stripe::setApiKey('sk_test_51IHORWHxbChuDygCqhiXlTJfUIKLVYgOfFgvJAY8zVsnqoseCuxGfEXJVjwnhxOtzX8X1GsfSqIrRrKqYnXeCped000y01xcuJ');
                                $data = Stripe\Charge::create(
                                    [
                                        "amount" => 100 * $price,
                                        "currency" => strtolower('usd'),
                                        "source" => "tok_visa",
                                        "description" => " Plan - " . $plan->name . " (" . $type . ")",
                                        "metadata" => array("cus_id" => $user->customer_id, "name" => $user->name),
                                    ]
                                );
                            } else {
                                $data = [];
                                $data['amount_refunded'] = 0;
                                $data['failure_code'] = '';
                                $data['paid'] = 1;
                                $data['captured'] = 1;
                                $data['status'] = 'succeeded';
                            }
                            if ($data['amount_refunded'] == 0 && empty($data['failure_code']) && $data['paid'] == 1 && $data['captured'] == 1) {
                              $get_order=Order::where('user_id', $user->id)->where('status','Active')->first();
							$orderUpdate=Order::where('id', $get_order->id)->update(['status' => 'Canceled']);
							  $order = Order::create([
                                    'order_id' => $orderID,
                                    'name' => $user->name,
                                    'card_number' => $data['payment_method_details']['card']['last4'],
                                    'card_exp_month' => $data['payment_method_details']['card']['exp_month'],
                                    'card_exp_year' => $data['payment_method_details']['card']['exp_year'],
                                    'plan_name' => $plan->name,
                                    'plan_id' => $plan->id,
                                    'type' => $type,
                                    'price' => $price,
                                    'price_currency' => $data['currency'],
                                    'txn_id' => $data['balance_transaction'],
                                    'payment_type' => 'STRIPE',
                                    'payment_status' => $data['status'],
                                    'status' => Order::STATUS_ACTIVE,
                                    'receipt' => $data['receipt_url'],
                                    'user_id' => $user->id,
                                    'customer_id' => $user->customer_id,
                                ]);
                                if ($data['status'] == 'succeeded') {
                                    $assignPlan = $user->assignPlan($plan->id, $type, $user->customer_id);
                                    if ($assignPlan['is_success']) {

											if (checkPlanModule("subdomain")){
							$role_permissions= get_role_data($user->type, "permissions");

							if(in_array("manage_sub_domain", $role_permissions)){


							$exist=\App\UserDomain::where('user_id', $user->id)->first();
							if(empty($exist)){

									$sub_name= substr($user->name,0,3);
									$sub_number=    rand(10,999);
									$custom_url= $sub_name.$sub_number;
									$domain_data=array(
									'user_id' => $user->id
									);

									$domain_data['custom_url']=$custom_url;

									if(!empty($domain_data['custom_url'])){
										\App\UserDomain::create($domain_data);
									}
								}
							}
						}else{

								\App\UserDomain::where('user_id', $user->id)->delete();
						}
                        $userdata= $user;
                        $emalbody=[
                           'note'=>'Plan activated Successfully!',
                        ];

                    //    $resp = \App\Utility::send_emails($userdata->email, $userdata->name, null, $emalbody,'plan_subscription',$userdata);


                                      return redirect()->route('home')->with('success', __('Plan activated Successfully!'));
                                } else {
                                    $userdata= $user;
                                    $emalbody=[
                                       'note'=>'Your Payment has failed!!',
                                    ];

                                  //  $resp = \App\Utility::send_emails($userdata->email, $userdata->name, null, $emalbody,'plan_subscription',$userdata);

                                     return redirect()->back()->with('error', __('Your Payment has failed!'));
                                }
                            } else {
                                $userdata= $user;
                                $emalbody=[
                                   'note'=>'Transaction has failed!',
                                ];

                             //   $resp = \App\Utility::send_emails($userdata->email, $userdata->name, null, $emalbody,'plan_subscription',$userdata);

                                  return redirect()->back()->with('error', __('Transaction has failed!'));
                            }
							}
                        } catch (\Exception $e) {

                            $suspend_account = User::where('id', $user->id)->update(['plan' => NULL, 'plan_type' => NULL, 'customer_id' => NULL, 'plan_expire_date' => NULL]);
                            if ($suspend_account) {
                               return redirect()->back()->with('error', __($e->getMessage()));

                            }
                        }
                    }
                }
				else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }

	  }

      /**
       * Swag Details
       *
       */
      public function swagdetail(Request $request, $encrypted_id = null)
      {
          $authuser = !empty(auth()->user()->id) ? auth()->user()->id : 0;
          $id = !empty($encrypted_id) ? encrypted_key($encrypted_id, 'decrypt') : 0;
          $user_id = get_domain_id();
          if (!empty($id)) {
              $data = \App\SwagProduct::where("id", $id)->first();
              $build_query = \App\SwagProduct::where('status', 'Published')->orderBy('id', 'DESC');
              if (!empty($user_id)) {
                  $build_query->where('user_id', $user_id);
              }
              $build_query->where('id', '<>', $id);
              $swags = $build_query->paginate(4);

              return view('frontend.mentoringtheme.swag.details', compact('data', 'swags'));
  //            return view('frontend.pages.swagdetail', compact('data', 'swags', 'modules'));
          }
          return redirect()->back()->with('error', __('Permission Denied.'));
      }

      public function finalphoto(Request $request, $id){
        //dd($id);
        $photo_info = Virtualbooth::where('photo_id',$id)->first();
        //dd($photo_info->photo);
        return view('frontend.photobooth.thankyou', compact('photo_info'));


              }
              public function create_photo(Request $request){

//dd($request);
        $base64_encode = $request->file;
        $folderPath = "storage/photobooth";
        // Storage::disk('local')->makeDirectory('photobooth');
        $image_parts = explode(";base64,", $base64_encode);
        //  dd($request);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        $image = "/photobooth" . uniqid() . '.' . $image_type;

        $file = $folderPath . $image;
        file_put_contents($file, $image_base64);
        $update['image'] = $image;
        $path = storage_path('photobooth'.$image);
        $p_id = rand(1111111111,9999999999);
        $insertData = array();
        $insertData['photo_id'] =    $p_id;
        $insertData['event_id'] =    $request->eventId;

        $insertData['photo'] = $file ;

        $inserted = Virtualbooth::create($insertData);
        //dd($inserted);
        return response()->json(array(
            'success' => true,
             'data' => $p_id
        ), 200);
            }
              public function photoboothwebcamera(Request $request,$id){
                $authuser='';
                $eventId = $id;
                $id = encrypted_key($id, 'decrypt') ?? $id;
                $Photoboothimg = VirtualboothEvent::where('id', $id)->where('status','1')->first();
               // $Photobooth = Photobooth::where('type','frame')->where('status','Active')->get();
//dd($id);
              $Photobooth = VirtualboothEventsFrames::where('event_id',$id)->where('type','frame')->where('status','1')->get();
              $Photoboothsticker = VirtualboothEventsFrames::where('event_id',$id)->where('type','sticker')->where('status','1')->get();
              return view('frontend.photobooth.webcamera', compact('eventId','Photoboothsticker','Photoboothimg','authuser','Photobooth'));

            }
	     public function photoboothwebcam(Request $request){
			 $authuser='';
			      $Photobooth = Photobooth::where('status','Active')->get();
			return view('frontend.photobooth.webcam', compact('authuser','Photobooth'));

		 }
            public function photobooth(Request $request){
             $authuser='';
                  $Photobooth = Photobooth::where('status','Active')->get();
            return view('frontend.photobooth.index', compact('authuser','Photobooth'));

         }
         public function photobooths(Request $request){
            $authuser='';
                 $Photobooth = VirtualboothEvent::where('status','1')->get();
                // dd($Photobooth);
           return view('frontend.photobooth.main', compact('authuser','Photobooth'));

        }


	   public function photoboothupload(Request $request)
      {
        $type = null;
//dd($request);
        // if (!isset($request->termcondition)) {
        //     return redirect()->back()->with('error', __('Please select the checkbox.'));
        // }
        if ($request->photo == null &&  $request->file('video') == null ) {
            return redirect()->back()->with('error', __('Please upload the file'));
        }
         $frameId = $request->frame_id;
		if(!empty($request->public_id)){
            $frameId = $request->frame_id;
            if($request->file('video')){
                $type = 'video';
                $file = $request->file('video');
                $filename = $file->getClientOriginalName();
                $path = storage_path('/photobooth');
               // dd($request->public_id);
                 $file->move($path, $filename);
                 $pathnew = storage_path("photobooth/".$filename)."";
//dd( $pathnew);
                 $response = Cloudinary::upload($pathnew, [
                    'resource_type' => 'video',
                    'overlay' => $request->public_id,

                    ])->getSecurePath();
            }
            else{
                $type = 'photo';
                $base64_encode = $request->photo;
                $folderPath = "storage/photobooth";
               // Storage::disk('local')->makeDirectory('photobooth');
                $image_parts = explode(";base64,", $base64_encode);
              //  dd($request);
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_type = $image_type_aux[1];
                $image_base64 = base64_decode($image_parts[1]);
                $image = "/photobooth" . uniqid() . '.' . $image_type;

                $file = $folderPath . $image;
                file_put_contents($file, $image_base64);
                $update['image'] = $image;
                $path = storage_path('photobooth'.$image);
               // $path = Storage::disk('local')->path($image);
              //  dd($path);

		$response = Cloudinary::upload($path, [
		'resource_type' => 'image',
		'overlay' => $request->public_id,

		])->getSecurePath();
        }
		}

     // dd($response);
		if(!empty($response)){
		$craetedPath=$response;
		}
		else{
		$craetedPath='';
		}
			return view('frontend.photobooth.step3', compact(['craetedPath','type','frameId']));
	  }


	   public function photoboothdestory(Request $request)
      {
		  echo"welcome";

		$uploadedFileUrl = Cloudinary::destory($request->public_id);
		//dd($uploadedFileUrl );
	  }

	  public function continue($id=0){

		$id = encrypted_key($id, 'decrypt') ?? $id;

		    $Photobooth = Photobooth::find($id);
		//d($Photobooth);;
		//	    "template" => "template610e896c5b571.png"
   // "public_id" => null

		return view('frontend.photobooth.step2', compact('Photobooth'));
	}

	  public function strip_payment(Request $request)
    {


        $course_id = $request->itemId;
        $checkSyndicate = $request->checkSyndicate;
		  $StripePayment = new StripePayment();
		if($checkSyndicate=='1'){

			  $StripePayment = $StripePayment->makeSyndicatePayment($request);

		}else{
			   $StripePayment = $StripePayment->makePayment($request);
		}


        if ($StripePayment) {

            $notification = array(
                'message' => 'Enroll Complete successfully!',
                'alert-type' => 'success'
            );


                return Redirect::to('/search/courses')->with($notification);

        }
		else{

  return redirect()->back()->with('error', __('Somehthing went wrong.'));
		}
    }

	public function home1 (){
		    $partners = Partner::where('status', 'Active')->get();

		return view('frontend.home1.index', compact('partners'));
	}

	public function home2 (){
		    $partners = Partner::where('status', 'Active')->get();
		return view('frontend.home2.index', compact('partners'));
	}

	public function home3 (){
		    $partners = Partner::where('status', 'Active')->get();
		return view('frontend.home3.index', compact('partners'));
	}

	public function home4 (){
		    $partners = Partner::where('status', 'Active')->get();
		return view('frontend.home4.index', compact('partners'));
	}


        public function sms_web_hook(Request $request)
    {
       try{
     $post=array();
     $post=$_POST;
     if(!empty($post->To) && !empty($post->From)){
     $message = new \App\SmsLog();
     $message['status']=!empty($post->SmsStatus) ? $post->SmsStatus:'';
     $message['from']=!empty($post->From) ? $post->From:'';
     $message['to']=!empty($post->To) ? $post->To:'';
     $message['body']=!empty($post->Body) ? $post->Body:'';
     $message['message_sid']=!empty($post->SmsMessageSid) ? $post->SmsMessageSid:'';
     $message->save();
     }
       } catch (\Exception $ex) {

        }
    return 1;
    }


	  public function wallet_payment(Request $request)
    {


		$price = preg_replace('/[^0-9-.]+/',  '',$request->price);

		  $user = Auth::user();
        $course_id = $request->itemId;
        $makePaymentUsingWallet = new StripePayment();
        $StripePayment = $makePaymentUsingWallet->makePaymentUsingWallet($request);
        if ($makePaymentUsingWallet) {
            //for add commison points to the user
           // $this->user_current($course_id);
            $notification = array(
                'message' => 'Enroll Complete successfully!',
                'alert-type' => 'success'
            );


				$user->wallet_balance=$user->wallet_balance - $price;
             $user->save();




                return Redirect::to('/search/courses')->with($notification);

        }
    }

	//request for file upload
    public function requestfile(Request $request)
    {
        $user_id = get_domain_id();
        $id = base64_decode($request->id);
        $pagedetail = SendDetailsRequest::where('id', $id)->first();
        $UserDetail = User::where('id', $pagedetail->sender)->first();
        return view('frontend.mentoringtheme.requestfile', compact('user_id', 'UserDetail', 'pagedetail'));
    }

    public function requestfilepost(Request $request)
    {
        $RequestMoreInfo = new RequestMoreInfo();
        $RequestMoreInfo = $RequestMoreInfo->storeData($request);
        if ($RequestMoreInfo) {
            return redirect()->route('frontendIndex')->with('success', __('File upload Successfully.'));
        } else {
            return redirect()->back()->with('error', __('File not upload.'));
        }

        $user_id = get_domain_id();
        //Folder

        return redirect()->back()->with('success', __('File upload Successfully.'));
    }

    public function moreinfo(Request $request)
    {
        $user_id = get_domain_id();
        $id = base64_decode($request->id);
        $pagedetail = SendDetailsRequest::where('id', $id)->first();
        $UserDetail = User::where('id', $pagedetail->sender)->first();
        //dd($UserContactDetail);
        return view('frontend.mentoringtheme.moreinfo', compact('user_id', 'UserDetail', 'pagedetail'));
    }

//request for more info

    public function moreinfopost(Request $request)
    {
        if (isset($request->moreinfo) && $request->moreinfo != '') {

        } else {
            return redirect()->back()->with('error', __('Required.'));
        }
        $RequestMoreInfo = new RequestMoreInfo();
        $RequestMoreInfo = $RequestMoreInfo->storeData($request);
        if ($RequestMoreInfo) {
            return redirect()->route('frontendIndex')->with('success', __('Your Information sent Successfully.'));
        } else {
            return redirect()->back()->with('error', __('Your Information not sent.'));
        }
        $user_id = get_domain_id();
        //Folder
        return redirect()->back()->with('success', __('Your Information sent Successfully.'));
    }
    public function contact_us(Request $request){
        //dd($request);
        if ($request->isMethod('post')) {
           $user =  get_domain_user();
          // dd($request);
           if(!empty($user)){
            $ojb = array(
                'name' => $request->name,
                'email' => $request->email,
                'subject' => $request->subject,
                'message' => $request->message,
            );
            $template_name = "Contact Us";

            $resp = \App\Utility::send_emails($user->email, $user->name, null, $ojb,'contact_us',$user);
                return redirect()->back()->with('success', 'Thanks for contacting us!');
           }

        }
    }


}
