<?php

namespace App\Http\Controllers;

use App\Podcast;
use App\PodcastFiles;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\User;
use DataTables;
use Aws\S3\S3Client;
use Aws\Exception\AwsException;
class PodcastController extends Controller {

    public function dashboard(Request $request) {
       
        $user = Auth::user(); 
        $title = "Podcast";
      
        if ($request->ajax()) {
            $user = Auth::user();
             $data = Podcast::select('id','title','file','description','image')->orderByDesc('id')->where('user_id', $user->id);
            //         ->groupBy('id');

                    return Datatables::of($data)
                    ->addIndexColumn()
                    ->filterColumn('title', function ($query, $keyword) use ($request) {
                        $sql = "title like ?";
                        $query->whereRaw($sql, ["%{$keyword}%"]);
                    })
                    ->addColumn('title', function ($data) {
                         $col = '<div class="media align-items-center">
                                    <div>
                                        <a href="' . route('podcast_detail' , encrypted_key($data->id, 'encrypt')) . '"
                                           class="">
                                            <img src="'.asset('storage') . '/podcasts/' . $data->image . '" class="avatar">
                                        </a>
                                    </div>
                                    <div class="media-body ml-4">
                                        <a href="' . route('podcast_detail' , encrypted_key($data->id, 'encrypt')) . '"
                                           class="text-black" style="color: black;">
                                            ' . (!empty($data->episode) ? substr("Episode-".$data->episode.": ".$data->title, 0,30) :substr($data->title, 0,30) ). '..
                                        </a>
                                    </div>
                                </div>
                                <br>';
                                if(!empty($data->file) || $data->file != false){
                            $col .= ' <div class="wrapperaudio" id="">
                                  <audio preload="auto" controls>
                                      <source src="'.$data->file.'" />
                                  </audio>
                              </div>';
                                }
                                return $col;
                    })->addColumn('description', function ($data) {
                        return ' <div class="entry-content">
                                        <p style="white-space:pre-wrap; word-wrap:break-word" >'.substr($data->description,0,30).'</p>
                                    </div>';
                    })
                    ->addColumn('action', function ($data) {
                        $authuser = Auth::user();
                        $actionBtn = '<div class="text-right">

                                        <a data-url="' . route('podcast.destroy',encrypted_key($data->id,'encrypt')) . '" href="javascript::void(0);" class="btn btn-sm bg-danger-light delete_record_model">
                    <i class="far fa-trash-alt"></i> Delete</a>
                                        <a href="'.route('podcast.edit',encrypted_key($data->id,'encrypt')).'" class="btn btn-sm bg-success-light mx-1" data-toggle="tooltip" data-original-title="Edit">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>';
                                        if(empty($row->episode)){
                                      $actionBtn .= '<a href="'.route('podcast.addEpisode',encrypted_key($data->id,'encrypt')).'" class="btn btn-sm bg-default-light mx-1" data-toggle="tooltip" data-original-title="Add New Episode">
                                            <i class="fas fa-plus"></i> Episode
                                        </a>';
                                       }
                                    $actionBtn .= '</div>';
                        return $actionBtn;
                    })
                    ->rawColumns(['action', 'title', 'description'])
                    ->make(true);
        }else{
        return view('podcast.index', compact('title'));
        }
    }

    public function create() {
        $user = Auth::user();
        $title = "Create Podcast";
        $podcastfiles = PodcastFiles::where("user_id",$user->id)->get();
        return view('podcast.create_form', compact('title','podcastfiles'));
    }
    public function podcast_files(Request $request) {
      
        $user = Auth::user();
        $title = "Podcast Files";
        if ($request->ajax()) {
            $user = Auth::user();
             $data = PodcastFiles::select('id','file_name','file')->orderBy('id', 'DESC')
                     ->where('user_id', $user->id);

           
            return Datatables::of($data)
                ->addIndexColumn()
                ->filterColumn('file', function ($query, $keyword) use ($request) {
                    $sql = "file_name like ?";
                    $query->whereRaw($sql, ["%{$keyword}%"]);
                })
                ->addColumn('player', function ($data) {
                    if(!empty($data->file) || $data->file== false){
                    return '<div class="wrapperaudio" id=""><audio preload="auto" controls><source src="'.$data->file.'" /></audio>
                  </div>';
                    }else{
                  return '';
                    }
                    })
                ->addColumn('file', function ($data) {
                    return ' <div class="entry-content">
                                <p style="white-space:pre-wrap; word-wrap:break-word" >'.$data->file_name.'</p>
                            </div>';
                })
                ->addColumn('action', function ($data) {
                    $authuser = Auth::user();
                    $actionBtn = '<div class="text-right">
                                  
                                        <a data-url="' . route('podcast.destroyfile',encrypted_key($data->id,'encrypt')) . '" href="javascript::void(0);" class="btn btn-sm bg-danger-light mx-1 delete_record_model">
                    <i class="far fa-trash-alt"></i> Delete</a>
                                        '; $actionBtn .= '</div>';
                   
                                        return $actionBtn;
                })
                ->rawColumns(['action', 'file','player'])
                ->make(true);
        }else{
        return view('podcast.podcast_files', compact('title'));
        }
    }

