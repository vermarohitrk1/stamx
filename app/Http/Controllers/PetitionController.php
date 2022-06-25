<?php

namespace App\Http\Controllers;

use App\ContactFolder;
use App\PetitionForms;
use App\PetitionFormQuestions;
use App\PetitionFormResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use DataTables;
use Carbon\Carbon;

//use App\Exports\CustomFormResponsesExport;
//use Maatwebsite\Excel\Facades\Excel;
class PetitionController extends Controller {
    /*
     * Crm Dashboard 
     */

    public function dashboard(Request $request) {
        $user = Auth::user();
        $permissions = permissions();
        $domain_id = get_domain_id();
        $total_folders = '';
        $my_total_forms = '';
        $total_questions = '';
        $total_responses = '';
        $maps = [];
        if (!in_array("manage_petitions", $permissions) && $user->type != "admin" && !checkPlanModule('petition_forms')) {
            
        } else {

            $total_responses = \App\User::leftjoin('petition_form_responses as r', 'users.id', '=', 'r.user_id')
                    ->leftjoin('petition_forms as cf', 'cf.id', '=', 'r.form_id')
                    ->where('cf.user_id', $user->id)
                    ->where('users.address_lat', '!=', 0.0000)
                    ->count();
            $total_folders = ContactFolder::where('user_id', $user->id)->get();
            if ($request->ajax() && !empty($request->blockElementsData)) {
                if (!empty($request->duration)) {
                    $tilldate = Carbon::now()->addMonth($request->duration)->toDateTimeString();
                }
                $total_folders_count = ContactFolder::where('user_id', $user->id);
                if (!empty($tilldate)) {
                    $total_folders_count->where("created_at", ">", $tilldate);
                }
                $total_folders_count = $total_folders_count->count();

                $my_total_forms = PetitionForms::where('user_id', $user->id);
                if (!empty($tilldate)) {
                    $my_total_forms->where("created_at", ">", $tilldate);
                }
                $my_total_forms = $my_total_forms->count();

                $total_responses_count = \App\User::leftjoin('petition_form_responses as r', 'users.id', '=', 'r.user_id')
                        ->leftjoin('petition_forms as cf', 'cf.id', '=', 'r.form_id')
                        ->where('cf.user_id', $user->id)
                        ->where('users.address_lat', '!=', 0.0000);
                if (!empty($tilldate)) {
                    $total_responses_count->where("r.created_at", ">", $tilldate);
                }
                $total_responses_count = $total_responses_count->count();

                return json_encode([
                    'petitions' => $my_total_forms,
                    'supporters' => $total_responses_count,
                    'folders' => $total_folders_count,
                ]);
            }
        }
        $title = "Forms Dashboard";

        return view('contacts.petitionforms.dashboard', compact('title', 'total_folders', 'my_total_forms', 'total_questions', 'total_responses'));
    }

    public function donations(Request $request) {
        $user = Auth::user();

        if ($request->ajax()) {
            $data = \App\UserPayment::orderBy('id', 'DESC')->where('entity_type', 'Petition Payment');

            if (!empty($request->filter_status)) {
                if ($request->filter_status == 1) {
                    $data->where('user_id', $user->id);
                } elseif ($request->filter_status == 2) {
                    $data->where('paid_to_user_id', $user->id);
                }
            } else {
                $data->whereRaw('(paid_to_user_id=' . $user->id . ' OR user_id=' . $user->id . ')');
            }


            return Datatables::of($data)
                            ->addIndexColumn()
                            ->addColumn('order_id', function ($data) {
                                return '<a class="btn btn-xs bg-primary-light" href="' . route("petitionshared.form", encrypted_key($data->entity_id, 'encrypt')) . '">' . substr($data->title, 0, 30) . '</a>';
                            })
                            ->addColumn('paidto', function ($data) {
                                $paidto = \App\User::find($data->paid_to_user_id);
                                return '<h2 class="table-avatar">
                                                <a href="' . route('profile', ['id' => encrypted_key($paidto->id, 'encrypt')]) . '" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="' . $paidto->getAvatarUrl() . '" alt="Image"></a>
                                                <a href="' . route('profile', ['id' => encrypted_key($paidto->id, 'encrypt')]) . '">' . $paidto->name . '</a>
                                            </h2>';
                            })
                            ->addColumn('paidby', function ($data) {
                                $paidto = \App\User::find($data->user_id);
                                return '<h2 class="table-avatar">
                                                <a href="' . route('profile', ['id' => encrypted_key($paidto->id, 'encrypt')]) . '" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="' . $paidto->getAvatarUrl() . '" alt="Image"></a>
                                                <a href="' . route('profile', ['id' => encrypted_key($paidto->id, 'encrypt')]) . '">' . $paidto->name . '</a>
                                            </h2>';
                            })
                            ->addColumn('amount', function ($data) {
                                return format_price($data->amount);
                            })
                            ->addColumn('created_at', function ($data) {
                                return date('jS F, Y', strtotime($data->created_at)) . '<br><small>' . date('h:i a', strtotime($data->created_at)) . '</small>';
                            })
                            ->addColumn('action', function($data) {
                                $actionBtn = '<div class="actions text-right">
                         
                                                <a class="btn btn-sm bg-warning-light" data-title="View " href="' . route("payment.invoice", encrypted_key($data->id, 'encrypt')) . '">
                                                    Invoice
                                                </a>
                                            </div>';


                                return $actionBtn;
                            })
                            ->rawColumns(['order_id', 'paidto', 'created_at', 'amount', 'action', 'paidby'])
                            ->make(true);
        } else {

            return view('contacts.petitionforms.donation_payments');
        }
    }

    /*
     * Crm Form Listing
     */

