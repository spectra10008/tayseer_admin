<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFormFileRequest;
use App\Http\Requests\StoreFormRequestRequest;
use App\Http\Requests\UpdateFormRequestRequest;
use App\Jobs\send_sms_job;
use App\Models\Bank;
use App\Models\Beneficiary;
use App\Models\BeneficiaryProject;
use App\Models\BeneficiaryRequest;
use App\Models\FormNote;
use App\Models\FormRequest;
use App\Models\FormRequestFile;
use App\Models\FormRequestSmsLog;
use App\Models\FundType;
use App\Models\MfiProvider;
use App\Models\MfiNotification;
use App\Models\Project;
use App\Models\Sector;
use App\Models\SocialSituation;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Storage;

class FormRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->user_type_id == 3) {
            $form_requests = FormRequest::where('technical_expert_id',Auth::id())->get();
        } else {
            $form_requests = FormRequest::orderby('id', 'desc')->get();
        }
        return view('form_requests.index')
            ->with('form_requests', $form_requests)
        ;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $beneficiaries = Beneficiary::where('is_active', 1)->get();
        $statuses = SocialSituation::all();
        $banks = Bank::all();
        $types = FundType::all();
        $sectors = Sector::orderby('id', 'desc')->get();
        $mfis = MfiProvider::where('is_active', 1)->get();
        return view('form_requests.create')
            ->with('statuses', $statuses)
            ->with('banks', $banks)
            ->with('sectors', $sectors)
            ->with('types', $types)
            ->with('mfis', $mfis)
            ->with('beneficiaries', $beneficiaries)
        ;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreFormRequestRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFormRequestRequest $request)
    {

        $rand = rand(111111111, 999999999);

        $form_requests = new FormRequest();
        $form_requests->form_request_id = $rand;
        $form_requests->uuid = Str::uuid();
        $form_requests->beneficiary_id = $request->beneficiary_id;
        $form_requests->status_id = 1;
        $form_requests->project_name = $request->project_name;
        $form_requests->fund_type_id = $request->fund_type_id;
        $form_requests->project_sector_id = $request->project_sector_id;
        $form_requests->project_fund_need = $request->project_fund_need;
        $form_requests->project_desc = $request->project_desc;
        $form_requests->notes = $request->notes;
        $form_requests->mfi_provider_id = $request->mfi_provider_id;
        // store files
        if (isset($request->feasibility_study_file) && $request->feasibility_study_file != null) {
            $feasibility_study_file = $request->file('feasibility_study_file')->store('public/form_files/feasibility_studies');
            $form_requests->feasibility_study_file = $feasibility_study_file;
        }
        if (isset($request->personal_image) && $request->personal_image != null) {
            $personal_image = $request->file('personal_image')->store('public/form_files/personal_images');
            $form_requests->personal_image = $personal_image;
        }
        if (isset($request->id_file) && $request->id_file != null) {
            $id_file = $request->file('id_file')->store('public/id_files');
            $form_requests->id_file = $id_file;
        }
        $form_requests->save();

        // end

        toastr()->success('تم حفظ بيانات الطلب بنجاح !!');
        return redirect('/panel-admin/form-requets');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FormRequest  $formRequest
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $formRequest = FormRequest::findOrFail($id);

        if ($formRequest->status_id == 1) {
            $formRequest->status_id = 2;
            $formRequest->update();
        }

        $t_experts = User::where('user_type_id', 3)->where('is_active', 1)->get();
        $mfis = MfiProvider::where('is_active', 1)->get();
        return view('form_requests.show')
            ->with('formRequest', $formRequest)
            ->with('t_experts', $t_experts)
            ->with('mfis', $mfis)
        ;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FormRequest  $formRequest
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $formRequest = FormRequest::find($id);

        $statuses = SocialSituation::all();
        $banks = Bank::all();
        $types = FundType::all();
        $sectors = Sector::orderby('id', 'desc')->get();
        $mfis = MfiProvider::where('is_active', 1)->get();
        $beneficiaries = Beneficiary::where('is_active', 1)->get();

        return view('form_requests.edit')
            ->with('statuses', $statuses)
            ->with('banks', $banks)
            ->with('sectors', $sectors)
            ->with('types', $types)
            ->with('formRequest', $formRequest)
            ->with('mfis', $mfis)
            ->with('beneficiaries', $beneficiaries)
        ;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateFormRequestRequest  $request
     * @param  \App\Models\FormRequest  $formRequest
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFormRequestRequest $request, $id)
    {
        $form_requests = FormRequest::find($id);
        $form_requests->location_on_map = $request->latitude . ',' . $request->longitude;
        $form_requests->project_name = $request->project_name;
        $form_requests->fund_type_id = $request->fund_type_id;
        $form_requests->project_sector_id = $request->project_sector_id;
        $form_requests->project_fund_need = $request->project_fund_need;
        $form_requests->project_desc = $request->project_desc;
        $form_requests->notes = $request->notes;
        $form_requests->mfi_provider_id = $request->mfi_provider_id;
        // store files
        if (isset($request->feasibility_study_file) && $request->feasibility_study_file != null) {
            $feasibility_study_file = $request->file('feasibility_study_file')->store('public/form_files/feasibility_studies');
            $form_requests->feasibility_study_file = $feasibility_study_file;
        }
        if (isset($request->personal_image) && $request->personal_image != null) {
            $personal_image = $request->file('personal_image')->store('public/form_files/personal_images');
            $form_requests->personal_image = $personal_image;
        }
        if (isset($request->id_file) && $request->id_file != null) {
            $id_file = $request->file('id_file')->store('public/id_files');
            $form_requests->id_file = $id_file;
        }
        $form_requests->update();

        toastr()->success('تم تحديث بيانات الطلب بنجاح !!');
        return redirect('/panel-admin/form-requets');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FormRequest  $formRequest
     * @return \Illuminate\Http\Response
     */
    public function destroy(FormRequest $formRequest)
    {
        //
    }

    public function form_sms($request_id)
    {
        $smses = FormRequestSmsLog::where('request_id', $request_id)->orderby('id', 'Desc')->get();

        return view('form_requests.sms.index')
            ->with('smses', $smses)
            ->with('request_id', $request_id)
        ;
    }

    public function form_send_sms(Request $request)
    {
        $request_info = FormRequest::find($request->request_id);
        send_sms_job::dispatch($request_info, $request->sms_content);

        toastr()->success('تم ارسال الرسالة بنجاح !!');
        return back();
    }

    public function form_request_approved(Request $request)
    {
        $request_info = FormRequest::find($request->request_id);
        $request_info->status_id = 3;
        $request_info->update();

        $sms_content = "عزيزنا " . $request_info->name . " , تمت الموافقة على طلبك بالرقم " . $request_info->id . " , " . $request->sms_content;
        send_sms_job::dispatch($request_info, $sms_content);

        $check_beneficiaries = Beneficiary::where('phone', $request_info->phone)->where('email', $request_info->email)->first();
        if ($check_beneficiaries == null) {
            $beneficiaries = new Beneficiary();
            $beneficiaries->name = $request_info->name;
            $beneficiaries->gender = $request_info->gender;
            $beneficiaries->email = $request_info->email;
            $beneficiaries->phone = $request_info->phone;
            $beneficiaries->age = $request_info->age;
            $beneficiaries->id_number = $request_info->id_number;
            $beneficiaries->social_situation_id = $request_info->social_situation_id;
            $beneficiaries->children_no = $request_info->children_no;
            $beneficiaries->address = $request_info->address;
            $beneficiaries->is_bank_account = $request_info->is_bank_account;
            $beneficiaries->location_on_map = $request_info->location_on_map;
            if ($request_info->is_bank_account == 1) {
                $beneficiaries->bank_id = $request_info->bank_id;
                $beneficiaries->branch_name = $request_info->branch_name;
                $beneficiaries->account_no = $request_info->account_no;
            }
            // store files
            $beneficiaries->image = $request_info->personal_image;
            $beneficiaries->id_image = $request_info->id_file;
            // end
            $beneficiaries->save();

            $beneficiary_request = new BeneficiaryRequest();
            $beneficiary_request->request_id = $request->request_id;
            $beneficiary_request->beneficiary_id = $beneficiaries->id;
            $beneficiary_request->save();
        } else {
            $beneficiary_request = new BeneficiaryRequest();
            $beneficiary_request->request_id = $request->request_id;
            $beneficiary_request->beneficiary_id = $check_beneficiaries->id;
            $beneficiary_request->save();
        }

        $project = new Project();
        $project->project_name = $request_info->project_name;
        $project->address = $request_info->address;
        $project->sector_id = $request_info->project_sector_id;
        $project->status = "not_working";
        $project->start_date = Carbon::now();
        $project->fund_amount_need_sdg = $request_info->project_fund_need;
        $project->need = $request_info->project_desc;
        $project->notes = $request_info->notes;
        $project->location = $request_info->location_on_map;
        $project->desc = $request_info->project_desc;
        $project->image = $request_info->personal_image;
        $project->save();

        $beneficiary_project = new BeneficiaryProject();
        if ($check_beneficiaries == null) {
            $beneficiary_project->beneficiary_id = $beneficiaries->id;
        } else {
            $beneficiary_project->beneficiary_id = $check_beneficiaries->id;
        }
        $beneficiary_project->project_id = $project->id;
        $beneficiary_project->save();

        toastr()->success('تم ارسال الرسالة بنجاح !!');
        return back();
    }

    public function form_request_reject(Request $request)
    {
        $request_info = FormRequest::find($request->request_id);
        $request_info->status_id = 4;
        $request_info->update();

        $sms_content = "عزيزنا " . $request_info->name . " , لم تتم الموافقة على طلبك  بالرقم " . $request_info->id . " , " . $request->sms_content;
        send_sms_job::dispatch($request_info, $sms_content);

        toastr()->success('تم ارسال الرسالة بنجاح !!');
        return back();
    }

    public function add_form_requets_file(StoreFormFileRequest $request)
    {
        $request_file = new FormRequestFile();
        $request_file->request_id = $request->request_id;
        $request_file->file_name = $request->file_name;
        if (isset($request->file) && $request->file != null) {
            $file_path = $request->file('file')->store('public/form_files');
            $request_file->file = $file_path;
        }
        $request_file->save();

        toastr()->success('تم الحفظ بنجاح !!');
        return back();
    }

    public function delete_form_requets_file($id)
    {
        $request_file = FormRequestFile::find($id);
        if (Storage::exists($request_file->file)) {
            Storage::delete($request_file->file);
        }
        $request_file->delete();
        toastr()->success('تم الحذف بنجاح !!');
        return back();
    }

    public function transferـreview(Request $request)
    {
        $validated = $request->validate([
            'request_id' => 'required|numeric|exists:form_requests,id',
            'technical_expert_id' => 'required|numeric|exists:users,id',
        ]);

        $request_info = FormRequest::findOrFail($request->request_id);
        $request_info->operation_id = Auth::id();
        $request_info->technical_expert_id = $request->technical_expert_id;
        $request_info->status_id = 3;
        $request_info->update();

        toastr()->success('تم تحويل الطلب للمراجعة بنجاح !!');
        return back();
    }

    public function add_note(Request $request)
    {
        $validated = $request->validate([
            'note' => 'required|string',
            'request_id' => 'required|numeric|exists:form_requests,id',
        ]);

        $form_note = new FormNote();
        $form_note->note = $request->note;
        $form_note->type = Auth::user()->user_type->user_type_desc;
        $form_note->status = 0;
        $form_note->request_id = $request->request_id;
        $form_note->user_id = Auth::id();
        $form_note->save();

        toastr()->success('تم الحفظ بنجاح !!');
        return back();
    }

    public function remove_note($id)
    {
        $form_note = FormNote::findOrFail($id)->delete();

        toastr()->success('تم حذف الملاحظة بنجاح !!');
        return back();
    }

    public function note_change_status($id, $status_id)
    {
        $form_note = FormNote::findOrFail($id);
        $form_note->status = $status_id;
        $form_note->update();

        toastr()->success('تم تحديث الحالة بنجاح !!');
        return back();
    }

    public function transferـmfi(Request $request)
    {
        $validated = $request->validate([
            'request_id' => 'required|numeric|exists:form_requests,id',
            'mfi_provider_id' => 'required|numeric|exists:mfi_providers,id',
        ]);

        $request_info = FormRequest::findOrFail($request->request_id);
        $request_info->mfi_provider_id = $request->mfi_provider_id;
        $request_info->status_id = 4;
        $request_info->update();

        $notification = new MfiNotification();
        $notification->title = 'طلب جديد';
        $notification->content = 'تم تحويل طلب جديد لك  بالرقم '.$request->request_id;
        $notification->type = 1;
        $notification->mfi_provider_id = 1;
        $notification->is_read = $request->mfi_provider_id;
        $notification->save();

        toastr()->success('تم تحويل الطلب لمؤسسة التمويل بنجاح !!');
        return back();
    }
}
