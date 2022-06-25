<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Photobooth;
use App\Photoboothsharecount;
use DataTables;
use Cloudinary;
use Carbon\Carbon;

class PhotoboothController extends Controller
{
    protected $user;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,$view = 'grid')
    {
		
        $user = Auth::user();
        if ($request->ajax()) {  
            $data = Photobooth::all();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('image', function ($data) {
                if(!empty($data->template)){
                    if(file_exists(storage_path().'/photobooth/'.$data->template)){
                     $url = asset('storage/photobooth/'.$data->template);
                    }else{
                        $url = asset('public/demo.png');
                    }
                }else{
                    $url = asset('public/demo.png');
                }
                    return '<img onclick="profile_details('.$data->id.')" src="'.$url.'" class="avatar" width="50" height="50">';
                })->addColumn('title', function ($data) {
                    return $data->title;
                })->addColumn('status', function ($data) {
                    return $data->status;
                })->addColumn('action', function($data){
                    if (Auth::user()->type == 'admin') {
                        
                  
                    $actionBtn ='
                    <a class="btn btn-sm bg-success-light" data-url="' . route('photobooth.edit', encrypted_key($data->id, "encrypt")) . '" data-ajax-popup="true" data-size="md" data-title="Edit Status" href="#">
                    <i class="fas fa-pencil-alt"></i>
                    
                </a>
                <a data-url="' . route('photobooth.destroy',$data->id) . '" href="#" class="btn btn-sm bg-danger-light delete_record_model">
                    <i class="far fa-trash-alt"></i> Delete
                </a>'
                    ;

                    return $actionBtn;
             
            }
            else{
                return 'permission denied';
            }

        })
                ->rawColumns(['action','image'])
                ->make(true);
                return view('photobooth.index');
        }else{

            if(isset($_GET['view'])){
                $view = 'list';
            }
            $partner = Photobooth::all();
    
            return view('photobooth.index', compact('view','partner'));
    
        }   
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function approval_listing_edit($id_enc = 0) {
       $objUser = Auth::user();
        $role_id = !empty($id_enc) ? encrypted_key($id_enc, "decrypt") : 0;
        if ($objUser->type != "admin" || empty($role_id)) {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
       // dd($role_id);
        $data = \App\Photobooth::find($role_id);
     //   dd($data);
        return view('photobooth.status', compact('data'));
    }
     public function boothdata(Request $request)
     {
        $user = Auth::user();
        if ($request->ajax()) {  
            $data = Photobooth::all();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('title', function ($data) {
                    return $data->title;
                })->addColumn('status', function ($data) {
                    return Photoboothsharecount::where('frame_id',$data->id)->where('count',1)->count();
                })->addColumn('twitter', function ($data) {
                   return Photoboothsharecount::where('frame_id',$data->id)->where('count',2)->count();
                })->addColumn('action', function($data){
                    $actionBtn ='<a class="btn btn-sm bg-success-light" href="'. route('photoboothdata.listing', encrypted_key($data->id, 'encrypt')) .'"  >
                    <i class="fa fa-list" aria-hidden="true"></i></a>'
                    ;

                    return $actionBtn;
                })
                ->rawColumns(['action','title','status','twitter'])
                ->make(true);
               
     }
    }
    public function approval_change_status(Request $request) {
        if (Auth::user()->type != 'admin') {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
        //dd($request);
        $id = $request->id;
        $p_id = !empty($id) ? encrypted_key($id, "decrypt") : 0;
        $approval = \App\Photobooth::where('id',$p_id);
     //dd($p_id);
        $data['status'] = $request->status;
       //dd($data);
        $approval->update($data);
     //  dd($approval);

 
       
         return redirect()->route('photobooth.get')->with('success', __('Status Update successfully.'));
    }
    public function photoboothdatalisting($id)
    {
        $id = encrypted_key($id, 'decrypt') ?? $id;

        $boothdashboard = Photoboothsharecount::where('frame_id',$id)->get();
     
       // dd($boothdashboard);
        return view('photobooth.boothdatasingle', compact('boothdashboard'));
    }
    public function boothdashboard()
    {
        $boothdashboard = Photoboothsharecount::get();
      //  dd($boothdashboard);
        return view('photobooth.boothdashboard', compact('boothdashboard'));
    }
     public function create()
    {
            return view('photobooth.create');
    }


		

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		
        $user = Auth::user();
        $custom_url = explode('.', $_SERVER['HTTP_HOST'])[0];
        $validation = [
            'title' => 'required|max:120',
        ];
    
        if($request->hasFile('file'))
        {
            $validation['file'] = 'mimes:jpeg,jpg,png';
        }
    
        $validator = Validator::make(
            $request->all(), $validation
        );
    
        if($validator->fails())
        {
            return redirect()->back()->with('error', $validator->errors()->first());
        }
    
        $Photobooth  = new Photobooth();
       
      
    
        if (!empty($request->file))
        {
  
            $base64_encode = $request->file;
            $folderPath = "storage/photobooth/";
            $image_parts = explode(";base64,", $base64_encode);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $templateName = "template" . uniqid() . '.' . $image_type;
            $Photobooth['template'] = $templateName;
            $file = $folderPath . $templateName;
           file_put_contents($file, $image_base64);
            //  getPublicId(); 
	
				 
        }
        $category_id =  $request->category;
        if($request->type == 'photo'){
            $category_id = NULL;
        }
		$Photobooth['title']        = $request->title;
		$Photobooth['status']     = $request->status;
        $Photobooth['type']     = $request->type;
        $Photobooth['category_id']     = $category_id;

		$Photobooth->save();
		//$last_id=$Photobooth->id;
		//if(!empty($last_id)){
			// $PhotoboothData = Photobooth::find($last_id);
			// $filePath=asset('storage/photobooth/'.$PhotoboothData->template);
			 	//$uploadedFileUrl = Cloudinary::uploadFile($filePath)->getPublicId();
			 // $post['public_id'] = $uploadedFileUrl;
			  // $PhotoboothData->update($post);
			
		//}
	
        return redirect()->back()->with('success', __('Template Upload successfully.'));

    }


 

    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Photobooth = Photobooth::find($id);
        $uploadedFileUrl = Cloudinary::destroy($Photobooth->public_id);
        $Photobooth->delete();
        return redirect()->back()->with('success', __('Template deleted successfully.'));
    }
}
