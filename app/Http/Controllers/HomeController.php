<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WebsiteVisitor;
use App\Models\FormRequest;
use App\Models\Loan;
use App\Models\Beneficiary;
use App\Models\Notification;
use App\Models\Installment;
use App\Models\Project;
use App\Models\MfiProvider;
use DB;
use Auth;
use Carbon\Carbon;
class HomeController extends Controller
{
    public function index()
    {
        $form_requests = FormRequest::all();
        $loans = Loan::all();
        $beneficiaries = Beneficiary::all();
        $installments = Installment::all();
        $visitors = WebsiteVisitor::all();
        $projects = Project::all();
        $mfis = MfiProvider::all();

        $sites_visites = WebsiteVisitor::select(DB::raw('count(ip_address) as ip_address_visites'), DB::raw('visit_date'))->where('visit_date', '>', Carbon::now()->subDays(15))->groupBy('visit_date')->get();
        $all_sites_visites = WebsiteVisitor::select(DB::raw('count(ip_address) as ip_address_visites'), DB::raw('visit_date'))->groupBy('visit_date')->get();
        $sites_visites_hours = WebsiteVisitor::select(DB::raw('count(ip_address) as ip_address_visites_hours'), DB::raw('DATE_FORMAT(created_at, "%H") as date_time'))->where('created_at', '>', Carbon::now()->subDays(15))->groupByRaw('date_time')->get();

        $hours_visites_count = [];
        $visit_hours = [];

        foreach ($sites_visites_hours as $sites_visites_hour) {
            $hours_visites_count[] = $sites_visites_hour->ip_address_visites_hours;
            $visit_hours[] = $sites_visites_hour->date_time;
        }

        $visites_count = [];
        $visit_dates = [];
        foreach ($sites_visites as $key => $sites_visite) {
            $visites_count[] = $sites_visite->ip_address_visites;
            $visit_dates[] = $sites_visite->visit_date;
        }
        $visites_count = implode(',', $visites_count);
        $visit_dates = implode(',', $visit_dates);

        $sites_visites_count = WebsiteVisitor::count('id');

        $review_requests = FormRequest::where('technical_expert_id',Auth::id())->get();

        return view('dashboard')
            ->with('form_requests', $form_requests)
            ->with('loans', $loans)
            ->with('beneficiaries', $beneficiaries)
            ->with('installments', $installments)
            ->with('projects', $projects)
            ->with('visitors', $visitors)
            ->with('sites_visites', $sites_visites)
            ->with('all_sites_visites', $all_sites_visites)
            ->with('visites_count', $visites_count)
            ->with('visit_dates', $visit_dates)
            ->with('hours_visites_count', $hours_visites_count)
            ->with('visit_hours', $visit_hours)
            ->with('sites_visites_count', $sites_visites_count)
            ->with('review_requests', $review_requests)
            ->with('mfis', $mfis)
        ;
    }

    public function notifications()
    {
        $notifications =  Notification::orderby('id','Desc')->get();
        return view('notifications')
        ->with('notifications', $notifications)
        ;
    }

    public function notification_read()
    {
        $notifications =  Notification::where('is_read',1)->get();
        foreach($notifications as $notification)
        {
            $update_read = Notification::find($notification->id);
            $update_read->is_read = 0;
            $update_read->update();
        }

        return view('notifications')
        ->with('notifications', $notifications)
        ;
    }
}