    public function addepisode($id_encrypted = 0) {
        $user = Auth::user();
        $id = !empty($id_encrypted) ? encrypted_key($id_encrypted, 'decrypt') : 0;
        if (!empty($id)) {
            try{
            $update = array();
            $data = Podcast::find($id);
            $data->id = 0;
            $data->image = '';
            $data->description = '';
            $data->file = '';
            $data->parent_episode_id = $id;
            $last_episode = Podcast::where('parent_episode_id', $id)->orderBy('id','desc')->first() ;
            $data->episode = !empty($last_episode->episode) ? $last_episode->episode +1 :1;

            $title = "Create Podcast Episode";
              } catch (Exception $ex) {
            return redirect()->back()->with('error', __('Error.'));
            }
            $podcastfiles = PodcastFiles::where("user_id",$user->id)->get();
            return view('podcast.create_form', compact('title', 'data','podcastfiles'));
        } else {
            $this->create();
        }
    }

    public function store(Request $request) { 
        $user = Auth::user();
        $validation = [
            'title' => 'required|max:2500|min:5',
            'description' => 'required|max:500|min:30',
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
            $data = Podcast::find($id);
            $update['title'] = $request->title;
            $update['description'] = $request->description;
            $update['parent_episode_id'] = $request->parent_episode_id;
            $update['episode'] = $request->episode;

            if (!empty($request->image)) {
                $base64_encode = $request->image;
                $folderPath = "storage/podcasts/";
                Storage::disk('local')->makeDirectory('podcasts');
                $image_parts = explode(";base64,", $base64_encode);
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_type = $image_type_aux[1];
                $image_base64 = base64_decode($image_parts[1]);
                $image = "podcast" . uniqid() . '.' . $image_type;
                ;
                $file = $folderPath . $image;
                file_put_contents($file, $image_base64);
                $update['image'] = $image;
            }
             if (!empty($request->podcast_file)) {
                $update['file']=$request->podcast_file;
            }
            if (!empty($request->file)) {
                $file = $request->file('file');
                $file_name= time()."-" . $file->getClientOriginalName();
                
                                    $s3Client = new S3Client([
                              'region' => get_aws_s3_bucket_credentials('AWS_DEFAULT_REGION'),
                              'bucket' => get_aws_s3_bucket_credentials('AWS_BUCKET'),
                      'version' => '2006-03-01',
                              'credentials' => [
                          'key'    => get_aws_s3_bucket_credentials('AWS_ACCESS_KEY_ID'),
                          'secret' => get_aws_s3_bucket_credentials('AWS_SECRET_ACCESS_KEY'),
                      ],
                  ]);

                $result = $s3Client->putObject([
                                     'Bucket' => get_aws_s3_bucket_credentials('AWS_BUCKET'),
                                     'Key'    => $file_name,
                                     'SourceFile' => $file,
                                     'ACL'        => 'public-read',
                             ]);
                $update['file']=!empty($result['ObjectURL']) ? $result['ObjectURL'] :'';
              
//                $path = Storage::disk('s3')->put($filePath, fopen($file, 'r+'), 'public');
//
//                if ($path == 1) {
//
//                    $data['file'] = 'https://' . env('AWS_BUCKET') . '.s3.amazonaws.com/' . $filePath;
//                }
//                if ($path == 1) {
//
//                    $update['file'] = 'https://' . env('AWS_BUCKET') . '.s3.amazonaws.com/' . $filePath;
//                }
                
                 $podcastfile = PodcastFiles::where("user_id",$user->id)->where("file",$update['file'])->first();
                 if(empty($podcastfile->id)){
                     $podcastfile = new PodcastFiles();
                      $podcastfile['user_id'] = $user->id;
                        $podcastfile['file_name'] = $file_name;
                        $podcastfile['file'] = $update['file'];
                        $podcastfile->save();
                 }
            }
            $data->update($update);
              } catch (Exception $ex) {
            return redirect()-> back()->with('error', __('Error.'));
            }
            return redirect()->route('podcast.dashboard')->with('success', __('Podcast updated successfully.'));
//    
        } else {
            try{
            $data = new Podcast();
            $data['user_id'] = $user->id;
            $data['title'] = $request->title;
            $data['description'] = $request->description;
            $data['parent_episode_id'] = $request->parent_episode_id;
            $data['episode'] = $request->episode;

            if (!empty($request->image)) {
                $base64_encode = $request->image;
                $folderPath = "storage/podcasts/";
                Storage::disk('local')->makeDirectory('podcasts');
                $image_parts = explode(";base64,", $base64_encode);
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_type = $image_type_aux[1];
                $image_base64 = base64_decode($image_parts[1]);
                $image = "podcast" . uniqid() . '.' . $image_type;
                ;
                $file = $folderPath . $image;
                file_put_contents($file, $image_base64);
                $data['image'] = $image;
            }
            if (!empty($request->podcast_file)) {
                $data['file']=$request->podcast_file;
            }
            if (!empty($request->file)) {
                $file = $request->file('file');
                $file_name= time()."-" . $file->getClientOriginalName();
                if(get_aws_s3_bucket_credentials('AWS_BUCKET') =='' || get_aws_s3_bucket_credentials('AWS_BUCKET') =='' || get_aws_s3_bucket_credentials('AWS_ACCESS_KEY_ID') =='' || get_aws_s3_bucket_credentials('AWS_SECRET_ACCESS_KEY') ==''){
                    return redirect()->back()->with('error', __('Please check your AWS credencials.'));
                }
                    $s3Client = new S3Client([
                              'region' => get_aws_s3_bucket_credentials('AWS_DEFAULT_REGION'),
                              'bucket' => get_aws_s3_bucket_credentials('AWS_BUCKET'),
                      'version' => '2006-03-01',
                              'credentials' => [
                          'key'    => get_aws_s3_bucket_credentials('AWS_ACCESS_KEY_ID'),
                          'secret' => get_aws_s3_bucket_credentials('AWS_SECRET_ACCESS_KEY'),
                      ],
                  ]);

                $result = $s3Client->putObject([
                                     'Bucket' => get_aws_s3_bucket_credentials('AWS_BUCKET'),
                                     'Key'    => $file_name,
                                     'SourceFile' => $file,
                                     'ACL'        => 'public-read',
                             ]);
                $data['file']=!empty($result['ObjectURL']) ? $result['ObjectURL'] :'';
              
//                $path = Storage::disk('s3')->put($filePath, fopen($file, 'r+'), 'public');
//
//                if ($path == 1) {
//
//                    $data['file'] = 'https://' . env('AWS_BUCKET') . '.s3.amazonaws.com/' . $filePath;
//                }
                 $podcastfile = PodcastFiles::where("user_id",$user->id)->where("file",$update['file'])->first();
                 if(empty($podcastfile->id)){
                     $podcastfile = new PodcastFiles();
                      $podcastfile['user_id'] = $user->id;
                      $podcastfile['file_name'] = $file_name;
                        $podcastfile['file'] = $update['file'];
                        $podcastfile->save();
                 }
            }
            //dd($data);
            
            $data->save();
              } catch (Exception $ex) {
            return redirect()->back()->with('error', __('Error.'));
            }
            return redirect()->route('podcast.dashboard')->with('success', __('Podcast added successfully.'));
        }
    }
    public function storefile(Request $request) {
        $user = Auth::user();
        
            try{
             
            if (!empty($request->file)) {
                
                  $request->validate([
                    'file' => 'required|mimes:application/octet-stream,audio/mpeg,mpga,mp3,wav',
                ],['file.mimes' => 'The file type must be an audio']);

                $file = $request->file('file');
                $file_name= time()."-" . $file->getClientOriginalName();
                if(get_aws_s3_bucket_credentials('AWS_BUCKET') =='' || get_aws_s3_bucket_credentials('AWS_BUCKET') =='' || get_aws_s3_bucket_credentials('AWS_ACCESS_KEY_ID') =='' || get_aws_s3_bucket_credentials('AWS_SECRET_ACCESS_KEY') ==''){
                    return redirect()->back()->with('error', __('AWS credencials not configured.'));
                } 
                                    $s3Client = new S3Client([
                              'region' => get_aws_s3_bucket_credentials('AWS_DEFAULT_REGION'),
                              'bucket' => get_aws_s3_bucket_credentials('AWS_BUCKET'),
                      'version' => '2006-03-01',
                              'credentials' => [
                          'key'    => get_aws_s3_bucket_credentials('AWS_ACCESS_KEY_ID'),
                          'secret' => get_aws_s3_bucket_credentials('AWS_SECRET_ACCESS_KEY'),
                      ],
                  ]);

                $result = $s3Client->putObject([
                                     'Bucket' => get_aws_s3_bucket_credentials('AWS_BUCKET'),
                                     'Key'    => $file_name,
                                     'SourceFile' => $file,
                                     'ACL'        => 'public-read',
                             ]);
                $file_url=!empty($result['ObjectURL']) ? $result['ObjectURL'] :'';
              
//                $path = Storage::disk('s3')->put($filePath, fopen($file, 'r+'), 'public');
//
//                if ($path == 1) {
//
//                    $data['file'] = 'https://' . env('AWS_BUCKET') . '.s3.amazonaws.com/' . $filePath;
//                }
                 
                     $podcastfile = new PodcastFiles();
                      $podcastfile['user_id'] = $user->id;
                      $podcastfile['file_name'] = $file_name;
                        $podcastfile['file'] = $file_url;
                        $podcastfile->save();
                 return redirect()->back()->with('success', __('Podcast file added successfully.'));
            }
           
              } catch (Exception $ex) {
            return redirect()->back()->with('error', __('Error.'));
            }
            return redirect()->back()->with('error', __('No file uploaded'));
        
    }

    public function view(Request $request) {
        $user = Auth::user();
        $authuser = $user;
        $title = "Podcasts";
        if ($request->ajax() && $request->has('view') && $request->has('sort')) {

            $podcasts = Podcast::select('id','title','description')->groupBy('id')
                    ->orderBy('id', 'DESC');

            
                $podcasts->where('user_id', $user->id);
           

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
                $podcasts->where('status', $sort);
            }

            //status
            if (!empty($request->status)) {
                $podcasts->whereIn('category', $request->status);
            }

            //keyword
            if (!empty($request->keyword)) {
                $podcasts->where('title', 'LIKE', '%' . $request->keyword . '%');
            }

            $data = $podcasts->paginate(6);
            if (count($data) > 0) {
                foreach ($data as $row) {
                    $row->episodes = Podcast::where('parent_episode_id', $row->id)->count();
                }
            }

            if (isset($request->view) && $request->view == 'list') {
                $view = 'list';
                $returnHTML = view('podcast.list', compact('view', 'data', 'title'))->render();
            } else {
                $view = 'grid';
                $returnHTML = view('podcast.grid', compact('view', 'data', 'title'))->render();
            }

            return response()->json(
                            [
                                'success' => true,
                                'html' => $returnHTML,
                            ]
            );
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
            $title = "Edit Podcast";

            $data = Podcast::where('id', $id)->where('user_id', $user->id)->first();
              $podcastfiles = PodcastFiles::where("user_id",$user->id)->get();
             
            //   echo "<pre>";print_r($blog);die;
            if (!empty($data)) {
                return view('podcast.create_form', compact('data', 'title','podcastfiles'));
            }
        }
        return redirect()->back()->with('error', __('Permission Denied.'));
    }

