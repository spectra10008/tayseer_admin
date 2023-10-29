<?php

namespace App\Http\Controllers\Providers;

use App\Http\Requests\StoreFormFileRequest;
use App\Http\Requests\StoreFormRequestRequest;
use App\Http\Requests\UpdateFormRequestRequest;
use App\Jobs\send_sms_job;
use App\Models\Bank;
use App\Models\Beneficiary;
use App\Models\BeneficiaryProject;
use App\Models\BeneficiaryRequest;
use App\Models\MfiFormNote;
use App\Models\FormRequest;
use App\Models\FormRequestFile;
use App\Models\FormRequestSmsLog;
use App\Models\FundType;
use App\Models\MfiProvider;
use App\Models\Project;
use App\Models\Sector;
use App\Models\SocialSituation;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Storage;
use App\Http\Controllers\Controller;
class FormRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $form_requests = FormRequest::where('mfi_provider_id',Auth::guard('mfis_providers')->user()->mfi_provider_id)->get();

        return view('mfi_providers.form_requests.index')
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
        ;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreFormRequestRequest  $request
     * @return \Illuminate\Http\Response
     */


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FormRequest  $formRequest
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $formRequest = FormRequest::findOrFail($id);
        if(Auth::guard('mfis_providers')->user()->mfi_provider_id != $formRequest->mfi_provider_id)
        {
            toastr()->error('عذراً ، ليس لديك الصلاحية لعرض تفاصيل الملف !!');
            return back();
        }

        if ($formRequest->status_id == 1) {
            $formRequest->status_id = 2;
            $formRequest->update();
        }

        return view('mfi_providers.form_requests.show')
            ->with('formRequest', $formRequest)
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

        return view('form_requests.edit')
            ->with('statuses', $statuses)
            ->with('banks', $banks)
            ->with('sectors', $sectors)
            ->with('types', $types)
            ->with('formRequest', $formRequest)
            ->with('mfis', $mfis)
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
        $form_requests->name = $request->name;
        $form_requests->gender = $request->gender;
        $form_requests->email = $request->email;
        $form_requests->phone = $request->phone;
        $form_requests->age = $request->age;
        $form_requests->id_number = $request->id_number;
        $form_requests->social_situation_id = $request->social_situation_id;
        $form_requests->children_no = $request->children_no;
        $form_requests->address = $request->address;
        $form_requests->is_bank_account = $request->is_bank_account;
        $form_requests->location_on_map = $request->latitude . ',' . $request->longitude;
        if ($request->is_bank_account == 1) {
            $form_requests->bank_id = $request->bank_id;
            $form_requests->branch_name = $request->branch_name;
            $form_requests->account_no = $request->account_no;
        }
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

        return view('mfi_providers.form_requests.sms.index')
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
        $request_info->status_id = 5;
        $request_info->update();

        $sms_content = "عزيزنا " . $request_info->name . " , تمت الموافقة على طلبك بالرقم " . $request_info->id . " , " . $request->sms_content;
        send_sms_job::dispatch($request_info, $sms_content);

        toastr()->success('تم ارسال الرسالة بنجاح !!');
        return back();
    }

    public function form_request_reject(Request $request)
    {
        $request_info = FormRequest::find($request->request_id);
        $request_info->status_id = 6;
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

        $form_note = new MfiFormNote();
        $form_note->note = $request->note;
        $form_note->status = 0;
        $form_note->form_request_id = $request->request_id;
        $form_note->mfi_provider_id = $request->mfi_provider_id;
        $form_note->mfi_provider_user_id = Auth::guard('mfis_providers')->id();
        $form_note->save();

        toastr()->success('تم الحفظ بنجاح !!');
        return back();
    }

    public function remove_note($id)
    {
        $form_note = MfiFormNote::findOrFail($id)->delete();

        toastr()->success('تم حذف الملاحظة بنجاح !!');
        return back();
    }

    public function note_change_status($id, $status_id)
    {
        $form_note = MfiFormNote::findOrFail($id);
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

        toastr()->success('تم تحويل الطلب لمؤسسة التمويل بنجاح !!');
        return back();
    }
}
