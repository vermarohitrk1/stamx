<?php

namespace App\Http\Controllers;

use App\EmailTemplate;
use App\EmailTemplateLang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use DataTables;

class EmailTemplateController extends Controller
{

    /**
     * Instantiate a new UserController instance.
     */
    public function __construct()
    {
//        $this->middleware(function ($request, $next) {
//            if (Auth::user()->type != 'admin') {
//                return redirect()->back()->with('error', __('Permission Denied.'));
//            }
//            return $next($request);
//        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $domain_id = get_domain_id();
         $user = Auth::user();
//        if (!in_array("manage_email_templates", permissions()) && $user->type !="admin") {
//            return redirect()->back()->with('error', __('Permission Denied.'));
//        }

        if ($request->ajax()) {
            $data = EmailTemplate::where('domain_id' , $domain_id )->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('name', function ($data) {
                        return  $data->name;
                    })
                ->addColumn('status', function ($data) {
                        return  $data->status;
                    })
                ->addColumn('for', function ($data) {
                        return ucwords(str_replace("_"," ",$data->integration_place));
                    })



            ->addColumn('action', function($data){
                 $actionBtn = '<div class="actions text-right mt-1">

                                                <a href="'. route('manage.email.language',encrypted_key($data->id,'encrypt')) .'" class="btn btn-sm bg-success-light"  title="View/Edit Template">
                                                   <i class="far fa-eye"></i>
                                                </a>
                                            </div>';


                return $actionBtn;
            })

                ->rawColumns(['action'])
                ->make(true);
        }else{

            return view('email_templates.index');

        }


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

            $authuser = Auth::user();
            $integration_place=email_integration_places();

            return view('email_templates.create', compact('authuser','integration_place'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $usr = \Auth::user();
        $domain_id= get_domain_id();


            $validator = \Validator::make(
                $request->all(), [
                                   'integration_place' => 'required',
                                   'name' => 'required',
                                   'subject' => 'required',
//                                   'keyword' => 'required',
                               ]
            );

            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }
            $EmailTemplate             = new EmailTemplate();
            $EmailTemplate->integration_place       = $request->integration_place;
            $EmailTemplate->status       = $request->status;
            $EmailTemplate->show_for       = $request->show_for;
            $EmailTemplate->name       = $request->name;
            $EmailTemplate->from       = env('APP_NAME');
            $EmailTemplate->keyword    = $request->keyword;
            $EmailTemplate->created_by = $usr->id;
            $EmailTemplate->domain_id = $domain_id;
            $EmailTemplate->save();

            $emailTemplateLang = new EmailTemplateLang();
            $emailTemplateLang->parent_id   =   $EmailTemplate->id;
            $emailTemplateLang->lang        =   'en';
            $emailTemplateLang->subject     =   $request->subject;
            $emailTemplateLang->content     =   "Write your email {content} here along with optional keywords.";
            $emailTemplateLang->save();

            return redirect()->back()->with('success', __('Email Template successfully created.'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\EmailTemplate $emailTemplate
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $template_id)
    {
        $validator = \Validator::make(
            $request->all(), [
                               'name' => 'required',
                           ]
        );

        if($validator->fails())
        {
            $messages = $validator->getMessageBag();

            return redirect()->back()->with('error', $messages->first());
        }

        $emailTemplate       = EmailTemplate::find($template_id);
        $emailTemplate->name = $request->name;
        $emailTemplate->from = $request->from;
        $emailTemplate->keyword = $request->keyword;
         $emailTemplate->integration_place       = $request->integration_place;
            $emailTemplate->status       = $request->status;
            $emailTemplate->show_for       = $request->show_for;
        $emailTemplate->save();

        return redirect()->back()->with('success', __('Email Template successfully updated.'));
    }

    // Used For View Email Template Language Wise
    public function manageEmailLang($id, $lang = 'en')
    {
        $domain_id= get_domain_id();
          $id = encrypted_key($id, 'decrypt') ?? $id;
        if ($id == '') {
            return redirect()->back()->with('error', __('Id is mismatch.'));
        }
           // $languages     = Utility::languages();
            $emailTemplate = EmailTemplate::where('id', '=', $id)->first();
            if($emailTemplate)
            {
                $currEmailTempLang = EmailTemplateLang::where('parent_id', '=', $id)->where('lang', $lang)->first();
                if(!isset($currEmailTempLang) || empty($currEmailTempLang))
                {
                    $currEmailTempLang       = EmailTemplateLang::where('parent_id', '=', $id)->where('lang', 'en')->first();
                    $currEmailTempLang->lang = $lang;
                }
                 $integration_place=email_integration_places();
                return view('email_templates.show', compact('emailTemplate', 'currEmailTempLang','integration_place'));
            }
            else
            {
                return redirect()->back()->with('error', __('Permission denied'));
            }

    }

    // Used For Store Email Template Language Wise
    public function storeEmailLang(Request $request, $id)
    {

            $validator = \Validator::make(
                $request->all(), [
                                   'subject' => 'required',
                                   'content' => 'required',
                               ]
            );

            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $emailLangTemplate = EmailTemplateLang::where('parent_id', '=', $id)->where('lang', '=', $request->lang)->first();

            // if record not found then create new record else update it.
            if(empty($emailLangTemplate))
            {
                $emailLangTemplate            = new EmailTemplateLang();
                $emailLangTemplate->parent_id = $id;
                $emailLangTemplate->lang      = $request['lang'];
                $emailLangTemplate->subject   = $request['subject'];
                $emailLangTemplate->content   = $request['content'];
                $emailLangTemplate->save();
            }
            else
            {
                $emailLangTemplate->subject = $request['subject'];
                $emailLangTemplate->content = $request['content'];
                $emailLangTemplate->save();
            }

            return redirect()->back()->with('success', __('Email Template Detail successfully updated.'));


    }
       public function emailform($id=null)   {

            $authuser = Auth::user();
            return view('email_templates.emailform', compact('authuser','id'));

    }
       public function smsform($id=null)   {

            $authuser = Auth::user();
            return view('email_templates.smsform', compact('authuser','id'));

    }
    public function sendemail(Request $request)
    {
        $usr = \Auth::user();
        $domain_id= get_domain_id();


            $validator = \Validator::make(
                $request->all(), [
                                   'id' => 'required',
                                   'subject' => 'required',
                                   'content' => 'required',
                               ]
            );

            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }
           $userinfo= \App\User::find($request->id);
            $send= send_email($userinfo->email, $userinfo->name, $request->subject, $request->get('content'));
            if($send){
                return redirect()->back()->with('success', __('Email send successfully.'));
            }else{
                return redirect()->back()->with('error', 'Unable to send email');
            }


    }
    public function sendsms(Request $request)
    {
        $usr = \Auth::user();
        $domain_id= get_domain_id();


            $validator = \Validator::make(
                $request->all(), [
                                   'id' => 'required',
                                   'content' => 'required',
                               ]
            );

            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }
           $userinfo= \App\User::find($request->id);
              $resp=\App\SMS::send_common_sms($userinfo->mobile,$request->get('content'),$usr->id);

                if((!empty($resp['is_success']))  ){
                   return redirect()->back()->with('success', __('SMS send successfully.'));
                }else{
                    return redirect()->back()->with('error', $resp['error']??'Unable to send email');

                }


    }
}