//
    public function destroy($id) {
        $user = Auth::user();
        $podcast_id =(int) encrypted_key($id,'decrypt');
        if ($podcast_id) {
            $data = Podcast::find($podcast_id);
            $data->delete();
            return redirect()->back()->with('success', __('Podcast deleted successfully.'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }
    public function destroyfile($id) {
        $user = Auth::user();
        $id = !empty($id) ? encrypted_key($id, 'decrypt') : 0;
        if ($id) {
            $data = PodcastFiles::find($id);
            if(!empty($data->file_name)){
                if(get_aws_s3_bucket_credentials('AWS_BUCKET') =='' || get_aws_s3_bucket_credentials('AWS_BUCKET') =='' || get_aws_s3_bucket_credentials('AWS_ACCESS_KEY_ID') =='' || get_aws_s3_bucket_credentials('AWS_SECRET_ACCESS_KEY') ==''){
                    return redirect()->back()->with('error', __('AWS credencials not configured.'));
                }
            $s3Client = new S3Client([
                              'region' => get_aws_s3_bucket_credentials('AWS_DEFAULT_REGION'),
                              'bucket' => get_aws_s3_bucket_credentials('AWS_BUCKET'),
                      'version' => '2006-03-01',
                              'credentials' => [
                          'key'    => get_aws_s3_bucket_credentials('AWS_ACCESS_KEY_ID'),
                          'secret' => get_aws_s3_bucket_credentials('AWS_SECRET_ACCESS_KEY'),
                      ],
                  ]);

                $result = $s3Client->deleteObject([
                                     'Bucket' => get_aws_s3_bucket_credentials('AWS_BUCKET'),
                                     'Key'    => $data->file_name,
                             ]);
            }       
            $data->delete();
            return redirect()->back()->with('success', __('Podcast file deleted successfully.'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

//
//   
}
