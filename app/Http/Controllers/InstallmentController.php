<?php

namespace App\Http\Controllers;

use App\Models\Beneficiary;
use App\Models\FormRequest;
use App\Models\InstallmentStatus;
use App\Models\MfiProvider;
use App\Models\Loan;
use App\Models\Installment;
use App\Http\Requests\StoreInstallmentRequest;
use App\Http\Requests\UpdateInstallmentRequest;
use App\Http\Requests\StoreInstallmentSystemRequest;
use Auth;
use Carbon\Carbon;

class InstallmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $installments = Installment::all();
        $beneficiaries = Beneficiary::orderby('id', 'desc')->get();
        $form_requests = FormRequest::where('status_id',3)->get();
        $loans = Loan::all();
        $mfis = MfiProvider::where('is_active',1)->get();

        return view('installments.index')
        ->with('installments',$installments)
        ->with('beneficiaries',$beneficiaries)
        ->with('form_requests',$form_requests)
        ->with('loans',$loans)
        ->with('mfis',$mfis)
        ;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreInstallmentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreInstallmentRequest $request)
    {
        $installments = new Installment();
        $installments->payment_receipt_number = rand(11111,99999);
        // $installments->added_by = Auth::id();
        $installments->loan_id = $request->loan_id;
        $installments->deserved_amount =  $request->deserved_amount;
        $installments->date_payment_installment =  $request->date_payment_installment;
        $installments->mfi_provider_id =  $request->mfi_provider_id;
        $installments->status_id =  1;
        $installments->save();

        toastr()->success('تم حفظ بيانات القسط بنجاح !!');
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Installment  $installment
     * @return \Illuminate\Http\Response
     */
    public function show(Installment $installment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Installment  $installment
     * @return \Illuminate\Http\Response
     */
    public function edit(Installment $installment)
    {
        $beneficiaries = Beneficiary::orderby('id', 'desc')->get();
        $form_requests = FormRequest::where('status_id',3)->get();
        $statuses = InstallmentStatus::all();
        $loans = Loan::all();
        $mfis = MfiProvider::where('is_active',1)->get();

        return view('installments.edit')
        ->with('installment',$installment)
        ->with('beneficiaries',$beneficiaries)
        ->with('form_requests',$form_requests)
        ->with('loans',$loans)
        ->with('statuses',$statuses)
        ->with('mfis',$mfis)
        ;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateInstallmentRequest  $request
     * @param  \App\Models\Installment  $installment
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateInstallmentRequest $request, Installment $installment)
    {
        $installment->deserved_amount =  $request->deserved_amount;
        $installment->date_payment_installment =  $request->date_payment_installment;
        $installment->status_id =  $request->status_id;
        $installment->mfi_provider_id =  $request->mfi_provider_id;
        if (isset($request->receipt_file) && $request->receipt_file != null) {
            $file_path = $request->file('receipt_file')->store('public/installment_files');
            $installment->receipt_file = $file_path;
        }
        $installment->save();

        toastr()->success('تم تعديل بيانات القسط بنجاح !!');
        return redirect('/panel-admin/installments');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Installment  $installment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Installment $installment)
    {
        //
    }


    public function system_installments(StoreInstallmentSystemRequest $request, Installment $installment)
    {
        $i = 0;
        for($i; $i<$request->installments_no; $i++)
        {
            $installments = new Installment();
            $installments->payment_receipt_number = rand(11111,99999);
            $installments->mfi_provider_id =  $request->mfi_provider_id;
            $installments->added_by = Auth::id();
            $installments->loan_id = $request->loan_id;
            $installments->deserved_amount =  $request->deserved_amount/$request->installments_no;
            $installments->date_payment_installment =  Carbon::parse($request->date_payment_installment)->addMonths($i);
            $installments->status_id =  1;
            $installments->save();

        }

        toastr()->success('تم انشاء بيانات الاقساط بنجاح !!');
        return back();

    }
}
