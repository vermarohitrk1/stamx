<?php

namespace App\Http\Controllers;
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Education;
use DataTables;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;



class EducationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $authuser = Auth::user();
     
    
        if ($request->ajax()) { 
            $data = Education::select('*')->orderBy('id', 'DESC');
       return Datatables::of($data)
                ->addColumn('education', function ($data) {
                    return $data->education;
                })
               ->addColumn('action', function($data){
                    
                $actionBtn = '<div class="actions text-right">
                       <a class="btn btn-sm bg-success-light" data-url="' . route('educations.edit', encrypted_key($data->id, "encrypt")) . '" data-ajax-popup="true" data-size="md" data-title="Edit Education" href="#">
                           <i class="fas fa-pencil-alt"></i>
                       </a>
                         <a data-url="' . route('educations.destroy', encrypted_key($data->id, "encrypt")) . '" href="#" class="btn btn-sm bg-danger-light delete_record_model">
                             <i class="far fa-trash-alt"></i> Delete
                         </a>
                     </div>';
                    
              
                    return $actionBtn;
                })
                ->rawColumns(['education','action'])
                ->make(true);     
               


        }else{
            
      
            return view('education.index');
        }
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
       // dd($request);
        $id = !empty($request->id) ? encrypted_key($request->id, "decrypt") : 0;
        $validation = [
            'education' => 'required',
         
        
       ];
       $validator = Validator::make(
           $request->all(), $validation
       );

       if($validator->fails())
       {
           return redirect()->back()->with('error', $validator->errors()->first());
       }
       if( $id == null){
        $user = Auth::user();
        $education = new Education;
        $education->education = $request->education;
        $education->user_id = Auth::user()->id;
        $education->save();
        return redirect()->route('profile-settings')->with('success', __('Education added successfully.'));
       }else{
        $education = Education::find($id);
        $education->education  = $request->education;
        $education->update();
        return redirect()->route('profile-settings')->with('success', __('Education updated successfully.'));

       }
    
     
       

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Quote  $quote
     * @return \Illuminate\Http\Response
     */
    public function show(Education $education)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Quote  $quote
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id = encrypted_key($id, 'decrypt') ?? $id;
        $authuser = Auth::user();
       $education = Education::find($id);;
      
        return view('education.create', compact('education'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Quote  $quote
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Education $education)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
   
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_enc)
    {
        $objUser = Auth::user();
       
        $id = !empty($id_enc) ? encrypted_key($id_enc, "decrypt") : 0;
       // dd($id);
        if (empty($id)) {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }

        $data = Education::find($id);
        $data->delete();
        return redirect()->back()->with('success', __('Deleted.'));
    }
}
