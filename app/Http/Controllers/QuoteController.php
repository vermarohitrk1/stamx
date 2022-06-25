<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Quote;
use DataTables;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Imports\QuoteImport;
class QuoteController extends Controller
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
            $data = Quote::select('id','name')->orderBy('id', 'DESC');
       return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('name', function ($data) {
                    return $data->name;
                })
               ->addColumn('action', function($data){
                    
                $actionBtn = '<div class="actions text-right">
                       <a class="btn btn-sm bg-success-light" data-url="' . route('quotes.edit', encrypted_key($data->id, "encrypt")) . '" data-ajax-popup="true" data-size="md" data-title="Edit Quote" href="#">
                           <i class="fas fa-pencil-alt"></i>
                       </a>
                         <a data-url="' . route('quotes.destroy', encrypted_key($data->id, "encrypt")) . '" href="#" class="btn btn-sm bg-danger-light delete_record_model">
                             <i class="far fa-trash-alt"></i> Delete
                         </a>
                     </div>';
                    
              
                    return $actionBtn;
                })
                ->rawColumns(['id','name','action'])
                ->make(true);     
               


        }else{
            
      
            return view('quotes.index');
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
        $id = !empty($request->id) ? encrypted_key($request->id, "decrypt") : 0;
        $validation = [
            'name' => 'required',
         
        
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
        $quote = new Quote;
        $quote->name = $request->name;
        $quote->save();
        return redirect()->route('quotes')->with('success', __('Quote added successfully.'));
       }else{
        $quote = Quote::find($id);
        $quote->name  = $request->name;
        $quote->update();
        return redirect()->route('quotes')->with('success', __('Quote updated successfully.'));

       }
    
     
       

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Quote  $quote
     * @return \Illuminate\Http\Response
     */
    public function show(Quote $quote)
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
       $quote = Quote::find($id);;
      
        return view('quotes.create', compact('quote'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Quote  $quote
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Quote $quote)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Quote  $quote
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

        $data = Quote::find($id);
        $data->delete();
        return redirect()->back()->with('success', __('Deleted.'));
    }
    public function import_quote(Request $request) {
        $rules = array('csv_file' => 'required');
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(array(
                 'success' => false,
                 'errors' => $validator->getMessageBag()->toArray()
                   ), 400);
        }
        $data = $request->all();
        $file = $request->csv_file;
        $handle = fopen($file, "r");
        $headerValues = fgetcsv($handle, 0, ',');
        $header = implode(',', $headerValues);
        $countheader = count($headerValues);
        if ($countheader < 1) {
            if (!str_contains($header, 'Title')) {
                return response()->json(array(
                            'success' => false,
                            'errors' => __('1st column should be Title')
                                ), 404);
            }
        }

        if (Excel::import(new QuoteImport, $request->file('csv_file'))) {
            return redirect()->back()->with('success', __(' CSV Imported successfully.'));
        } else {
            return redirect()->back();
        }
    }
}
