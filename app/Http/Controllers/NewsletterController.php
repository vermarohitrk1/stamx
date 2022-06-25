<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use DataTables;

class NewsletterController extends Controller
{
    public function index(Request $request)
    {
        
        if ($request->ajax()) {
            $data = \App\User::select('id', 'name', 'avatar', 'created_by', 'type', 'is_active', 'created_at')->orderBy('id', 'ASC');
           
            $data->where('volunteer',1);


            return Datatables::of($data)
        ->addIndexColumn()
        ->addColumn('user_name', function ($data) {
            return '<h2 class="table-avatar">
                            <a href="' . route('profile', ['id' => encrypted_key($data->id, 'encrypt')]) . '" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="' . $data->getAvatarUrl() . '" alt="Image"></a>
                            <a href="' . route('profile', ['id' => encrypted_key($data->id, 'encrypt')]) . '">' . $data->name . '</a>
                        </h2>';
        })
        
        ->addColumn('action', function ($data) {
           
                        return '<div class="text-right"><a href="profile?id='.encrypted_key($data->id, 'encrypt').'" target="_blank" class="btn btn-sm bg-info-light pull-right"><i class="far fa-eye"></i> View</a></div>';
        })
        ->addColumn('created_at', function ($data) {
            return date('jS F, Y', strtotime($data->created_at)) . '<br><small>' . date('h:i a', strtotime($data->created_at)) . '</small>';
        })
        ->rawColumns(['user_name', 'created_by', 'created_at', 'action'])
        ->make(true);
} else {
    return view('newsletter.index');
}
        
    }
}