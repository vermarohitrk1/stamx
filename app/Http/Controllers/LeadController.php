<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Crypt;
use App\Pathway;
use App\Employer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\User;
use App\CorporateLead;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;
class LeadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->type != 'corporate') {
            return redirect()->back()->with('error', __('Permission Denied.'));
        } 
        return view('leads.index');

    }
    public function myleadmap(Request $request,$name,$id)
    {
        if (Auth::user()->type != 'corporate') {
            return redirect()->back()->with('error', __('Permission Denied.'));
        } 

        if (Auth::user()->type != 'corporate') {
            return redirect()->back()->with('error', __('Permission Denied.'));
        } 
        $color = '';
    if($name == 'college'){

        $color = '#FFC233';
        $college_id = !empty($id) ? encrypted_key($id, "decrypt") : 0;
        $institute = \App\Pathway::where('level',$name)->whereJsonContains($name,json_encode(intval($college_id)))->where('mentor_type','student')->get();
     }
     if( $name == 'school'){
        $color = '#F1B8BD';
        $college_id = !empty($id) ? encrypted_key($id, "decrypt") : 0;
         $institute = \App\Pathway::where('level','K-12')->whereJsonContains($name,json_encode(intval($college_id)))->where('mentor_type','student')->with('user')->get();
     }
     if( $name == 'military'){
        $color = '#A5CEA5';
         $branch = $id;
         $institute = \App\Pathway::where('level',$name)->where('branch', $branch)->where('mentor_type','student')->with('user')->get();
     }
     if( $name == 'veteran'){
        $color = '#9DEAF9';
        $branch = $id;
        $institute = \App\Pathway::where('branch', $branch)->where('mentor_type',$name)->with('user')->get();
    }
    if( $name == 'justice'){
        $color = '#F5D3B2';
       $catalog = !empty($id) ? encrypted_key($id, "decrypt") : 0;
//dd($catalog);
        $institute = \App\Pathway::where('catalog', $catalog)->where('mentor_type',$name)->with('user')->get();
    }
   // dd(  $institute);
   $alladdress = array();
   $content = array();
   //dd($institute);
    foreach($institute as $user){
        $address[$user->user->city] = array();

        $content['content']= $user->user->name . ",". $user->user->address1;
        $address[$user->user->city]['latitude'] = $user->user->address_lat;
        $address[$user->user->city]['longitude'] = $user->user->address_long;
        $address[$user->user->city]['tooltip'] =  $content;
    // $address[$user->user->city]['value'] =  'Value 1';
        // $address[$user->user->city]['type'] =  'image';
        // $address[$user->user->city]['height'] =  12;
        // $address[$user->user->city]['width'] =  40;


         
          $alladdress[$user->user->city] =  $address[$user->user->city];
          

    }

    //dd( $alladdress);
    // "paris": {
    //     latitude: 44.500000,
    //     longitude: -89.500000,
    //     tooltip: {
    //         content: "Paris"
    //     }
    // }
    //dd(json_encode($alladdress));
    // {"ad_id":"14","ad_lat":"40.76525240","ad_lng":"-74.03245470","ad_title":"NEW HONG AM KITCHEN","ad_link":"https:\/\/directoryplus.","count":1}
        return view('leads.myleadmap')->with(['data'=>json_encode($alladdress),'name'=>$name,'color'=>$color,'id'=>$id]);

    }
    public function myleadgrid(Request $request,$name,$id)
    {
        if (Auth::user()->type != 'corporate') {
            return redirect()->back()->with('error', __('Permission Denied.'));
        } 
    if($name == 'college'){
        $college_id = !empty($id) ? encrypted_key($id, "decrypt") : 0;
        $institute = \App\Pathway::where('level',$name)->whereJsonContains($name,json_encode(intval($college_id)))->where('mentor_type','student')->get();
     }
     if( $name == 'school'){
        $college_id = !empty($id) ? encrypted_key($id, "decrypt") : 0;
         $institute = \App\Pathway::where('level','K-12')->whereJsonContains($name,json_encode(intval($college_id)))->where('mentor_type','student')->with('user')->get();
     }
     if( $name == 'military'){
         $branch = $id;
         $institute = \App\Pathway::where('level',$name)->where('branch', $branch)->where('mentor_type','student')->with('user')->get();
     }
     if( $name == 'veteran'){
        $branch = $id;
        $institute = \App\Pathway::where('branch', $branch)->where('mentor_type',$name)->with('user')->get();
    }
    if( $name == 'justice'){
       $catalog = !empty($id) ? encrypted_key($id, "decrypt") : 0;
//dd($catalog);
        $institute = \App\Pathway::where('catalog', $catalog)->where('mentor_type',$name)->with('user')->get();
    }
   // dd($college_id);
        return view('leads.myleadgrid')->with(['data'=>$institute,'name'=>$name,'id'=>$id]);

    }

    public function myleadstudent(Request $request,$name,$id)
    {
        if (Auth::user()->type != 'corporate') {
            return redirect()->back()->with('error', __('Permission Denied.'));
        } 
     

     //  dd($name);
       if($name == 'college'){
        $college_id = !empty($id) ? encrypted_key($id, "decrypt") : 0;
        $institute = \App\Pathway::where('level',$name)->whereJsonContains($name,json_encode(intval($college_id)))->where('mentor_type','student')->get();
     }
     if( $name == 'school'){
        $college_id = !empty($id) ? encrypted_key($id, "decrypt") : 0;
         $institute = \App\Pathway::where('level','K-12')->whereJsonContains($name,json_encode(intval($college_id)))->where('mentor_type','student')->with('user')->get();
     }
     if( $name == 'military'){
         $branch = $id;
        // dd( $branch);
         $institute = \App\Pathway::where('level',$name)->where('branch', $branch)->where('mentor_type','student')->with('user')->get();
     }
     if( $name == 'veteran'){
        $branch = $id;
       // dd( $branch);
        $institute = \App\Pathway::where('branch', $branch)->where('mentor_type',$name)->with('user')->get();
    }
    if( $name == 'justice'){
       $catalog = !empty($id) ? encrypted_key($id, "decrypt") : 0;

        $institute = \App\Pathway::where('catalog', $catalog)->where('mentor_type',$name)->with('user')->get();
        //dd($institute);
   
    }
//dd($institute);


       if ($request->ajax()) { 
        if($name == 'college'){
            $college_id = !empty($id) ? encrypted_key($id, "decrypt") : 0;
            $data = \App\Pathway::where('level',$name)->whereJsonContains($name,json_encode(intval($college_id)))->where('mentor_type','student')->with('user');
         }
         if( $name == 'school'){
            $college_id = !empty($id) ? encrypted_key($id, "decrypt") : 0;
             $data = \App\Pathway::where('level','K-12')->whereJsonContains($name,json_encode(intval($college_id)))->where('mentor_type','student')->with('user');
         }
         if( $name == 'military'){
             $branch = $id;
             $data = \App\Pathway::where('level',$name)->where('branch', $branch)->where('mentor_type','student')->with('user');
         }
         if( $name == 'veteran'){
            $branch = $id;
            $data = \App\Pathway::where('branch', $branch)->where('mentor_type',$name)->with('user');
        }
        if( $name == 'justice'){
           $catalog = !empty($id) ? encrypted_key($id, "decrypt") : 0;
    //dd($catalog);
            $data = \App\Pathway::where('catalog', $catalog)->where('mentor_type',$name)->with('user');
        } 
        return Datatables::of($data)
        
        //    ->addColumn('avatar', function ($data) {
        //     return '<img height="100" width="100" class="rounded-circle" alt="User Image" src="{{$data->user->getAvatarUrl()}}">';
        //         return $data->user->avatar;
        //     })
            ->addColumn('name', function ($data) {
                return $data->user->name;
               
            })
            ->addColumn('email', function ($data) {
                return $data->user->email;
            })
           
            ->addColumn('address', function ($data) {
                return $data->user->address1;
               
            })
            ->addColumn('city', function ($data) {
                return $data->user->city;
               
            })

           
            ->addColumn('state', function ($data) {
                return $data->user->state;
               
            })
           ->addColumn('createddate', function ($data) {
                    return \App\Utility::getDateFormated($data->created_at);
                })

          
              ->addColumn('action', function($data){
                
                   $actionBtn = '<div class="actions text-right">
                   <a class="btn btn-sm bg-success-light" data-ajax-popup="true" data-size="md" data-title="User Profile" data-url="' . route('lead.myleaduserprofile', encrypted_key($data->id, "encrypt")) . '">
                                        Profile <i class="fas fa-eye"></i>
                                            </a>
                                            <a style="margin-top:5px;" class="btn btn-sm bg-success-light"  href="'.route('pathwaytimeline.show', encrypted_key($data->id, "encrypt")).'">
                                              Timeline
                                            </a>
                                        </div>';
                
          
                return $actionBtn;
            })
            ->rawColumns(['action','name','email','address','lead','city','state','createddate'])
            ->make(true);     
           


   }else{
        return view('leads.mylead')->with(['institute'=>$institute,'name'=> $name,'id'=>$id]);

   }
    

    }
    
    public function myleaduserprofile($id)
    {
       
        $id = !empty($id) ? encrypted_key($id, "decrypt") : 0;
        $data = \App\Pathway::where('id', $id)->with('user')->first();

        return view('leads.myleaduserprofile')->with(['data'=>$data]);

    }
    public function mylead(Request $request)
    {
        if (Auth::user()->type != 'corporate') {
            return redirect()->back()->with('error', __('Permission Denied.'));
        } 

       $college = CorporateLead::where('type','college')->where('status',1)->where('user_id',Auth::user()->id)->with('institution')->get();
       $school = CorporateLead::where('type','school')->where('status',1)->where('user_id',Auth::user()->id)->with('institution')->get();
       $military = CorporateLead::where('type','military')->where('status',1)->where('user_id',Auth::user()->id)->get();
       $veteran = CorporateLead::where('type','veteran')->where('status',1)->where('user_id',Auth::user()->id)->get();
       $course = CorporateLead::where('type','justice')->where('status',1)->where('user_id',Auth::user()->id)->with('course')->get();

      // dd($course);

    //    if ($request->ajax()) { 
    //     $data = CorporateLead::where('status',1)->where('user_id',Auth::user()->id)->with('user')->orderBy('id', 'DESC');
 
    //     return Datatables::of($data)
        
    //        ->addColumn('avatar', function ($data) {
    //         return '<img height="100" width="100" class="rounded-circle" alt="User Image" src="{{$data->user->getAvatarUrl()}}">';
    //             return $data->user->avatar;
    //         })
    //         ->addColumn('name', function ($data) {
    //             return $data->user->name;
               
    //         })
    //         ->addColumn('email', function ($data) {
    //             return $data->user->email;
    //         })
            // ->addColumn('college', function ($data) {
               
            //    $institute = \App\Pathway::where('level','college')->where('user_id',$data->user->id)->where('mentor_type','student')->first();
              
            //    $college = \App\Institution::whereIn('id',json_decode($institute->college,true))->get();
            //   $name =array();
            //   foreach($college as $key => $colleges){
            //     $name[] = $colleges->institution;
            //  }
            //  return $name;
            // })
            // ->addColumn('address', function ($data) {
            //     return $data->user->address1;
               
            // })
            // ->addColumn('city', function ($data) {
            //     return $data->user->city;
               
            // })

           
            // ->addColumn('state', function ($data) {
            //     return $data->user->state;
               
            // })

          
            //   ->addColumn('action', function($data){
                
            //        $actionBtn = '<div class="actions text-right">
            //                              <a class="btn btn-sm bg-success-light" data-title="Edit Category" href="'.url("pathway/show/".encrypted_key($data->id,'encrypt')).'">
            //                                     <i class="fas fa-eye"></i>
            //                                 </a>
                                            
            //                             </div>';
                
          
            //     return $actionBtn;
            // })
            // ->rawColumns(['action','avatar','name','email','address','lead'])
            // ->make(true);     
           


  //  }else{
        return view('leads.myleadprofile')->with(['college'=>$college,'school'=>$school,'military'=>$military,'veteran'=>$veteran,'course'=>$course]);

  //  }
    

    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function militarylist(Request $request)
    {
      if (Auth::user()->type != 'corporate') {
            return redirect()->back()->with('error', __('Permission Denied.'));
        } 
        $lead = CorporateLead::where('type','military')->where('status',1)->where('user_id',Auth::user()->id)->get();

    // dd($lead);
        return view('leads.militarylist')->with('lead',$lead);

    
       
    }

    public function veteranlist(Request $request)
    {
        if (Auth::user()->type != 'corporate') {
            return redirect()->back()->with('error', __('Permission Denied.'));
        } 
        $lead = CorporateLead::where('type','veteran')->where('status',1)->where('user_id',Auth::user()->id)->get();

     
        return view('leads.veteranlist')->with('lead',$lead);

    
       
    }
    public function justicelist(Request $request)
    {
        if (Auth::user()->type != 'corporate') {
            return redirect()->back()->with('error', __('Permission Denied.'));
        } 
        $apprentice_cat_id = \App\CertifyCategory::select('*')->where('name','Apprenticeship')->first();
//dd($apprentice_cat_id);
      $data =  \App\Certify::orderBy('id', 'DESC')->where('category',$apprentice_cat_id->id)->get();
      $lead = CorporateLead::where('type','justice')->where('user_id',Auth::user()->id)->get();

    // dd($data);
        return view('leads.justicelist')->with(['data'=>$data,'lead'=>$lead]);

    
       
    }

    public function collegelist(Request $request)
    {
       // dd(Auth::user()->type);
       $name= "college";
    
        if (Auth::user()->type != 'corporate') {
            return redirect()->back()->with('error', __('Permission Denied.'));
        } 
      
        $data =  \App\Institution::where('type',$name)->get();
       if ($request->ajax()) { 
      //  dd( $name);
        $data =  \App\Institution::where('type',$name)->select('id','institution','type','address')->orderBy('id', 'DESC');

  
        return Datatables::of($data)
        ->filterColumn('institution', function ($query, $keyword) use ($request) {
            $sql = "institution like ?";
            $query->whereRaw($sql, ["%{$keyword}%"]);
        })
        ->filterColumn('address', function ($query, $keyword) use ($request) {
            $sql = "address like ?";
            $query->whereRaw($sql, ["%{$keyword}%"]);
        })

            ->addColumn('institution', function ($data) {
                return $data->institution;
               
            })
             ->addColumn('address', function ($data) {
                return $data->address;
               
            })
         ->addColumn('action', function($data){
            $lead = CorporateLead::where('corporate_id',$data->id)->where('user_id',Auth::user()->id)->first();
          
            $ids = $data->id;
            $college_id = !empty($ids) ? encrypted_key($ids, "encrypt") : 0;

            if( $lead != null){
                $stataus = '';
                if( $lead->status ==1){
                    $stataus = 'checked';
                }
                $actionBtn = '<div class="status-toggle">
                <input type="checkbox" id="status_'.$data->id.'" data-type="college" data-sid="'.$lead->id.'"  data-corporate="'.$data->id.'" class="check checklead" '.$stataus.'  value="1">
                <label for="status_'.$data->id.'" class="checktoggle">checkbox</label>
                </div>';
            }
            else{
                $actionBtn = '<div class="status-toggle">
                <input type="checkbox" id="status_'.$data->id.'" data-type="college" data-sid="0" data-corporate="'.$data->id.'" class="check checklead"  value="1">
                <label for="status_'.$data->id.'" class="checktoggle">checkbox</label>
                </div>';
            }
                  
                
          
                return $actionBtn;
            })
            ->rawColumns(['action','avatar','name','email','address','lead'])
            ->make(true);     
           


    }else{
        return view('leads.mainlist')->with(['data'=>$data,'name'=>$name]);

    }
       
    }

    public function justiceuser(Request $request)
    {
        if (Auth::user()->type != 'corporate') {
               return redirect()->back()->with('error', __('Permission Denied.'));
           } 
        // dd($name);
          $data =  Pathway::where( 'mentor_type', 'justice')->get();
          //dd( $data);
          if ($request->ajax()) { 
           $data = Pathway::select('*')->where( 'mentor_type', 'justice')->with('user')->orderBy('id', 'DESC');
    
           return Datatables::of($data)
              ->addColumn('avatar', function ($data) {
               return '<img height="100" width="100" class="rounded-circle" alt="User Image" src="{{$data->user->getAvatarUrl()}}">';
                   return $data->user->avatar;
               })
               ->addColumn('name', function ($data) {
                   return $data->user->name;
                  
               })
               ->addColumn('email', function ($data) {
                   return $data->user->email;
               })
              
               ->addColumn('address', function ($data) {
                   return $data->user->address1;
                  
               })
   
               ->addColumn('lead', function ($data) {
                  // return Auth::user()->id;
                   $status =  CorporateLead::where('user_id',$data->user->id)->where('corporate_id',Auth::user()->id)->first();
                 //return $status;
                   if($status== ''){
                      return '<div class="status-toggle">
                    <input type="checkbox" id="status_1" data-type="justice" data-id ="0" data-user="'. $data->user->id .'" data-corporate="'. Auth::user()->id .'"class="check checklead" value="1" >
                    <label for="status_1" class="checktoggle">checkbox</label>
                    </div>';
                  }
                  else{
                      if($status->status == 1){
                       return '<div class="status-toggle">
                       <input type="checkbox" id="status_1" data-type="justice" data-id ="'.$status->id.'" data-user="'. $data->user->id .'" data-corporate="'. Auth::user()->id .'" class="check checklead" checked="" value="1">
                       <label for="status_1" class="checktoggle">checkbox</label>
                       </div>';
                      }
                      else{
                       return '<div class="status-toggle">
                       <input type="checkbox" id="status_1" data-type="justice" data-id ="'.$status->id.'" data-user="'. $data->user->id .'" data-corporate="'. Auth::user()->id .'" class="check checklead" value="1">
                       <label for="status_1" class="checktoggle">checkbox</label>
                       </div>';
   
                      }
                  }
                 })
                 ->addColumn('action', function($data){
                   
                      $actionBtn = '<div class="actions text-right">
                                            <a class="btn btn-sm bg-success-light" data-title="Edit Category" href="'.url("pathway/show/".encrypted_key($data->id,'encrypt')).'">
                                                   <i class="fas fa-eye"></i>
                                               </a>
                                               
                                           </div>';
                   
             
                   return $actionBtn;
               })
               ->rawColumns(['action','avatar','name','email','address','lead'])
               ->make(true);     
              
   
   
       }else{
           return view('leads.justiceuser')->with(['data'=>$data]);
   
       }
          
        
    }


    public function veteranuser(Request $request)
    {
        if (Auth::user()->type != 'corporate') {
               return redirect()->back()->with('error', __('Permission Denied.'));
           } 
        // dd($name);
          $data =  Pathway::where( 'mentor_type', 'veteran')->get();
          //dd( $data);
          if ($request->ajax()) { 
           $data = Pathway::select('*')->where( 'mentor_type', 'veteran')->with('user')->orderBy('id', 'DESC');
    
           return Datatables::of($data)
              ->addColumn('avatar', function ($data) {
               return '<img height="100" width="100" class="rounded-circle" alt="User Image" src="{{$data->user->getAvatarUrl()}}">';
                   return $data->user->avatar;
               })
               ->addColumn('name', function ($data) {
                   return $data->user->name;
                  
               })
               ->addColumn('email', function ($data) {
                   return $data->user->email;
               })
              
               ->addColumn('address', function ($data) {
                   return $data->user->address1;
                  
               })
   
               ->addColumn('lead', function ($data) {
                  // return Auth::user()->id;
                   $status =  CorporateLead::where('user_id',$data->user->id)->where('corporate_id',Auth::user()->id)->first();
                 //return $status;
                   if($status== ''){
                      return '<div class="status-toggle">
                    <input type="checkbox" id="status_1" data-type="veteran" data-id ="0" data-user="'. $data->user->id .'" data-corporate="'. Auth::user()->id .'"class="check checklead" value="1" >
                    <label for="status_1" class="checktoggle">checkbox</label>
                    </div>';
                  }
                  else{
                      if($status->status == 1){
                       return '<div class="status-toggle">
                       <input type="checkbox" id="status_1" data-type="veteran" data-id ="'.$status->id.'" data-user="'. $data->user->id .'" data-corporate="'. Auth::user()->id .'" class="check checklead" checked="" value="1">
                       <label for="status_1" class="checktoggle">checkbox</label>
                       </div>';
                      }
                      else{
                       return '<div class="status-toggle">
                       <input type="checkbox" id="status_1" data-type="veteran" data-id ="'.$status->id.'" data-user="'. $data->user->id .'" data-corporate="'. Auth::user()->id .'" class="check checklead" value="1">
                       <label for="status_1" class="checktoggle">checkbox</label>
                       </div>';
   
                      }
                  }
                 })
                 ->addColumn('action', function($data){
                   
                      $actionBtn = '<div class="actions text-right">
                                            <a class="btn btn-sm bg-success-light" data-title="Edit Category" href="'.url("pathway/show/".encrypted_key($data->id,'encrypt')).'">
                                                   <i class="fas fa-eye"></i>
                                               </a>
                                               
                                           </div>';
                   
             
                   return $actionBtn;
               })
               ->rawColumns(['action','avatar','name','email','address','lead'])
               ->make(true);     
              
   
   
       }else{
           return view('leads.veteranuser')->with(['data'=>$data]);
   
       }
          
        
    }


    public function militaryuser(Request $request)
    {
        if (Auth::user()->type != 'corporate') {
               return redirect()->back()->with('error', __('Permission Denied.'));
           } 
        // dd($name);
          $data =  Pathway::where( 'level', 'military')->get();
          //dd( $data);
          if ($request->ajax()) { 
           $data = Pathway::select('*')->where( 'level', 'military')->with('user')->orderBy('id', 'DESC');
    // dd( $data );
           return Datatables::of($data)
              ->addColumn('avatar', function ($data) {
               return '<img height="100" width="100" class="rounded-circle" alt="User Image" src="{{$data->user->getAvatarUrl()}}">';
                   return $data->user->avatar;
               })
               ->addColumn('name', function ($data) {
                   return $data->user->name;
                  
               })
               ->addColumn('email', function ($data) {
                   return $data->user->email;
               })
              
               ->addColumn('address', function ($data) {
                   return $data->user->address1;
                  
               })
   
               ->addColumn('lead', function ($data) {
                  // return Auth::user()->id;
                   $status =  CorporateLead::where('user_id',$data->user->id)->where('corporate_id',Auth::user()->id)->first();
                 //return $status;
                   if($status== ''){
                      return '<div class="status-toggle">
                    <input type="checkbox" id="status_1" data-type="military" data-id ="0" data-user="'. $data->user->id .'" data-corporate="'. Auth::user()->id .'"class="check checklead" value="1" >
                    <label for="status_1" class="checktoggle">checkbox</label>
                    </div>';
                  }
                  else{
                      if($status->status == 1){
                       return '<div class="status-toggle">
                       <input type="checkbox" id="status_1" data-type="military" data-id ="'.$status->id.'" data-user="'. $data->user->id .'" data-corporate="'. Auth::user()->id .'" class="check checklead" checked="" value="1">
                       <label for="status_1" class="checktoggle">checkbox</label>
                       </div>';
                      }
                      else{
                       return '<div class="status-toggle">
                       <input type="checkbox" id="status_1" data-type="military" data-id ="'.$status->id.'" data-user="'. $data->user->id .'" data-corporate="'. Auth::user()->id .'" class="check checklead" value="1">
                       <label for="status_1" class="checktoggle">checkbox</label>
                       </div>';
   
                      }
                  }
                 })
                 ->addColumn('action', function($data){
                   
                      $actionBtn = '<div class="actions text-right">
                                            <a class="btn btn-sm bg-success-light" data-title="Edit Category" href="'.url("pathway/show/".encrypted_key($data->id,'encrypt')).'">
                                                   <i class="fas fa-eye"></i>
                                               </a>
                                               
                                           </div>';
                   
             
                   return $actionBtn;
               })
               ->rawColumns(['action','avatar','name','email','address','lead'])
               ->make(true);     
              
   
   
       }else{
           return view('leads.militaryuser')->with(['data'=>$data]);
   
       }
          
        
    }
    public function schoollist(Request $request)
    {
       // dd(Auth::user()->type);
  
        if (Auth::user()->type != 'corporate') {
            return redirect()->back()->with('error', __('Permission Denied.'));
        } 
        $name="school";
        $data =  \App\Institution::where('type',$name)->get();
       if ($request->ajax()) { 
      //  dd( $name);
        $data =  \App\Institution::where('type',$name)->select('id','institution','type','address')->orderBy('id', 'DESC');

  
        return Datatables::of($data)
       

            ->addColumn('institution', function ($data) {
                return $data->institution;
               
            })
             ->addColumn('address', function ($data) {
                return $data->address;
               
            })
            ->addColumn('action', function($data){
                $lead = CorporateLead::where('corporate_id',$data->id)->where('user_id',Auth::user()->id)->first();
              
                $ids = $data->id;
                $college_id = !empty($ids) ? encrypted_key($ids, "encrypt") : 0;
    
                if( $lead != null){
                    $stataus = '';
                    if( $lead->status ==1){
                        $stataus = 'checked';
                    }
                    $actionBtn = '<div class="status-toggle">
                    <input type="checkbox" id="status_'.$data->id.'" data-type="school" data-sid="'.$lead->id.'"  data-corporate="'.$data->id.'" class="check checklead" '.$stataus.'  value="1">
                    <label for="status_'.$data->id.'" class="checktoggle">checkbox</label>
                    </div>';
                }
                else{
                    $actionBtn = '<div class="status-toggle">
                    <input type="checkbox" id="status_'.$data->id.'" data-type="school" data-sid="0" data-corporate="'.$data->id.'" class="check checklead"  value="1">
                    <label for="status_'.$data->id.'" class="checktoggle">checkbox</label>
                    </div>';
                }
                      
                    
              
                    return $actionBtn;
                })
            ->rawColumns(['action','avatar','name','email','address','lead'])
            ->make(true);     
           


    }else{
        return view('leads.mainlist')->with(['data'=>$data,'name'=>$name]);

    }
       
    }
    public function subList(Request $request, $name,$collegeId)
    {
      //  dd($collegeId);
      $college_id = !empty($collegeId) ? encrypted_key($collegeId, "decrypt") : 0;
     // dd($college_id);
     //$college_id=4;
        if (Auth::user()->type != 'corporate') {
            return redirect()->back()->with('error', __('Permission Denied.'));
        } 
        $label = 'level';
        $name2 = $name;
        if($name == 'school'){
           $name2 = 'K-12';
        }
        if($name == 'veteran'){
            $label = 'mentor_type';
        }
        if($name == 'justice'){
            $label = 'mentor_type';
        }
        
       $data =  Pathway::where( $label, $name2)->whereJsonContains($name,json_encode(intval($college_id)))->with('user')->get();
       //dd( $data);
       if ($request->ajax()) { 
        $data = Pathway::select('*')->where( $label, $name2)->whereJsonContains($name,json_encode(intval($college_id)))->with('user')->orderBy('id', 'DESC');
 // dd( $data );
        return Datatables::of($data)
           ->addColumn('avatar', function ($data) {
            return '<img height="100" width="100" class="rounded-circle" alt="User Image" src="{{$data->user->getAvatarUrl()}}">';
                return $data->user->avatar;
            })
            ->addColumn('name', function ($data) {
                return $data->user->name;
               
            })
            ->addColumn('email', function ($data) {
                return $data->user->email;
            })
           
            ->addColumn('address', function ($data) {
                return $data->user->address1;
               
            })

            ->addColumn('lead', function ($data) {
               // return Auth::user()->id;
                $status =  CorporateLead::where('user_id',$data->user->id)->where('corporate_id',Auth::user()->id)->first();
              //return $status;
                if($status== ''){
                   return '<div class="status-toggle">
                 <input type="checkbox" id="status_1" data-id ="0" data-type="'.$data->level.'" data-user="'. $data->user->id .'" data-corporate="'. Auth::user()->id .'"class="check checklead" value="1" >
                 <label for="status_1" class="checktoggle">checkbox</label>
                 </div>';
               }
               else{
                   if($status->status == 1){
                    return '<div class="status-toggle">
                    <input type="checkbox" id="status_1" data-type="'.$data->level.'" data-id ="'.$status->id.'" data-user="'. $data->user->id .'" data-corporate="'. Auth::user()->id .'" class="check checklead" checked="" value="1">
                    <label for="status_1" class="checktoggle">checkbox</label>
                    </div>';
                   }
                   else{
                    return '<div class="status-toggle">
                    <input type="checkbox" id="status_1" data-type="'.$data->level.'" data-id ="'.$status->id.'" data-user="'. $data->user->id .'" data-corporate="'. Auth::user()->id .'" class="check checklead" value="1">
                    <label for="status_1" class="checktoggle">checkbox</label>
                    </div>';

                   }
                
               }
               
              
               
            })

            
         
          ->addColumn('action', function($data){
                
                   $actionBtn = '<div class="actions text-right">
                                         <a class="btn btn-sm bg-success-light" data-title="Edit Category" href="'.url("pathway/show/".encrypted_key($data->id,'encrypt')).'">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            
                                        </div>';
                
          
                return $actionBtn;
            })
            ->rawColumns(['action','avatar','name','email','address','lead'])
            ->make(true);     
           


    }else{
        return view('leads.list')->with(['data'=>$data,'name'=>$name,'collegeId'=>$collegeId]);

    }
       
    }
    public function change_status(Request $request) {
      //  dd($request);
        $user = Auth::user();
        if ($request->ajax()) {
           $type = $request->type;
           
           if($request->type =='K-12'){
            $type ='school';
            }
            
            if($request->sid == 0){
                $lead = new CorporateLead;
                $lead->corporate_id=$request->corporateid;
                $lead->user_id=$user->id;
                $lead->status=$request->status;
                $lead->type=$type;
                $lead->save();
            }
            else{
                $lead = CorporateLead::find($request->sid);
                $lead->status = $request->status;
               $lead->update();

            }
         

            return response()->json(
                            [
                                'success' => true,
                                'html' => 'success',
                            ]
            );
        }
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
    public function destroy($id)
    {
        //
    }
}
