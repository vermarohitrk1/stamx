<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use App\Pointable;
use DataTables;
class PointsController extends Controller
{
    public function showPoints(Request $request){
        $data = Pointable::wherePointableId(Auth::user()->id)->with('getPoints')->latest();
        if($request->ajax()){
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('name', function($data){
                    return ($data->getPoints) ? $data->getPoints->name : '0';
                })
                ->addColumn('points', function($data){
                    return ($data->getPoints) ? $data->getPoints->point : '0';
                })
                ->addColumn('created_at', function($data){
                    return $data->created_at ?? "NA";
                })
                ->make(true);
        }

        return view('points.rewards-point');
    }
}
