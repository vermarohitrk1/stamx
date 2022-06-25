<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\VirtualboothEvent;
use App\Photoboothsharecount;
use App\Photobooth;
use App\VirtualboothEventsFrames;

use DataTables;


class VirtualboothController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
    public function events(Request $request)
    {
        if ($request->ajax()) {  
            $data = VirtualboothEvent::all();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('event_name', function ($data) {
                    return $data->event_name;
                   
                })->addColumn('photos', function ($data) {
                    return "0";
                })->addColumn('emails', function ($data) {
                    return "0";
                })->addColumn('facebook', function ($data) {
                    return "0";
                })->addColumn('twitter', function ($data) {
                    return "0";
                })->addColumn('action', function($data){
                    if (Auth::user()->type != 'admin') {
                        
                  
                    $actionBtn ='
                    <a class="btn btn-sm bg-success-light" data-url="' . route('photobooth.edit', encrypted_key($data->id, "encrypt")) . '" data-ajax-popup="true" data-size="md" data-title="Edit Status" href="#">
                    <i class="fas fa-pencil-alt"></i>
                    
                </a>
                <a data-url="' . route('photobooth.destroy',$data->id) . '" href="#" class="btn btn-sm bg-danger-light delete_record_model">
                    <i class="far fa-trash-alt"></i> Delete.
                    
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
                return view('virtualbooth.events');
        }
        else{
            $boothdashboard = Photoboothsharecount::get();
            //  dd($boothdashboard);
              return view('virtualbooth.events', compact('boothdashboard'));
        }
        
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
            return view('virtualbooth.eventsCreate');
    }
    public function eventcreate()
    {
            return view('virtualbooth.eventsCreatestep_form');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
     
        $Photobooth  = new VirtualboothEvent();
        $last3 = VirtualboothEvent::latest('id')->first();
        $latestid = $last3->id;
      foreach($request->data as $key => $value){
          if($value['name'] == 'frames'  ){

           
       //  dd(explode(",",$value['value']));
             foreach(explode(",",$value['value']) as $key => $values){
//dd($values);
$VirtualboothEventsFrames  = new VirtualboothEventsFrames();
                $VirtualboothEventsFrames->event_id =  $latestid+1;

                $VirtualboothEventsFrames->image = $values;
                $VirtualboothEventsFrames->type = 'frame' ;
                $VirtualboothEventsFrames->status = '1';
                $VirtualboothEventsFrames->save();
             }

           
           


          }
          else if($value['name'] == 'stickers' ){
            foreach(explode(",",$value['value']) as $key => $values){
                //dd($values);
                                $VirtualboothEventsSticker  = new VirtualboothEventsFrames();
                                $VirtualboothEventsSticker->event_id =  $latestid+1;
                
                                $VirtualboothEventsSticker->image = $values;
                                $VirtualboothEventsSticker->type = 'sticker' ;
                                $VirtualboothEventsSticker->status = '1';
                                $VirtualboothEventsSticker->save();
                             }

          }
          else{
            $Photobooth[$value['name']]  = $value['value'];

          }
  
      }
    
      //dd( $Photobooth);
      $Photobooth->status = "1";

		$Photobooth->save();
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
