<?php

namespace App\Http\Controllers;

use App\Models\Beneficiary;
use App\Models\FormRequest;
use App\Models\Installment;
use App\Http\Requests\StoreInstallmentRequest;
use App\Http\Requests\UpdateInstallmentRequest;
use Auth;
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

        return view('installments.index')
        ->with('installments',$installments)
        ->with('beneficiaries',$beneficiaries)
        ->with('form_requests',$form_requests)
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
        $installments->added_by = Auth::id();
        $installments->request_id = $request->request_id;
        $installments->beneficiary_id = $request->beneficiary_id;
        $installments->deserved_amount =  $request->deserved_amount;
        $installments->date_payment_installment =  $request->date_payment_installment;
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
        //
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
        //
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
}
