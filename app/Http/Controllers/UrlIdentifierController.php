<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Plan;
use App\UrlIdentifier;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use DataTables;

class UrlIdentifierController extends Controller {

    protected $user;

    public function __construct() {
        $this->middleware(function ($request, $next) {
            $loginUser = $this->user = Auth::user();
            if ($loginUser->type != 'admin') {
                return redirect()->route('home')->with('error', __('Permission Denied.Only Admin Can Use This Feature'));
            }
            return $next($request);
        });
    }

    //start controller work from here

    public function index(Request $request) {
        if ($request->ajax()) {
            $data = UrlIdentifier::orderByDesc('id');
            return Datatables::of($data)
                ->addIndexColumn()
                ->filterColumn('table_name', function ($query, $keyword) use ($request) {
                    $sql = "url_identifiers.table_name like ?";
                    $query->whereRaw($sql, ["%{$keyword}%"]);
                })
                ->addColumn('table_name', function ($data) {
                    return $data->table_name;
                })->addColumn('table_unique_identity', function ($data) {
                    return $data->table_unique_identity;
                })->addColumn('status', function ($data) {
                    return $data->status;
                })->addColumn('action', function ($data) {
                    $authuser = Auth::user();
                    $actionBtn = '<div class="actions text-center">
                                    <a href="'.route('url.identifiers.edit',['id'=>$data->id]).'"
                                       class="action-item px-2" data-toggle="tooltip"
                                       data-original-title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="javascript:void(0)"
                                       class="action-item text-danger px-2 destroyMe delete_record_model"
                                       data-url="'.route('url.identifiers.delete',$data->id).'" data-toggle="tooltip"
                                       data-original-title="Delete">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </div>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        } else {
            return view('urlIdentifier.index');
        }
    }

    public function create() {
        $db =  env('DB_DATABASE');
        $tableList = DB::select("SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE = 'BASE TABLE' AND TABLE_SCHEMA='".$db."'");
        return view('urlIdentifier.create', compact('tableList'));
    }

    public function featchData() {
        $UrlIdentifier = new UrlIdentifier();
        $UrlIdentifier = $UrlIdentifier->list();
        return view('urlIdentifier.list', compact('UrlIdentifier'));
    }

    public function checkTableName() {

        if (isset($_GET['tablename'])) {
            $tableName = $_GET['tablename'];
        }
        if (!empty($tableName)) {
            $urlCkeck = new UrlIdentifier();
            $urlCkeck = $urlCkeck->checkTableNameByModal($tableName);
            return $urlCkeck;
        }
    }

    public function store(Request $request) {

        $UrlIdentifier = new UrlIdentifier();
        $UrlIdentifier = $UrlIdentifier->store($request);
        if ($UrlIdentifier->id) {
            return redirect()->back()->with('success', __('Url Identifer Created Successfully.'));
        } else {
            return redirect()->back()->with('error', __('Error try Again.'));
        }
    }

    public function edit($id) {
        $UrlIdentifier = new UrlIdentifier;
        $UrlIdentifier = $UrlIdentifier->getUrlIdentifier($id);
        $tableList = DB::select("SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE = 'BASE TABLE' AND TABLE_SCHEMA='publicit_app' ");
        return view('urlIdentifier.edit', compact('UrlIdentifier','tableList'));
    }

    public function Update(Request $request) {
        $UrlIdentifier = new UrlIdentifier;
        $UrlIdentifier = $UrlIdentifier->UpdateUrlIdentifier($request);
        if($UrlIdentifier){
            return redirect()->route('url.identifiers.index')->with('success', __('Url Identifer Updated Successfully.'));
        }else{
            return redirect()->back()->with('error', __('Error try Again.'));
        }
    }
    public function delete($id) {
        
        $UrlIdentifier = UrlIdentifier::find((int) $id)->delete();;
        // $UrlIdentifier = new UrlIdentifier;
       
        // $UrlIdentifier = $UrlIdentifier->DeleteUrlIdentifier($request);
        if($UrlIdentifier){
            return redirect()->route('url.identifiers.index')->with('success', __('Url Identifer Delete Successfully.'));
        }else{
            return redirect()->back()->with('error', __('Error try Again.'));
        }

        $UrlIdentifier = self::find($request->urlidentifiers_id);

        if ($UrlIdentifier) {

            $UrlIdentifier = $UrlIdentifier->delete();

        }

        return $UrlIdentifier;


    }

}