    public function index(Request $request) {
        $user = Auth::user();
//        if (!in_array("manage_petitions", permissions()) && $user->type !="admin") {
//            return redirect()->back()->with('error', __('Permission Denied.'));
//        }
        if ($request->ajax()) {
            $data = PetitionForms::where('user_id', $user->id)->orderByDesc('id');
            //status
            if (!empty($request->filter_category)) {
                $data->where('folder_id', $request->filter_category);
            }

            //keyword
            if (!empty($request->keyword)) {
                $data->WhereRaw('(title LIKE "%' . $request->keyword . '%" )');
            }
            return Datatables::of($data)
                            ->addIndexColumn()
                            ->filterColumn('title', function($query, $keyword) use ($request) {
                                $query->orWhere('title', 'LIKE', '%' . $keyword . '%')
                                ;
                            })
                            ->addColumn('title', function ($data) {
                                return $data->title;
                            })
                            ->addColumn('description', function ($data) {
                                return substr($data->description, 0, 35) . "..";
                            })
                            ->addColumn('status', function ($data) {

                                $class = ($data->status == "Published") ? 'success' : 'warning';

                                $html = '<span class="badge  badge-xs bg-' . $class . '-light"> ' . $data->status . '</span>';


                                return $html;
                            })
                            ->addColumn('folder', function ($data) {
                                return \App\ContactFolder::getfoldername($data->folder_id);
                            })
                            ->addColumn('questions', function ($data) {

                                return str_replace(",", '<br>', $data->tags);
                            })
                            ->addColumn('responses', function ($data) {
                                $count = PetitionFormResponses::where("form_id", $data->id)->where("response", "!=", "")->count();
                                $percent = (int) 100 * $count / $data->target;
                                return '<a href="' . route('petitioncustomForm.responseUsers', encrypted_key($data->id, 'encrypt')) . '" class="btn btn-xs bg-primary-light mt-1 px-2" data-toggle="tooltip" data-original-title="Supporters">
                    ' . $count . "/" . $data->target . '</a><br><div class="progress">
                                                        <div class="progress-bar bg-success" role="progressbar" style="width: ' . $percent . '%;" aria-valuenow="' . $percent . '" aria-valuemin="0" aria-valuemax="100">' . $percent . '%</div>
                                                        </div>';
                            })
                            ->addColumn('action', function($data) {
                                $idquoted = "'" . encrypted_key($data->id, 'encrypt') . "'";
                                $actionBtn = '
                     

                         
                   <a href="#" onclick="copypublicform(' . $idquoted . ')" class="btn btn-sm bg-success-light mt-1 px-2" data-toggle="tooltip" data-original-title="Copy Public Link">
                    <i class="fas fa-share"></i>
                            </a>
                   <a href="' . route('petitionshared.form', encrypted_key($data->id, 'encrypt')) . '" class="btn btn-sm bg-primary-light mt-1 px-2" data-toggle="tooltip" data-original-title="View">
                    <i class="fas fa-eye"></i>
                            </a>
                   <a href="' . route('petitioncustom.edit', encrypted_key($data->id, 'encrypt')) . '" class="btn btn-sm bg-primary-light mt-1 px-2" data-toggle="tooltip" data-original-title="Edit">
                    <i class="fas fa-edit"></i>
                            </a>
                   <a href="' . route('petitionForm.assign', encrypted_key($data->id, 'encrypt')) . '" class="btn btn-sm bg-primary-light mt-1 px-2" data-toggle="tooltip" data-original-title="Invite">
                    <i class="fas fa-user-plus"></i>
                            </a>
                   <a href="' . route('petitioncustomForm.responseUsers', encrypted_key($data->id, 'encrypt')) . '" class="btn btn-sm bg-primary-light mt-1 px-2" data-toggle="tooltip" data-original-title="Supporters">
                    <i class="fas fa-users"></i>
                            </a>
                            <a data-url="' . route('petitioncustom.destroy', encrypted_key($data->id, 'encrypt')) . '" href="#" class="btn btn-sm bg-danger-light mt-1 px-2 delete_record_model">
                                                    <i class="far fa-trash-alt"></i> 
                                                </a>
                ';

                                return $actionBtn;
                            })
                            ->rawColumns(['status', 'title', 'folder', 'description', 'questions', 'responses', 'action'])
                            ->make(true);
        } else {
            $folders = \App\ContactFolder::where('user_id', $user->id)->get();
            return view('contacts.petitionforms.index', compact('folders'));
        }
    }

    public function updates(Request $request) {
        $user = Auth::user();
//        if (!in_array("manage_petitions", permissions()) && $user->type !="admin") {
//            return redirect()->back()->with('error', __('Permission Denied.'));
//        }
        if ($request->ajax()) {
            $data = \App\PetitionUpdates::where('user_id', $user->id)->orderByDesc('id');
            //status
            if (!empty($request->filter_category)) {
                $data->where('petition_id', $request->filter_category);
            }

            return Datatables::of($data)
                            ->addIndexColumn()
                            ->filterColumn('title', function($query, $keyword) use ($request) {
                                $query->orWhere('title', 'LIKE', '%' . $keyword . '%')
                                ;
                            })
                            ->addColumn('title', function ($data) {
                                $perition = PetitionForms::find($data->petition_id);
                                return $perition->title;
                            })
                            ->addColumn('description', function ($data) {
                                return substr($data->updates, 0, 35) . "..";
                            })
                            ->addColumn('date', function ($data) {
                                return date('M d, Y', strtotime($data->date));
                            })
                            ->addColumn('action', function($data) {
                                $idquoted = "'" . encrypted_key($data->id, 'encrypt') . "'";
                                $actionBtn = '
                       
                  <a href="#" class="btn btn-sm bg-primary-light mt-1 px-2" data-url="' . route('petitionupdate.edit', encrypted_key($data->id, 'encrypt')) . '" data-ajax-popup="true" data-size="md" data-title="Edit">
           <i class="fas fa-edit"></i>
    </a>
                            <a data-url="' . route('petitionupdate.destroy', encrypted_key($data->id, 'encrypt')) . '" href="#" class="btn btn-sm bg-danger-light mt-1 px-2 delete_record_model">
                                                    <i class="far fa-trash-alt"></i> 
                                                </a>
                ';

                                return $actionBtn;
                            })
                            ->rawColumns(['date', 'title', 'description', 'action'])
                            ->make(true);
        } else {
            $petitions = \App\PetitionForms::where('user_id', $user->id)->get();
            return view('contacts.petitionforms.updates', compact('petitions'));
        }
    }

