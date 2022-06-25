<?php

namespace App\Http\Controllers;

use App\SwagProduct;
use App\SwagOption;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use App\User;
use DataTables;
class SwagController extends Controller {

    public function dashboard($view = 'grid') {
        $user = Auth::user();
       
        $title = "Swag";
        if (isset($_GET['view'])) {
            $view = 'list';
        }
        $opensch= SwagProduct::where('user_id',$user->id)->where('status','Published')->count();
        $closedsch= SwagProduct::where('user_id',$user->id)->where('status','Unpublished')->count();
        $totalsch= SwagProduct::where('user_id',$user->id)->count();
        $totaloptions= SwagOption::where('user_id',$user->id)->count();
        return view('swag.index', compact('view', 'title','opensch','closedsch','totalsch','totaloptions'));
    }
    
    public function create() {
        $user = Auth::user();
        // $teemilapikey=\App\Utility::getValByName("teemill_api_key");
        // if(!empty($teemilapikey)){
        $title = "Create Swag";
        return view('swag.create_form', compact('title'));
        // }else{
        //     return redirect()->back()->with('error', __('Configure your Teemill api key first.'));
        // }
    }


    public function store(Request $request) {
        $user = Auth::user();
        $validation = [
            'title' => 'required|max:500|min:5',
            'description' => 'required|max:1000|min:30'
        ];


        $validator = Validator::make(
                        $request->all(), $validation
        );

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        }
        $id = !empty($request->id) ? encrypted_key($request->id, 'decrypt') : 0;
        if (!empty($id)) {
            try{
            $update = array();
            $data = SwagProduct::find($id);
           $update['title'] = $request->title;
            $update['description'] = $request->description;
            $update['status'] = $request->status;

            if (!empty($request->image)) {
                $base64_encode = $request->image;
                $folderPath = "storage/swags/";
                Storage::disk('local')->makeDirectory('swags');
                $image_parts = explode(";base64,", $base64_encode);
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_type = $image_type_aux[1];
                $image_base64 = base64_decode($image_parts[1]);
                $image = "swag" . uniqid() . '.' . $image_type;
                ;
                $file = $folderPath . $image;
                file_put_contents($file, $image_base64);
                $update['image'] = $image;
            }
            $data->update($update);
              } catch (Exception $ex) {
            return redirect()->back()->with('error', __('Error.'));
            }
            return redirect()->route('swag.dashboard')->with('success', __('Swag updated successfully.'));
//    
        } else {
            try{
            $data = new SwagProduct();
            $data['user_id'] = $user->id;
            $data['title'] = $request->title;
            $data['description'] = $request->description;
            $data['status'] = $request->status;

            if (!empty($request->image)) {
                $base64_encode = $request->image;
                $folderPath = "storage/swags/";
                Storage::disk('local')->makeDirectory('swags');
                $image_parts = explode(";base64,", $base64_encode);
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_type = $image_type_aux[1];
                $image_base64 = base64_decode($image_parts[1]);
                $image = "swag" . uniqid() . '.' . $image_type;
                ;
                $file = $folderPath . $image;
                file_put_contents($file, $image_base64);
                $data['image'] = $image;
            }
            $data->save();
              } catch (Exception $ex) {
            return redirect()->back()->with('error', __('Error.'));
            }
            return redirect()->route('swag.dashboard')->with('success', __('Swag added successfully.'));
        }
    }

    public function view(Request $request) {
        $user = Auth::user();
        $authuser = $user;
        $title = "Swags";
        if ($request->ajax()) {
            $data = SwagProduct::where('user_id', $user->id) //->groupBy('id')
            ->orderBy('id', 'DESC');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('image', function ($data) {
                 
    
                   if(!empty($data->image)){
                  return   '<img src="'.asset('storage/swags').'/'. $data->image .'" class="avatar ">
                 <a class="name mb-0 text-sm text-dark">'. $data->title .' </a>
                '. html_entity_decode(substr($data->description,0,50), ENT_QUOTES, 'UTF-8') .' .....<a href="'.route('swag.details',encrypted_key($data->id,'encrypt')).'"> '.__('See more').'</a> 
                ';
                   }else{

                    return  '<img src="" class="">
                    <a class="name mb-0 text-sm text-dark">'. $data->title .' </a>
                    '. html_entity_decode(substr($data->description,0,50), ENT_QUOTES, 'UTF-8') .' .....<a href="'.route('swag.details',encrypted_key($data->id,'encrypt')).'"> '.__('See more').'</a> 
                    ';           
            }
                })

                ->addColumn('status', function ($data) {
                    if($data->status == 'Open'){
                     return  
                     '<span class="badge badge-sm badge-dot mr-4">
                     <i class=" badge-success"></i>
                    '. $data->status .'
                 </span>' ;
                    }else{
                        
             return '<span class="badge badge-sm badge-dot mr-4">
             <i class=" badge-warning"></i>
            '. $data->status .'
             </span>' ;
                    } 
                })

                ->addColumn('action', function($data){
                    $actionBtn = '
                              <a href="'.route('swag.edit',encrypted_key($data->id,'encrypt')).'" class="action-item px-2" data-toggle="tooltip" data-original-title="'.__('Edit').'">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="javascript::void(0);" class="action-item text-danger px-2 destroyswag" data-id="'.$data->id.'" data-toggle="tooltip" >
                                        <i class="fas fa-trash-alt"></i>
                                    </a>';

                    return $actionBtn;
                })
                ->rawColumns(['action','image','status'])
                ->make(true);
        }else{
            if ($request->ajax() && $request->has('view') && $request->has('sort')) {

                $swags = SwagProduct::groupBy('id')
                        ->orderBy('id', 'DESC');
    
               
                    $swags->where('user_id', $user->id);
              
    
                //sort
                $sort = '';
                switch ($request->sort) {
                    case "all":
                        break;
                    default :
                        $sort = $request->sort;
                        break;
                }
    
                if (!empty($sort)) {
                    $swags->where('status', $sort);
                }
    
    //            //status
    //            if (!empty($request->status)) {
    //                $swags->whereIn('category', $request->status);
    //            }
    
                //keyword
                if (!empty($request->keyword)) {
                    $swags->where('title', 'LIKE', '%' . $request->keyword . '%');
                }
    
                $data = $swags->paginate(6);
              
    
                if (isset($request->view) && $request->view == 'list') {
                    $view = 'list';
                    $returnHTML = view('swag.list', compact('view', 'data', 'title'))->render();
                } else {
                    $view = 'grid';
                    $returnHTML = view('swag.grid', compact('view', 'data', 'title'))->render();
                }
    
                return response()->json(
                                [
                                    'success' => true,
                                    'html' => $returnHTML,
                                ]
                );
            }
        }   
    }
    
//    /**
//     * Show the form for editing the specified resource.
//     *
//     * @param  \App\ServiceRequest  $serviceRequest
//     * @return \Illuminate\Http\Response
//     */
    public function edit($id_encrypted = 0) {
        $user = Auth::user();
        $id = !empty($id_encrypted) ? encrypted_key($id_encrypted, 'decrypt') : 0;
        if (!empty($id)) {
            $title = "Edit Swag";

            $data = SwagProduct::where('id', $id)->where('user_id', $user->id)->first();


            //   echo "<pre>";print_r($blog);die;
            if (!empty($data)) {
                return view('swag.create_form', compact('data', 'title'));
            }
        }
        return redirect()->back()->with('error', __('Permission Denied.'));
    }

//
    public function destroy(Request $request) {
        $user = Auth::user();
        if ($request) {
            $data = SwagProduct::find($request->swag_id);
            $data->delete();
            return redirect()->back()->with('success', __('Swag deleted successfully.'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }
   

//
//   
}
