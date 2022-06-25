<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DataTables;
use DB;
use Config;
use File;

class RewardPointController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
          if ($request->ajax()) {
            $data = \Ansezz\Gamify\Badge::orderBy('id', 'DESC');
       return Datatables::of($data)
                    ->filterColumn('name', function ($query, $keyword) use ($data) {
                        $sql = "name like ?";
                        $query->whereRaw($sql, ["%{$keyword}%"]);
                    })

                ->addColumn('name', function ($data) {
                    return $data->name;
                })
                ->addColumn('description', function ($data) {
                    return $data->description;
                })

                ->addColumn('image', function ($data) {

                if(!empty($data->image)){
                        if(file_exists(storage_path().'/reward_points/'.$data->image)){
                            $url = asset('storage/reward_points/'.$data->image);
                        }else{
                         $url = asset('storage/reward_points/'.$data->image);
                    }
                }else{
                    $url = asset('public/demo.png');
                }
                    return '<img  src="'.$url.'" class="avatar" width="50" height="50">';
                })

                ->addColumn('gamify_group', function ($data) {
                    return DB::table('gamify_groups')->find($data->gamify_group_id)->name;
                })

               ->addColumn('action', function($data){

                $actionBtn = '<div class="actions text-right">
                       <a class="btn btn-sm bg-success-light" href="' . route('badges.edit', encrypted_key($data->id, "encrypt")) . '"  >
                           <i class="fas fa-pencil-alt"></i>
                       </a>

                     </div>';


                    return $actionBtn;
                })
                ->rawColumns(['name','description','image','action'])
                ->make(true);



        }else{
            return view('reward_point.badge_index');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        if($request->isMethod('POST')){
            if(!File::exists(storage_path('reward_points'))) {
                File::makeDirectory(storage_path('reward_points'), 0777, true);
            }

            if(isset($request->submit_type) && isset($request->id) && $request->submit_type == 'update'){
                $data = $request->except('_token','image','submit_type','id');

                if($request->hasFile('image')){
                    $imageName = time().'.'.$request->image->extension();
                    $request->image->move(storage_path('reward_points'), $imageName);
                    $data['image'] = $imageName;
                }

                $data['points'] = $request->points;
                DB::table('badges')->where('id', encrypted_key($request->id,'decrypt'))->update($data);
                return redirect()->route('badges')->with('success', 'Badge Updated Successfully');

            }else{
                $data = $request->except('_token','image');
                if($request->hasFile('image')){
                    $imageName = time().'.'.$request->image->extension();
                    $request->image->move(storage_path('reward_points'), $imageName);
                    $data['image']  = $imageName;
                }

             
                $data['points'] = $request->points;
            
                DB::table('badges')->insert($data);

                // \Ansezz\Gamify\Badge::create($data);
                return redirect()->route('badges')->with('success', 'Badge Created Successfully');
            }

        }else{
            $gamifyGroup = DB::table('gamify_groups')->whereType('badge')->pluck('name','id');
            $levels = Config::get('gamify.badge_levels');
            return view('reward_point.create-badge', compact('gamifyGroup','levels'));
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
        $badgeData =  \Ansezz\Gamify\Badge::whereId(encrypted_key($id,'decrypt'))->first();
        $gamifyGroup = DB::table('gamify_groups')->whereType('badge')->pluck('name','id');
        $levels = Config::get('gamify.badge_levels');
        return view('reward_point.create-badge', compact('gamifyGroup','badgeData','id','levels'));
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


     public function gamifyindex(Request $request) {
        if ($request->ajax()) {
            $data = DB::table('gamify_groups')->orderBy('id', 'DESC');
            return Datatables::of($data)
                    ->filterColumn('name', function ($query, $keyword) use ($data) {
                        $sql = "name like ?";
                        $query->whereRaw($sql, ["%{$keyword}%"]);
                    })

                ->addColumn('name', function ($data) {
                    return $data->name;
                })
                ->addColumn('type', function ($data) {
                    return ($data->type == 'badge') ? 'Badge' : 'Point' ;
                })

               ->addColumn('action', function($data){

                $actionBtn = '<div class="actions text-right">
                       <a class="btn btn-sm bg-success-light" href="' . route('edit.gamify_groups', encrypted_key($data->id, "encrypt")) . '"  >
                           <i class="fas fa-pencil-alt"></i>
                       </a>

                     </div>';


                    return $actionBtn;
                })
                ->rawColumns(['name','description','image','action'])
                ->make(true);



        }else{
            return view('reward_point.gamify_groups');
        }
    }

    public function createGamifyGroup(Request $request){
        if($request->isMethod('post')){
            if(isset($request->id) && isset($request->submit_type) && $request->submit_type == "update"){
                DB::table('gamify_groups')->whereId(encrypted_key($request->id,'decrypt'))->update($request->except('_token','submit_type','id'));
                return redirect()->route('gamify_group')->with('success', 'Gamify Group Updated Successfully');
            }else{
                DB::table('gamify_groups')->create($request->except('_token'));
                return redirect()->route('gamify_group')->with('success', 'Gamify Group Created Successfully');
            }
        }else{
            return view('reward_point.create_gamify_groups');
        }
    }
    public function editGamifyGroup(Request $request, $id){
        $badgeData = DB::table('gamify_groups')->whereId(encrypted_key($id,'decrypt'))->first();
        return view('reward_point.create_gamify_groups', compact('badgeData','id'));
    }

    public function pointindex(Request $request) {
        if ($request->ajax()) {
            $data = \Ansezz\Gamify\Point::orderBy('id', 'DESC');
            return Datatables::of($data)

                    ->filterColumn('name', function ($query, $keyword) use ($data) {
                        $sql = "name like ?";
                        $query->whereRaw($sql, ["%{$keyword}%"]);
                    })

                ->addColumn('name', function ($data) {
                    return $data->name ?? 'NA';
                })
                ->addColumn('point', function ($data) {
                    return $data->point ?? "NA";
                })
                ->addColumn('description', function ($data) {
                    return $data->description ?? "NA";
                })

                ->addColumn('gamify_group', function ($data) {
                    return DB::table('gamify_groups')->find($data->gamify_group_id)->name;
                })
                ->addColumn('allow_duplicate', function ($data) {
                    return ($data->allow_duplicate == 1) ? 'Yes' : 'No';
                })

               ->addColumn('action', function($data){

                $actionBtn = '<div class="actions text-right">
                       <a class="btn btn-sm bg-success-light" href="' . route('edit.points', encrypted_key($data->id, "encrypt")) . '"  >
                           <i class="fas fa-pencil-alt"></i>
                       </a>

                     </div>';


                    return $actionBtn;
                })
                ->rawColumns(['name','point','description','allow_duplicate','action'])
                ->make(true);

        }else{
            return view('reward_point.point_index');
        }
    }

    public function createPoints(Request $request){
        if($request->isMethod('post')){
            if(isset($request->id) && isset($request->submit_type) && $request->submit_type == "update"){
                \Ansezz\Gamify\Point::whereId(encrypted_key($request->id,'decrypt'))->update($request->except('_token','submit_type','id'));
                return redirect()->route('points')->with('success', 'Point Updated Successfully');
            }else{
                \Ansezz\Gamify\Point::create($request->except('_token'));
                return redirect()->route('points')->with('success', 'Point Created Successfully');
            }
        }else{
            $gamifyGroup = DB::table('gamify_groups')->whereType('point')->pluck('name','id');
            return view('reward_point.create_point',compact('gamifyGroup'));
        }
    }
    public function editPoints(Request $request, $id){
        $badgeData = \Ansezz\Gamify\Point::whereId(encrypted_key($id,'decrypt'))->first();
        $gamifyGroup = DB::table('gamify_groups')->whereType('point')->pluck('name','id');
        return view('reward_point.create_point', compact('badgeData','gamifyGroup','id'));
    }

}