    /*
     *  Create Crm Form
     */

    public function form_create() {
        $user = Auth::user();
//        if (!in_array("manage_petitions", permissions()) && $user->type !="admin") {
//            return redirect()->back()->with('error', __('Permission Denied.'));
//        }

        $title = "Create Custom Form";
        $folders = ContactFolder::where('user_id', $user->id)->get();
        ;
        return view('contacts.petitionforms.create_form', compact('title', 'folders'));
    }

    /*
     *   Edit Crm Form
     */

    public function edit($id_encrypted = 0) {
        $user = Auth::user();
        $id = !empty($id_encrypted) ? encrypted_key($id_encrypted, 'decrypt') : 0;
        if (!empty($id)) {
            $title = "Edit Crm Form";
            $data = PetitionForms::where('id', $id)->where('user_id', $user->id)->first();

            if (!empty($data->id)) {
                $folders = ContactFolder::where('user_id', $user->id)->get();
                return view('contacts.petitionforms.create_form', compact('title', 'data', 'folders'));
            }
        }
        return redirect()->route('petitioncustom.index')->with('error', __('Permission Denied.'));
    }

    /*
     *   Store Crm Form
     */

    public function store(Request $request) {
        $user = Auth::user();
        $title = "Crm Form";
        $validation = [
            'title' => 'required|max:255|min:2',
            'folder_id' => 'required',
            'target' => 'required',
            'end_date' => 'required',
            'description' => 'required|max:500|min:2',
        ];

        $validator = Validator::make(
                        $request->all(), $validation
        );

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $id = !empty($request->id) ? encrypted_key($request->id, 'decrypt') : 0;
        if (!empty($request->image)) {
            $base64_encode = $request->image;
            $folderPath = "storage/petition/";
            if (!file_exists($folderPath)) {
                File::isDirectory($folderPath) or File::makeDirectory($folderPath, 0777, true, true);
            }
            $image_parts = explode(";base64,", $base64_encode);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $image = "petition" . uniqid() . '.' . $image_type;
            ;
            $file = $folderPath . $image;
            file_put_contents($file, $image_base64);
        }
        if (!empty($id)) {
            $data = PetitionForms::where('id', $id)->where('user_id', $user->id)->first();

            $post['user_id'] = $user->id;
            $post['title'] = $request->title;
            $post['folder_id'] = $request->folder_id;
            $post['description'] = $request->description;
            $post['status'] = $request->status;
            $post['target'] = $request->target;
            $post['end_date'] = $request->end_date;
            $post['dummy'] = $request->dummy ?? 0;
            $post['tags'] = $request->tags;
            $post['alert'] = $request->alerts;
            if (!empty($image)) {
                $post['image'] = $image;
            }
            $data->update($post);
            return redirect()->route('petitioncustom.index')->with('success', __('updated successfully.'));
        } else {
            $data = new PetitionForms();
            $data['user_id'] = $user->id;
            $data['title'] = $request->title;
            $data['folder_id'] = $request->folder_id;
            $data['description'] = $request->description;
            $data['status'] = $request->status;
            $data['target'] = $request->target;
            $data['end_date'] = $request->end_date;
            $data['dummy'] = $request->dummy ?? 0;
            $data['alert'] = $request->alerts;
            $data['tags'] = $request->tags;
            if (!empty($image)) {
                $data['image'] = $image;
            }
            $data->save();
            return redirect()->route('petitioncustom.index')->with('success', __('added successfully.'));
        }
    }

    /*
     *   Destroy Crm Form
     */

