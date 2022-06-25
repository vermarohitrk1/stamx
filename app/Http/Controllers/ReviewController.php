<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Crypt;
use App\UserProfileRating;
use App\ProfileRatingReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DataTables;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;


class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      //  dd(Auth::user()->id);
            $data = UserProfileRating::where('profile_id',Auth::user()->id)->with('reply','user')->orderby('id','DESC')->get(); 
 //dd( $data );
    if ($data->isEmpty()) { 
        $data = array();
        return view('reviews.index', compact("data"));
    }
    else{
        return view('reviews.index', compact("data"));
    }

    

        }
        public function addcomment(Request $request)
        {
          //  dd($request);
            $user = Auth::user();
            $comment = new ProfileRatingReply;
            $comment->rating_id = $request->id;
            $comment->user_id = Auth::user()->id;
            $comment->comment = $request->comment;
            $comment->save();

           
         return $comment;
        }
        public function updatecomment(Request $request)
        {
          //  dd($request);
            $user = Auth::user();
            $comment = new ProfileRatingReply;
            $comment->rating_id = $request->id;
            $comment->user_id = Auth::user()->id;
            $comment->comment = $request->comment;
            $comment->save();

           
         return $comment;
        }
        
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function commentdestroy(Request $request)
    {
        

        if(isset($request->replyId)){
          $data =  ProfileRatingReply::where('id',$request->replyId)->delete();
        }else{
            $data =   UserProfileRating::where('id',$request->commentId)->delete();
        }
        

           
         return $data;
    }
}
