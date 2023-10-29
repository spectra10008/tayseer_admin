<?php

namespace App\Http\Controllers\Providers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WebsiteVisitor;
use App\Models\FormRequest;
use App\Models\Loan;
use App\Models\Beneficiary;
use App\Models\MfiNotification;
use App\Models\Installment;
use App\Models\Project;
use App\Models\Vendor;
use App\Models\MfiProviderUser;
use App\Models\MfiProvider;
use DB;
use Auth;
use Carbon\Carbon;
class HomeController extends Controller
{
    public function index()
    {
        $form_requests = FormRequest::where('mfi_provider_id',Auth::user()->mfi_provider_id)->get();
        $loans = Loan::where('mfi_provider_id',Auth::user()->mfi_provider_id)->get();
        $installments = Installment::where('mfi_provider_id',Auth::user()->mfi_provider_id)->get();
        $vendors = Vendor::where('mfi_provider_id',Auth::guard('mfis_providers')->user()->mfi_provider_id)->orderby('id','desc')->get();
        $users = MfiProviderUser::where('mfi_provider_id',Auth::guard('mfis_providers')->user()->mfi_provider_id)->orderBy('id','Desc')->where('id','!=',1)->get();

        $latest_form_requests = FormRequest::where('mfi_provider_id',Auth::user()->mfi_provider_id)->where('status_id',4)->get();


        return view('mfi_providers.dashboard')
            ->with('form_requests', $form_requests)
            ->with('loans', $loans)
            ->with('installments', $installments)
            ->with('latest_form_requests', $latest_form_requests)
            ->with('vendors', $vendors)
            ->with('users', $users)
        ;
    }

    public function notifications()
    {
        $notifications =  MfiNotification::where('mfi_provider_id',Auth::guard('mfis_providers')->user()->mfi_provider_id)->orderby('id','Desc')->get();
        return view('mfi_providers.notifications')
        ->with('notifications', $notifications)
        ;
    }

    public function notification_read()
    {
        $notifications =  MfiNotification::where('is_read',1)->get();
        foreach($notifications as $notification)
        {
            $update_read = MfiNotification::find($notification->id);
            $update_read->is_read = 0;
            $update_read->update();
        }

        return true ;
    }
}