    public function destroy($id = 0) {
        $user = Auth::user();
        $id = !empty($id) ? encrypted_key($id, 'decrypt') : 0;
        if (!empty($id)) {
            $data = PetitionForms::where('id', $id)->where('user_id', $user->id)->first();
            if (!empty($data->id))
                $data->delete();

            $questions = PetitionFormQuestions::where('form_id', $id)->get();
            if (!empty($questions->id))
                $questions->delete();

            $responses = PetitionFormResponses::where('form_id', $id)->get();
            if (!empty($responses->id))
                $responses->delete();

            return redirect()->back()->with('success', __('form and related data deleted successfully.'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    /*
     *   Crm Form Questions
     */

    public function questions($id_encrypted = 0) {
        $user = Auth::user();
//        if (!in_array("manage_petitions", permissions()) && $user->type !="admin") {
//            return redirect()->back()->with('error', __('Permission Denied.'));
//        }
        $id = !empty($id_encrypted) ? encrypted_key($id_encrypted, 'decrypt') : 0;
        if (!empty($id)) {
            $title = "Custom Form Questions";
            $form = PetitionForms::where('id', $id)->where('user_id', $user->id)->first();
            $questions = PetitionFormQuestions::where('form_id', $id)->orderBy('indexing', "ASC")->orderBy('created_at', "ASC")->get();

            if (!empty($form->id)) {
                return view('contacts.petitionforms.questions_list', compact('title', 'form', 'questions', 'id'));
            } else {
                return redirect()->back()->with('error', __('Permission Denied.'));
            }
        }
        return redirect()->back()->with('error', __('Permission Denied.'));
    }

    /*
     *   Form Sidebar
     */

    public function form_sidebar($id_encrypted = 0) {
        $user = Auth::user();
        $form = '';
        $form_response = '';
        $form_questions = '';
        $sidebar = '';
        if (isset($_GET['sidebar'])) {
            $sidebar = $_GET['sidebar'];
        }
        $id = !empty($id_encrypted) ? encrypted_key($id_encrypted, 'decrypt') : 0;
        if (!empty($id)) {
            $form = PetitionForms::where('id', $id)->first();

            $form_response = PetitionFormResponses::where('form_id', $id)->where('user_id', $user->id)->first();
//            $form_questions = PetitionFormQuestions::where('form', $id)->orderBy('indexing', 'DESC')->get();
        }
        return view('contacts.petitionforms.form_sidebar', compact('id', 'form', 'form_response', 'form_questions', 'sidebar'));
    }

    /*
     * All Crm Questions Types List 
     */

    public function questions_types() {
        $types = array(
            "text" => "Text",
            "number" => "Number",
            "email" => "Email",
            "date" => "Date",
            "url" => "Url",
            "select" => "Select",
            "checkbox" => "Checkbox",
            "radio" => "Radio",
            "textarea" => "Textarea",
            "selectwith" => "Select with Yes/No resource",
        );
        return $types;
    }

    /*
     *  Crm Form Add Question
     */

    public function question_create($form_id_encrypted = 0) {
        $user = Auth::user();
        $form_id = !empty($form_id_encrypted) ? encrypted_key($form_id_encrypted, 'decrypt') : 0;
        if (!empty($form_id) && !empty($user->type) && $user->type != 'user') {
            $title = "Add Form Question";
            $form = PetitionForms::where('id', $form_id)->first();
            $question_types = self::questions_types();
            return view('contacts.petitionforms.question_form', compact('title', 'form_id', 'question_types', 'form'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    /*
     *  Crm Form Update Question
     */

    public function question_edit($form_id_encrypted = 0, $id_encrypted = 0) {
        $user = Auth::user();
        $form_id = !empty($form_id_encrypted) ? encrypted_key($form_id_encrypted, 'decrypt') : 0;
        $id = !empty($id_encrypted) ? encrypted_key($id_encrypted, 'decrypt') : 0;
        if (!empty($id) && !empty($form_id) && !empty($user->type) && $user->type != 'user') {
            $title = "Update Form Question";
            $form = PetitionForms::where('id', $form_id)->where('user_id', $user->id)->first();
            $data = PetitionFormQuestions::where('id', $id)->where('user_id', $user->id)->first();
            $question_types = self::questions_types();
            return view('contacts.petitionforms.question_form', compact('title', 'data', 'form_id', 'question_types', 'form'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    /*
     *   Store Crm Form Question
     */

    public function question_store(Request $request) {
        $user = Auth::user();
//        if (!in_array("manage_petitions", permissions()) && $user->type !="admin") {
//            return redirect()->back()->with('error', __('Permission Denied.'));
//        }

        $form_id = !empty($request->form_id) ? encrypted_key($request->form_id, 'decrypt') : 0;
        if (!empty($form_id)) {
            $title = " Form Question";
            $validation = [
                'question' => 'required|max:255|min:2',
                'type' => 'required',
            ];
            if (!empty($request->type) && $request->type == "select") {
                $validation['options'] = 'required|max:255|min:2';
            }
            $validator = Validator::make(
                            $request->all(), $validation
            );

            if ($validator->fails()) {
                return redirect()->back()->withInput()->withErrors($validator);
            }

            $id = !empty($request->id) ? encrypted_key($request->id, 'decrypt') : 0;

            if (!empty($id)) {
                $data = PetitionFormQuestions::where('id', $id)->where('user_id', $user->id)->first();
                $post['form_id'] = $form_id;
                $post['user_id'] = $user->id;
                $post['question'] = $request->question;
                $post['type'] = $request->type;
                $post['options'] = ($request->type == "selectwith") ? "Yes,No" : $request->options;
                $post['resource_url'] = $request->resource_url;
                $data->update($post);
                return redirect()->route('petitioncustomQuestion', $request->form_id)->with('success', __('Form question updated successfully.'));
            } else {
                $data = new PetitionFormQuestions();
                $data['form_id'] = $form_id;
                $data['user_id'] = $user->id;
                $data['question'] = $request->question;
                $data['type'] = $request->type;
                $data['options'] = ($request->type == "selectwith") ? "Yes,No" : $request->options;
                $data['resource_url'] = $request->resource_url;
                $data->save();
                return redirect()->route('petitioncustomQuestion', $request->form_id)->with('success', __('Form question added successfully.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    /*
     *   Destroy Crm Form Question
     */

    public function question_destroy($id = 0) {
        $user = Auth::user();
        $id = !empty($id) ? encrypted_key($id, 'decrypt') : 0;
        if (!empty($id)) {
            $data = PetitionFormQuestions::where('id', $id)->where('user_id', $user->id)->first();
            $data->delete();
            return redirect()->back()->with('success', __('Question deleted successfully.'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    /**
     *  questions indexing
     * 
     * @return Json
     */
    public function indexing(Request $request) {
        $post = $request->post();
        $user = Auth::user();
        $i = 1;
        unset($post['_token']);
        foreach ($post as $q => $order) {
            $question_id = explode(":", $q);
            $data = PetitionFormQuestions::where('id', $question_id[1])->first();
            $place['indexing'] = $i;
            $data->update($place);
            $i++;
        }
        return;
    }

    /*
     *   Crm Form
     */

    public function form($id_encrypted = 0) {
        $user = Auth::user();
        $title = "Crm Custom Form";
        $assigned = false;
        $id = !empty($id_encrypted) ? encrypted_key($id_encrypted, 'decrypt') : 0;

        if (!empty($id)) {


            $form = PetitionForms::where('id', $id)->first();

            $form_response = PetitionFormResponses::where('form_id', $id)->where('user_id', $user->id)->first();

            if (!empty($user->type)) {
                // $form = PetitionForms::where('id', $id)->where('user_id', $user->id)->first();

                $questions = PetitionFormQuestions::where('form_id', $id)->orderBy('created_at', "ASC")->orderBy('indexing', 'ASC')->get();
                if (!empty($form->id)) {
                    return view('contacts.petitionforms.form', compact('title', 'form', 'questions', 'id', 'assigned', 'form_response'));
                }
            }
            /*
             *  Form Owner
             *  End 
             */
        }

        return redirect()->back()->with('error', __('Permission Denied.'));
    }

    /*
     *   Crm Form Response
     */

    public function form_user_response($id_encrypted = 0) {
        $user = Auth::user();
        $title = "Crm Response";
        $assigned = false;
        $id = !empty($id_encrypted) ? encrypted_key($id_encrypted, 'decrypt') : 0;

        if (!empty($id)) {
            $response = PetitionFormResponses::find($id);

            $form = PetitionForms::where('id', $response->form_id)->first();
            $response_by_user = \App\User::find($response->user_id)->name;
            $user_id = $response->user_id;
            return view('contacts.petitionforms.form_response', compact('title', 'response', 'form', 'id', 'response_by_user', 'user_id'));
        }
        return redirect()->back()->with('error', __('Permission Denied.'));
    }

    /*
     *   Store Crm Form Responses
     */

    public function form_response_store(Request $request) {
        $validation = [
            'id' => 'required',
            'fname' => 'required',
            'lname' => 'required',
            'email' => 'required',
            'comment' => 'required|max:500|min:2',
        ];

        $validator = Validator::make(
                        $request->all(), $validation
        );

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $data_array = array();
        $id = !empty($request->id) ? encrypted_key($request->id, 'decrypt') : 0;
        if (!empty($id)) {
            /*
             *  Check Assignment Permission 
             *  Start 
             */
            if (empty(check_email_is_valid($request->email))) {
                return redirect()->back()->with('error', __('Invalid email provided.'));
            }
            $user = Auth::user();
            $uid = !empty($user->id) ? $user->id : 0;
            if (empty($uid)) {
                $userdata = \App\User::where('email', $request->email)->first();
                $uid = !empty($userdata->id) ? $userdata->id : 0;
            }
            if (empty($uid)) {
                $roles = get_permission_roles('add_in_search_profiles');
                if (empty($roles[0])) {
                    return redirect()->back()->with('error', __('No active role for petition.'));
                }
                $create_array = [
                    'name' => $request->fname . ' ' . $request->lname,
                    'email' => $request->email,
                    'mobile' => '',
                    'role' => $roles[0],
                    'petition' => 1,
                    'password' => app('App\Http\Controllers\Auth\RegisterController')->generateCode(8),
                ];

                $uid = app('App\Http\Controllers\Auth\RegisterController')->registerpetition($create_array);
            }
            $form = PetitionForms::where('id', $id)->first();

            if (!empty($form->id)) { //if form is valid and form is assigned to user
                $data = PetitionFormResponses::where('form_id', $id)->where('user_id', $uid)->first();
                if (empty($data->id)) {
                    $data = new PetitionFormResponses();
                    $data['form_id'] = $id;
                    $data['user_id'] = $uid ?? 0;
                    $data['response'] = 1;
                    $data->save();



                    $comment = new \App\PetitionComments();
                    $comment['petition_id'] = $id;
                    $comment['user_id'] = $uid ?? 0;
                    $comment['comment'] = $request->comment;
                    $comment['display'] = (!empty($request->display_name) && $request->display_name == "on") ? "Yes" : "No";
                    $comment['status'] = "Published";
                    $comment->save();

                    $data = array(
                        'fname' => $request->fname,
                        'lname' => $request->lname,
                        'fullname' => $request->fname . ' ' . $request->lname,
                        'email' => $request->email,
                    );

                    $response = \App\Contacts::create_contact($data, 'Petition'); //$form->getfolder($form->folder_id)
                    if (empty(Auth::user()->id)) {
                        Auth::loginUsingId($uid);
                    }
                    return redirect()->route("petitionsupport", $request->id)->with('success', __('Petition signed successfully.'));
                } else {
                    $data['response'] = 1;
                    $data->save();
                }

                return redirect()->back()->with('success', __('You have already signed.'));
            }
            /*
             *  Check Assignment Permission 
             *  End 
             */
        }
        return redirect()->back()->with('error', __('Permission Denied.'));
    }

    /*
     *   Crm Form Users Responses
     */

    public function public_form_support($id_encrypted = 0) {
        $id = !empty($id_encrypted) ? encrypted_key($id_encrypted, 'decrypt') : 0;
        if (!empty($id)) {
            $row = PetitionForms::where('id', $id)->first();
            return view('contacts.petitionforms.public_form_support', compact('row'));
        }
        return redirect()->back()->with('error', __('Permission Denied.'));
    }

    public function public_form_share($id_encrypted = 0) {
        $id = !empty($id_encrypted) ? encrypted_key($id_encrypted, 'decrypt') : 0;
        if (!empty($id)) {
            $row = PetitionForms::where('id', $id)->first();
            return view('contacts.petitionforms.public_form_share', compact('row'));
        }
        return redirect()->back()->with('error', __('Permission Denied.'));
    }

    public function public_form_promote($id_encrypted = 0) {
        $id = !empty($id_encrypted) ? encrypted_key($id_encrypted, 'decrypt') : 0;
        if (!empty($id)) {
            $row = PetitionForms::where('id', $id)->first();
            return view('contacts.petitionforms.public_form_promote', compact('row'));
        }
        return redirect()->back()->with('error', __('Permission Denied.'));
    }

    public function profilereviews(Request $request) {

        $build_query = \App\PetitionComments::where('petition_id', $request->id)->orderBy('created_at', 'DESC');


        $data = $build_query->paginate(3); // dd($data);
        $responseHtml = view('contacts.petitionforms.FilterReviews', compact('data'))->render();

        return response()->json([
                    'html' => $responseHtml,
        ]);
    }

    public function form_users_responses(Request $request, $id_encrypted = 0) {
        $user = Auth::user();
        $permissions = permissions();
        $id = !empty($id_encrypted) ? encrypted_key($id_encrypted, 'decrypt') : 0;
        if (!empty($id)) {
            $title = "Form Users Responses";


            $form = PetitionForms::where('id', $id)->first();


            $user = Auth::user();
            if ($request->ajax()) {


                $data = PetitionFormResponses::leftjoin('petition_forms as cf', 'cf.id', 'petition_form_responses.form_id')
                        ->leftjoin('users as u', 'u.id', 'petition_form_responses.user_id')
                        ->select('petition_form_responses.*', 'u.name', 'cf.user_id as f_user_id')
                        ->where('petition_form_responses.form_id', $id)
                        ->whereRaw('(petition_form_responses.user_id=' . $user->id . ' or cf.user_id=' . $user->id . ')')
                        ->orderByDesc('id');


                return Datatables::of($data)
                                ->addIndexColumn()
                                ->filterColumn('user', function ($query, $keyword) use ($request) {
                                    $sql = " u.name like ?";
                                    $query->whereRaw($sql, ["%{$keyword}%"]);
                                })
                                ->addColumn('user', function ($data) {
                                    return '<h2 class="table-avatar">
                                                <a href="' . route('profile', ['id' => encrypted_key($data->user_id, 'encrypt')]) . '" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="' . $data->user->getAvatarUrl() . '" alt="Image"></a>
                                                <a href="' . route('profile', ['id' => encrypted_key($data->user_id, 'encrypt')]) . '">' . $data->name . '</a>
                                            </h2>';
                                })
                                ->addColumn('date', function ($data) {
                                    return date('M d, Y', strtotime($data->created_at));
                                })
                                ->addColumn('status', function ($data) {
                                    return ' <p class="text-dark">' . ((!empty($data->response)) ? '<span class="badge badge-success badge-xs badge-pill">Filled</span>' : '<span class="badge badge-danger badge-xs badge-pill">Not Filled</span></p>');
                                })
                                ->addColumn('action', function($data) {
                                    $user = Auth::user();
                                    $idquoted = "'" . encrypted_key($data->id, 'encrypt') . "'";
                                    $actionBtn = '';

                                    if ($data->f_user_id == $user->id) {
                                        $actionBtn .= '<a data-url="' . route('petitioncustomResponse.destroy', encrypted_key($data->id, 'encrypt')) . '" href="#" class="btn btn-sm bg-danger-light mt-1 px-2 delete_record_model">
                                                    <i class="far fa-trash-alt"></i> 
                                                </a>
                 ';
                                    }
                                    return $actionBtn;
                                })
                                ->rawColumns(['user', 'date', 'action', 'status'])
                                ->make(true);
            } else {


//                $responses = PetitionFormResponses::where('form_id', $id)->orderBy('id', 'DESC')->get();
//                if (!empty($responses) && count($responses) > 0) {
//                    foreach ($responses as $row)
//                        $row->user_name = \App\User::find($row->user_id)->name;
//                }


                return view('contacts.petitionforms.users_responses_list', compact('title', 'form', 'id'));
            }
        }
        return redirect()->back()->with('error', __('Permission Denied.'));
    }

    /*
     *   Destroy Crm Form User Response
     */

    public function form_users_responses_destroy($id = 0) {
        $user = Auth::user();
        $id = !empty($id) ? encrypted_key($id, 'decrypt') : 0;
        if (!empty($id)) {
            $data = PetitionFormResponses::where('id', $id)->first();
            $data->delete();
            return redirect()->back()->with('success', __('Response deleted successfully.'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function public_form_view($id_encrypted = 0) {
        $user = Auth::user();
        $id = !empty($id_encrypted) ? encrypted_key($id_encrypted, 'decrypt') : 0;
        if (!empty($id)) {


            $row = PetitionForms::where('id', $id)->first();
            $updates = \App\PetitionUpdates::where('petition_id', $id)->orderBy('date', 'DESC')->get();

            if ($row) {
                $response = PetitionFormResponses::where('form_id', $id)->count();
                if (!empty($row->id)) {
                    $livesigners = array();



                    $petitioncomments = PetitionFormResponses::where('form_id', $id)->orderBy('id', 'DESC')->limit(5)->get();
                    if (!empty($petitioncomments)) {
                        foreach ($petitioncomments as $key => $petitioncomment) {
                            $petitionuser = \App\User::find($petitioncomment->user_id);
                            $livesigner = array(
                                "name" => $petitionuser->name ?? '',
                                "time" => time_elapsed($petitionuser->created_at)
                            );
                            $livesigner["avatar"] = $petitionuser->getAvatarUrl();

                            $livesigners[] = $livesigner;
                        }
                    }


                    // $livesigners =!empty($livesigners) ? json_encode($livesigners):array();
                    return view('contacts.petitionforms.public_form', compact('livesigners', 'row', 'id', 'response', 'updates'));
                }
            }
            /*
             *  Form Owner
             *  End 
             */
        }

        return redirect()->back()->with('error', __('Permission Denied.'));
    }

    public function form_users_responses_export_csv($id_encrypted = 0) {
        $user = Auth::user();
        $id = !empty($id_encrypted) ? encrypted_key($id_encrypted, 'decrypt') : 0;
        if (!empty($id)) {
            $form = PetitionForms::where('id', $id)->first();
            return Excel::download(new CustomFormResponsesExport($id), $form->title . '.csv', \Maatwebsite\Excel\Excel::CSV);
        }

        return redirect()->back()->with('error', __('Permission Denied.'));
    }

    public function published($views = null, Request $request) {
        $user = Auth::user();
        if ($request->ajax()) {
//DB::enableQueryLog();
            $data = PetitionFormResponses::select("cf.*", "petition_form_responses.user_id as r_user_id", "petition_form_responses.response", "petition_form_responses.id as r_id", "petition_form_responses.form_id")
                    ->join('petition_forms as cf', "cf.id", 'petition_form_responses.form_id')
                    ->where('petition_form_responses.user_id', $user->id)
                    ->orderBy('petition_form_responses.id', 'DESC');


            switch ($request->filter_type) {
                case "fill":
                    $data->where('petition_form_responses.response', '!=', null);
                    break;
                case "notfill":
                    $data->where('petition_form_responses.response', null);
                    break;
                default:
                    break;
            }

            //status
            if (!empty($request->filter_category)) {
                $data->where('cf.folder_id', $request->filter_category);
            }

            //keyword
            if (!empty($request->keyword)) {
                $data->WhereRaw('(cf.title LIKE "%' . $request->keyword . '%" )');
            }
            return Datatables::of($data)
                            ->addIndexColumn()
                            ->filterColumn('form', function($query, $keyword) use ($request) {
                                // $query->WhereRaw('(subject LIKE %' . $keyword . '% OR ticket LIKE %'. $keyword . '%');
                                ;
                            })
                            ->addColumn('form', function ($data) {
                                return '<div class="actions text-right">
                                                <a class="btn btn-sm bg-primary-light mt-1" data-title="View Form"  href="' . route("petitionshared.form", encrypted_key($data->form_id, 'encrypt')) . '">
                                                   ' . ucfirst(substr($data->title, 0, 20)) . '..
                                                </a>
                                                
                                            </div>';
                            })
                            ->addColumn('question', function ($row) {
                                return str_replace(",", '<br>', $row->tags);
                            })
                            ->addColumn('category', function ($data) {
                                return \App\ContactFolder::getfoldername($data->folder_id);
                            })
                            ->addColumn('sender', function ($data) {

                                return '<h2 class="table-avatar">
                                                <a href="' . route('profile', ['id' => encrypted_key($data->user_id, 'encrypt')]) . '" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="' . $data->user->getAvatarUrl() . '" alt="Image"></a>
                                                <a href="' . route('profile', ['id' => encrypted_key($data->user_id, 'encrypt')]) . '">' . $data->user->name . '</a>
                                            </h2>';
                            })
                            ->addColumn('response', function ($row) {
                                $res = PetitionForms::find($row->form_id)->responses->where('response', '!=', '')->where('form_id', $row->form_id)->count();
                                return $res + $row->dummy;
                                if (!empty($res)) {
                                    $user = Auth::user();
                                    $res = '<div class="actions ">
                                                <a class="btn btn-sm bg-success-light" data-title="View Response"  data-ajax-popup="true" data-size="md" data-url="' . route("petitioncustomForm.response", ['id' => encrypted_key($row->form_id, 'encrypt'), 'user_id' => encrypted_key($user->id, 'encrypt')]) . '" href="#">
                                                    ' . $res . '
                                                </a>
                                            </div>';
                                }
                                return $res;
                            })
                            ->addColumn('type', function ($data) {

                                $status = (!empty($data->response)) ? 'Filled' : 'Not Filled';
                                $class = (!empty($data->response)) ? 'success' : 'warning';

                                $slots = '<span class="badge  badge-xs bg-' . $class . '-light"> ' . $status . '</span>';


                                return $slots;
                            })
                            ->rawColumns(['form', 'question', 'category', 'sender', 'response', 'action', 'type'])
                            ->make(true);
        }


//        }  
    }

    public function form_assign($form_id_encrypted = 0) {
        $user = Auth::user();
        $domain_user = get_domain_user();
        $date = date("Y-m-d");
//        if (!in_array("manage_petitions", permissions()) && $user->type !="admin") {
//            return redirect()->back()->with('error', __('Permission Denied.'));
//        }
        $form_id = !empty($form_id_encrypted) ? encrypted_key($form_id_encrypted, 'decrypt') : 0;
        if (!empty($form_id)) {
            $title = "Assign CRM Form";
            $form = PetitionForms::where('id', $form_id)->where('user_id', $user->id)->first();
            $responses = PetitionFormResponses::where('form_id', $form_id)->where('response', "")->count();
            if ($responses >= $form->target) {
                return redirect()->back()->with('error', __('Petition Target Achieved'));
            }
            if ($date > $form->end_date) {
                return redirect()->back()->with('error', __('Petition End Date Expired'));
            }
            $formres = \App\User::leftjoin("petition_form_responses as r", "r.user_id", "=", 'users.id')
                            ->where('r.form_id', $form_id)->where('r.response', "")->pluck('users.email')->toArray();

            $users = \App\Contacts::where('contacts.domain_id', $domain_user->id)
                    ->where('contacts.email', "!=", null)
                    ->whereNotIn('contacts.email', $formres)
                    ->OrderBy('contacts.id', 'DESC')
                    ->select('contacts.*');

            $users = $users->get();

            $email = '<p>Hi {fullname},</p>

<p>&nbsp;</p>

<p>Please support this petition below;</p>

<p>&nbsp;</p>

<p><a href="' . route('petitionshared.form', $form_id_encrypted) . '" target="_blank">View Petition</a></p>

<p>&nbsp;</p>

<p>Cheers</p>
';
            $subject = $form->title;
            if (!empty($form->id)) {
                return view('contacts.petitionforms.form_assign', compact('email', 'subject', 'responses', 'title', 'form_id', 'users', 'form', 'responses'));
            }
        }
        return redirect()->back()->with('error', __('Permission Denied.'));
    }

    /*
     *   Store Assessment Form Assigns
     */

    public function assign_store(Request $request) {
        $user = Auth::user();
        $form_id = !empty($request->form_id) ? encrypted_key($request->form_id, 'decrypt') : 0;
        if (!empty($form_id)) {
            $title = "CRM Form Assign";
            $validation = [
                'users' => 'required|min:1',
            ];
            $validator = Validator::make(
                            $request->all(), $validation
            );

            if ($validator->fails()) {
                return redirect()->back()->withInput()->withErrors($validator);
            }
            $post = array();
            $post['form_id'] = $form_id;
            $content = $request->content ?? '';
            $subject = $request->subject ?? '';
            $domain_user = get_domain_user();
            foreach ($request->users as $id) {

                $contact = \App\Contacts::find($id);
                if (!empty($id) && !empty($contact->email)) {

                    $contact_user = \App\User::where('email', $contact->email)->first();
                    $data = !empty($contact_user->id) ? PetitionFormResponses::where('user_id', $contact_user->id)->where('form_id', $post['form_id'])->first() : '';

                    if (empty($data->id) && !empty($contact_user)) {
                        $save = new PetitionFormResponses();
                        $save['user_id'] = $contact_user->id;
                        $save['form_id'] = $post['form_id'];
                        $save->save();
                    }

                    $arrVariable = [];
                    $arrValue = [];
                    if (!empty($contact->fullname)) {
                        array_push($arrVariable, '{fullname}');
                        array_push($arrValue, $contact->fullname);
                    }
                    if (!empty($contact->fname)) {
                        array_push($arrVariable, '{fname}');
                        array_push($arrValue, $contact->fname);
                    }
                    if (!empty($contact->lname)) {
                        array_push($arrVariable, '{lname}');
                        array_push($arrValue, $contact->lname);
                    }
                    if (!empty($contact->email)) {
                        array_push($arrVariable, '{email}');
                        array_push($arrValue, $contact->email);
                    }
                    $contact = \App\Contacts::find($id);

                    $body = str_replace($arrVariable, array_values($arrValue), $content);
                    ;

                    \App\EMAIL::common_send_Email($contact->email, $contact->fullname ?? $contact->fname, $subject, $body, $domain_user->id);
                }
            }
            return redirect()->route('petitioncustomForm.responseUsers', $request->form_id)->with('success', __('Invitation sent successfully.'));
        }

        return redirect()->back()->with('error', __('Permission Denied.'));
    }

    public function form_response($id_encrypted = 0, $user_id_encrypted) {
        $user = Auth::user();
        $title = "Form Response";
        $assigned = false;
        $id = !empty($id_encrypted) ? encrypted_key($id_encrypted, 'decrypt') : 0;
        $user_id = !empty($user_id_encrypted) ? encrypted_key($user_id_encrypted, 'decrypt') : 0;

        if (!empty($id) && !empty($user_id)) {
            $form = PetitionForms::where('id', $id)->first();
            $response = PetitionForms::find($id)->responses->where('form_id', $id)->where('user_id', $user_id)->first();
            $response_by_user = \App\User::find($user_id)->name;
            return view('contacts.petitionforms.form_response', compact('title', 'response', 'form', 'id', 'response_by_user', 'user_id'));
        }
        return redirect()->back()->with('error', __('Permission Denied.'));
    }

    public function update_create() {
        $authuser = Auth::user();
        $petitions = PetitionForms::where('user_id', $authuser->id)->get();
        return view('contacts.petitionforms.updates.create', compact('authuser', 'petitions'));
    }

    public function update_store(Request $request) {
        $user = Auth::user();
        $domain_id = get_domain_id();
        $validation = [
            'name' => 'required',
            'petition' => 'required',
            'date' => 'required',
        ];

        $validator = Validator::make(
                        $request->all(), $validation
        );

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        }
        if (!empty($request->id)) {
            $folder = \App\PetitionUpdates::find($request->id);
            $folder['petition_id'] = $request->petition;
            $folder['updates'] = $request->name;
            $folder['date'] = $request->date;
            $folder->save();
        } else {
            $folder = new \App\PetitionUpdates();
            $folder['user_id'] = $user->id;
            $folder['petition_id'] = $request->petition;
            $folder['updates'] = $request->name;
            $folder['date'] = $request->date;
            $folder->save();
        }
        return redirect()->back()->with('success', __('saved successfully.'));
    }

    public function update_edit($id = 0) {
        $authuser = Auth::user();
        $id = encrypted_key($id, 'decrypt') ?? $id;
        if ($id == '') {
            return redirect()->back()->with('error', __('Id is mismatch.'));
        }
        $update = \App\PetitionUpdates::find($id);
        $authuser = Auth::user();
        $petitions = PetitionForms::where('user_id', $authuser->id)->get();
        return view('contacts.petitionforms.updates.create', compact('authuser', 'petitions', 'update'));
    }

    public function folder_update(Request $request) {
        $domain_id = get_domain_id();
        $folder = ContactFolder::find($request->id);
        $detail['user_id'] = Auth::id();
        $detail['name'] = $domain_id;
        $detail['name'] = $request->name;
        $folder->update($detail);
        return redirect()->to('contacts/folder')->with('success', __('Folder Updated successfully.'));
    }

    public function update_destroy($id) {
        $id = encrypted_key($id, 'decrypt') ?? $id;
        if (empty($id)) {
            return redirect()->back()->with('error', __('Id is mismatch.'));
        }
        $folder = \App\PetitionUpdates::find($id);
        $folder->delete();
        return redirect()->back()->with('success', __('Deleted successfully.'));
    }

}
