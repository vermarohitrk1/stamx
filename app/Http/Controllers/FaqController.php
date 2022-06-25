<?php

namespace App\Http\Controllers;

use App\Faq;
use Illuminate\Http\Request;
use App\FaqCategory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use DataTables;
class FaqController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $user = Auth::user();
        if ($user->type == 'admin') {
			  if ($request->ajax()) { 
                $data = Faq::select('*')->where('user_id',auth()->user()->id);      
               
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($data){
                    $actionBtn = ' <div class="d-flex float-right">                                  
                    <a href="'.url('faq/edit', encrypted_key($data->id, 'encrypt')).'" class="btn btn-sm bg-success-light" data-toggle="tooltip" data-original-title="'.__('Edit').'">
                                   <i class="fas fa-pencil-alt"></i>
                                                    Edit
                                </a>

                         <a data-url="' . route('faq.destroy',encrypted_key($data->id,'encrypt')) . '" href="#" class="btn btn-sm bg-danger-light delete_record_model">
                                    <i class="fas fa-trash-alt"></i>Delete
                                </a></div>';   

                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
                return view('faq.index');
			  }
			  else{
				
				     $faq = Faq::where('user_id',$user->id)->paginate(6);
        
		return view('faq.index', compact('faq')); 
			  }
		}
		else{
	    return redirect()->back()->with('error', __('Permission Denied.'));		
			
		}
    
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function view( Request $request) {
        $user = Auth::user();
        if (!empty($user->type) && ($user->type == 'admin')) {
        if ($request->ajax()) {  
            $data = Faq::where('user_id', $user->id)
            ->orderBy('id', 'DESC');
            return Datatables::of($data)
                ->addIndexColumn()
                ->filterColumn('answer', function($query, $keyword) use ($request) {
                    $query->orWhere('faqs.answer', 'LIKE', '%' . $keyword . '%')
                   ;
                })
                ->addColumn('question', function ($data) {
                    return $data->question;
                 })
                ->addColumn('answer', function ($data) {
                    return $data->answer;
                 }) 

                ->addColumn('action', function($data){
                    $actionBtn = '
                    <a href="'.route('faq.edit',encrypted_key($data->id,'encrypt')).'" class="action-item px-2" data-toggle="tooltip" data-original-title="'.__('Edit').'">
                    <i class="fas fa-edit"></i>
                </a>
                <a href="javascript::void(0);" class="action-item text-danger px-2 destroyblog" data-id="'.encrypted_key($data->id,'encrypt').'" data-toggle="tooltip" data-original-title="'.__('Delete').'">
                    <i class="fas fa-trash-alt"></i>
                </a>';

                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
                return view('faq.list');
        }
		}
		else{
           
            return redirect()->back()->with('error', __('Permission Denied.'));
        }  
    
}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $user = Auth::user();
        if ($user->type == 'admin') {
            $title = "Add Faq";
            $categories = self::getcategory();
            return view('faq.create', compact('title', 'categories'));
        }
        return redirect()->back()->with('error', __('Permission Denied.'));
    }

    /*
     * All Categories List 
     */

    public function getcategory() {
        $user = Auth::user();
        // $categories = FaqCategory::whereIn('user_id', [0, $user->id])
        //         ->get();
        $categories = FaqCategory::get();
        return $categories;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $user = Auth::user();
        if (!empty($user->type) && ($user->type == 'admin'  )) {
            $validation = [
                'question' => 'required|max:500',
                'answer' => 'required|max:500',
                'category' => 'required',
            ];
            $validator = Validator::make(
                            $request->all(), $validation
            );

            if ($validator->fails()) {
                return redirect()->back()->withInput()->withErrors($validator);
            }

            $id = !empty($request->id) ? encrypted_key($request->id, 'decrypt') : 0;
            if (!empty($id)) {
              
                $post['user_id'] = $user->id;
                $post['category_id'] = $request->category;
                $post['question'] = $request->question;
				$post['keywords'] = $request->keywords;
                $post['answer'] = $request->answer;
                Faq::where('id', $id)->update($post);
                return redirect()->route('faq.index')->with('success', __('Record updated successfully.'));
            } else {
                $data = new Faq();
                $data['user_id'] = $user->id;
                $data['category_id'] = $request->category;
                $data['question'] = $request->question;
               $data['keywords'] = $request->keywords;
                $data['answer'] = $request->answer;
                $data->save();
                return redirect()->route('faq.index')->with('success', __('Record added successfully.'));
            }
        }
        return redirect()->back()->with('error', __('Permission Denied.'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updatesettings(Request $request) {
        $user = Auth::user();
        if (!empty($user->type) && ($user->type == 'admin' || $user->type == 'owner' )) {
            $validation = [
                'title' => 'required|max:50|min:10',
                'subtitle' => 'required|max:500|min:20',
            ];
            $validator = Validator::make(
                            $request->all(), $validation
            );

            if ($validator->fails()) {
                return redirect()->back()->withInput()->withErrors($validator);
            }

            $id = !empty($request->id) ? encrypted_key($request->id, 'decrypt') : 0;
            $website_name = explode('.', $_SERVER['HTTP_HOST'])[0];
            $website = $_SERVER['HTTP_HOST'];

            if (!empty($id)) {
                $data = Faq::where('id', $id)->where('user_id', $user->id)->first();
                $post['title'] = $request->title;
                $post['subtitle'] = $request->subtitle;
                $post['url'] = $website_name;
                $post['website'] = $website;
                $data->update($post);
                if ($data) {
                    return redirect()->route('faq.index')->with('success', __('Record updated successfully.'));
                }
            } else {
                $data = new \App\Faqssetting();
                $data['user_id'] = $user->id;
                $data['title'] = $request->title;
                $data['subtitle'] = $request->subtitle;
                $data['url'] = $website_name;
                $data['website'] = $website;
                $data->save();
                if ($data) {
                    return redirect()->route('faq.index')->with('success', __('Record added successfully.'));
                }
            }
        }
        return redirect()->back()->with('error', __('Permission Denied.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function show(Faq $faq) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function edit($id_encrypted = 0) {
        $user = Auth::user();
        if (!empty($user->type) && ($user->type == 'admin' )) {
            $id = !empty($id_encrypted) ? encrypted_key($id_encrypted, 'decrypt') : 0;
            if (!empty($id)) {
                $title = "Edit Faq";
                $data = Faq::where('id', $id)->where('user_id', $user->id)->first();
                if (!empty($data->id)) {
                    $categories = self::getcategory();
                    return view('faq.create', compact('title', 'data', 'categories'));
                }
            }
        }
        return redirect()->back()->with('error', __('Permission Denied.'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Faq $faq) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Faq  $faq
     * @return \Illuminate\Http\Response
     */
     public function destroy($id_enc=0) {
        $user = Auth::user();
	
        $id = !empty($id_enc) ? encrypted_key($id_enc, 'decrypt') : 0;
        if (!empty($id)) {
            $data = Faq::where('id', $id)->where('user_id', $user->id)->first();
            $data->delete();
            if ($data) {
                return redirect()->back()->with('success', __('Record deleted successfully.'));
            }
        }
        return redirect()->back()->with('error', __('Permission Denied.'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function settings() {
        $user = Auth::user();
        if (!empty($user->type) && ($user->type == 'admin' || $user->type == 'owner' )) {
            $title = "FAQ's Settings";
            $data = \App\Faqssetting::where('user_id', $user->id)->first();
            return view('faq.settings', compact('title', 'data'));
        }
        return redirect()->back()->with('error', __('Permission Denied.'));
    }
}
