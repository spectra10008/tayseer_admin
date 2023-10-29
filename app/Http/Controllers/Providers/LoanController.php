<?php

namespace App\Http\Controllers\Providers;

use App\Models\FormRequest;
use App\Models\Loan;
use App\Models\MfiProviderUser;
use App\Models\MfiProvider;
use App\Models\LoanProduct;
use App\Models\LoanStatus;
use App\Http\Requests\MfiProviders\StoreLoanRequest;
use App\Http\Requests\MfiProviders\UpdateLoanRequest;
use App\Http\Controllers\Controller;
use Auth;
class LoanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $loans = Loan::where('mfi_provider_id',Auth::guard('mfis_providers')->user()->mfi_provider_id)->orderby('id', 'desc')->get();

        return view('mfi_providers.Loans.index')
            ->with('loans', $loans)
        ;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $form_requests = FormRequest::where('mfi_provider_id',Auth::guard('mfis_providers')->user()->mfi_provider_id)->where('status_id',5)->get();
        $products = LoanProduct::all();
        $users = MfiProviderUser::where('is_active',1)->orderBy('id','Desc')->get();
        $mfis = MfiProvider::where('is_active',1)->get();

        return view('mfi_providers.Loans.create')
        ->with('form_requests', $form_requests)
        ->with('products', $products)
        ->with('users', $users)
        ->with('mfis', $mfis)
        ;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreLoanRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLoanRequest $request)
    {

        $rand = rand(11111,99999);

        $loan = new Loan();
        $loan->loan_no = '23'.$rand;
        $loan->request_id = $request->request_id;
        $loan->product_id = $request->product_id;
        $loan->loan_amount = $request->loan_amount;
        $loan->loan_interest_per = $request->loan_interest_per;
        $loan->released_date = $request->released_date;
        $loan->loan_interest = $request->loan_interest;
        $loan->loan_duration = $request->loan_duration;
        $loan->description = $request->description;
        $loan->loan_manager = $request->loan_manager;
        $loan->mfi_provider_id = Auth::guard('mfis_providers')->user()->mfi_provider_id;
        $loan->status_id = 1;
        if (isset($request->loan_file) && $request->loan_file != null) {
            $loan_file = $request->file('loan_file')->store('public/loan_files');
            $loan->loan_file = $loan_file;
        }
        $loan->save();

        toastr()->success('تم الحفظ بنجاح !!');
        return redirect('/panel-mfi/loans');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function show(Loan $loan)
    {
        if(Auth::guard('mfis_providers')->user()->mfi_provider_id != $loan->mfi_provider_id)
        {
            toastr()->error('عذراً ، ليس لديك الصلاحية لعرض محتويات القرض !!');
            return back();
        }
        return view('mfi_providers.Loans.show')
        ->with('loan', $loan)
        ;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function edit(Loan $loan)
    {
        $form_requests = FormRequest::orderby('id', 'desc')->get();
        $products = LoanProduct::all();
        $users = MfiProviderUser::where('is_active',1)->orderBy('id','Desc')->get();
        $statuses = LoanStatus::all();
        $mfis = MfiProvider::where('is_active',1)->get();

        return view('mfi_providers.Loans.edit')
        ->with('loan', $loan)
        ->with('statuses', $statuses)
        ->with('form_requests', $form_requests)
        ->with('products', $products)
        ->with('users', $users)
        ->with('mfis', $mfis)
        ;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateLoanRequest  $request
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLoanRequest $request, Loan $loan)
    {
        $loan->request_id = $request->request_id;
        $loan->product_id = $request->product_id;
        $loan->loan_amount = $request->loan_amount;
        $loan->loan_interest_per = $request->loan_interest_per;
        $loan->released_date = $request->released_date;
        $loan->loan_interest = $request->loan_interest;
        $loan->loan_duration = $request->loan_duration;
        $loan->description = $request->description;
        $loan->loan_manager = $request->loan_manager;
        $loan->status_id = $request->status_id;
        if (isset($request->loan_file) && $request->loan_file != null) {
            $loan_file = $request->file('loan_file')->store('public/loan_files');
            $loan->loan_file = $loan_file;
        }
        $loan->update();

        toastr()->success('تم الحفظ بنجاح !!');
        return redirect('/panel-mfi/loans');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Loan $loan)
    {
        //
    }
}
