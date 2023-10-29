<?php

namespace App\Http\Controllers;

use App\Models\FormRequest;
use App\Models\Loan;
use App\Models\User;
use App\Models\MfiProvider;
use App\Models\LoanProduct;
use App\Models\LoanStatus;
use App\Models\MfiProviderUser;
use App\Http\Requests\StoreLoanRequest;
use App\Http\Requests\UpdateLoanRequest;

class LoanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $loans = Loan::orderby('id', 'desc')->get();

        return view('Loans.index')
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
        $form_requests = FormRequest::orderby('id', 'desc')->where('status_id',3)->get();
        $products = LoanProduct::all();
        $mfis = MfiProvider::where('is_active',1)->get();
        $users = MfiProviderUser::where('is_active',1)->get();
        return view('Loans.create')
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
        $loan->mfi_provider_id = $request->mfi_provider_id;
        $loan->status_id = 1;
        if (isset($request->loan_file) && $request->loan_file != null) {
            $loan_file = $request->file('loan_file')->store('public/loan_files');
            $loan->loan_file = $loan_file;
        }
        $loan->save();

        toastr()->success('تم الحفظ بنجاح !!');
        return redirect('/panel-admin/loans');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function show(Loan $loan)
    {
        return view('Loans.show')
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
        $users = User::where('user_type_id',1)->get();
        $statuses = LoanStatus::all();
        $mfis = MfiProvider::where('is_active',1)->get();

        return view('Loans.edit')
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
        $loan->mfi_provider_id = $request->mfi_provider_id;
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
        return redirect('/panel-admin/loans');
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
