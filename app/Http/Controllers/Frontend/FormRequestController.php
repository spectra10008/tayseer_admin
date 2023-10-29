<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SocialSituation;
use App\Models\Bank;
use App\Models\FormRequest;
use App\Models\Notification;
use App\Models\FundType;
use App\Models\Sector;
use App\Models\WebsiteVisitor;
use App\Http\Requests\StoreFrontFundRequest;
use Illuminate\Support\Str;
use Carbon\Carbon;
class FormRequestController extends Controller
{
    public function index()
    {
        $statuses = SocialSituation::all();
        $banks = Bank::all();
        $types = FundType::all();
        $sectors = Sector::orderby('id', 'desc')->get();

        $check_ips = WebsiteVisitor::whereDate('created_at',Carbon::today())->get();
        $ips = [];
        foreach ($check_ips as $key => $check_ip) { $ips[] = $check_ip->ip_address; }
        if(!in_array(request()->ip() , $ips ))
        {
            $new_site_visitor = new WebsiteVisitor();
            $new_site_visitor->ip_address = request()->ip();
            $new_site_visitor->visit_date = Carbon::today()->format('Y-m-d');
            $new_site_visitor->save();
        }

        return view('frontend.form_request.index')
        ->with('statuses',$statuses)
        ->with('banks',$banks)
        ->with('types',$types)
        ->with('sectors',$sectors)
        ;
    }

    public function store(StoreFrontFundRequest $request)
    {
        $rand = rand(111111111,999999999);

        $form_requests = new FormRequest();
        $form_requests->form_request_id = $rand;
        $form_requests->uuid = Str::uuid();
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
        $form_requests->status_id = 1;
        $form_requests->project_name = $request->project_name;
        $form_requests->fund_type_id = $request->fund_type_id;
        $form_requests->project_sector_id = $request->project_sector_id;
        $form_requests->project_fund_need = $request->project_fund_need;
        $form_requests->project_desc = $request->project_desc;
        $form_requests->notes = $request->notes;
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


        $notification = new Notification();
        $notification->title = 'طلب جديد';
        $notification->content = 'قام '.$form_requests->name.' بطلب تمويل جديد بالرقم '.$rand;
        $notification->type = 'NewFund';
        $notification->is_read = 1;
        $notification->save();

        toastr()->success('تم حفظ بيانات الطلب بنجاح !!');
        return redirect('/result');
    }

    public function result()
    {
        return view('frontend.form_request.result')
        ;
    }
}
