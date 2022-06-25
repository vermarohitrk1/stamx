<?php

namespace App\Http\Controllers;

use App\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Partner;
use DataTables;
use Carbon\Carbon;

class PartnerController extends Controller
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

            $data = Partner::where('custom_url',get_domain_id());
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('created_at', function ($data) {
                    return [
                        'display' => Carbon::parse($data->created_at)->format('d-m-Y'),
                        'timestamp' => $data->created_at->timestamp
                    ];
                })
                ->addColumn('logo', function ($data) {
                if(!empty($data->logo)){
                    if(file_exists(storage_path().'/partner/'.$data->logo)){
                     $url = asset('storage/partner/'.$data->logo);
                    }else{
                        $url = asset('public/demo.png');
                    }
                }else{
                    $url = asset('public/demo.png');
                }
                    return '<img onclick="profile_details('.$data->id.')" src="'.$url.'" class="avatar" width="50" height="50">';
                })->addColumn('action', function($data){
                    $actionBtn ='<a class="btn btn-sm bg-success-light" data-title="Edit " href="'.url("partner/edit/".$data->id).'">
                    <i class="fas fa-pencil-alt"></i>
                    Edit
                </a>
                <a data-url="' . route('partner.destroy',$data->id) . '" href="#" class="btn btn-sm bg-danger-light delete_record_model">
                    <i class="far fa-trash-alt"></i> Delete
                </a>'
                    ;

                    return $actionBtn;
                })
                ->rawColumns(['action','logo'])
                ->make(true);
                return view('partner.index');
        }else{

            if(isset($_GET['view'])){
                $view = 'list';
            }
            $partner = Partner::all();

            return view('partner.index', compact('view','partner'));


        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function create()
    {
            return view('partner.create');
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
        $domain_id = get_domain_id();
        $validation = [
            'link' => 'required|max:120',
        ];

        if($request->hasFile('logo'))
        {
            $validation['logo'] = 'mimes:jpeg,jpg,png';
        }

        $validator = Validator::make(
            $request->all(), $validation
        );

        if($validator->fails())
        {
            return redirect()->back()->with('error', $validator->errors()->first());
        }

        $partner  = new Partner();
        $partner['link']        = $request->link;
        $partner['status']     = $request->status;
        $partner['custom_url']     = $domain_id;
        $partner['add_to_slider']       = $request->add_to_slider ? $request->add_to_slider : 0 ;

        if (!empty($request->logo))
        {
            // $logo = 'partner' . time() . '.' . $request->logo->getClientOriginalExtension();
            // $request->logo->storeAs('partner', $logo);
            // $partner['logo'] = $logo;
                $base64_encode = $request->logo;
                $folderPath = "storage/partner/";
                $image_parts = explode(";base64,", $base64_encode);
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_type = $image_type_aux[1];
                $image_base64 = base64_decode($image_parts[1]);
                $logoName = "partner" . uniqid() . '.' . $image_type;
                $partner['logo'] = $logoName;
                $file = $folderPath . $logoName;
                file_put_contents($file, $image_base64);
        }

        $partner->save();
        return redirect()->back()->with('success', __('Partner added successfully.'));

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
        $partner = Partner::find($id);
       return view('partner.edit', compact('partner'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        $custom_url = explode('.', $_SERVER['HTTP_HOST'])[0];
        $partner_detail = Partner::find($request->id);
        $partner['link']        = $request->link;
        $partner['status']     = $request->status;
        $partner['add_to_slider']       = $request->add_to_slider;

        if (empty($request->delete_image)){
            if (!empty($request->image))
            {
    			$base64_encode = $request->image;
    			$folderPath = "storage/partner/";
    			$image_parts = explode(";base64,", $base64_encode);
    			$image_type_aux = explode("image/", $image_parts[0]);
    			$image_type = $image_type_aux[1];
    			$image_base64 = base64_decode($image_parts[1]);
    			$logoName = "partner" . uniqid() . '.' . $image_type;
    			$partner['logo'] = $logoName;
    			$file = $folderPath . $logoName;
    			file_put_contents($file, $image_base64);
            }
        }else{
            $partner['logo'] = NULL;
        }
        $partner_detail->update($partner);
        return redirect()->to('partner')->with('success', __(' Partner Updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $partner = Partner::find($id);
        $partner->delete();
        return redirect()->to('partner')->with('success', __('Partner deleted successfully.'));
    }
}
