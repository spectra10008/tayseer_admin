<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\Beneficiary;
use App\Models\FormRequest;
use App\Http\Requests\StoreBankRequest;
use App\Http\Requests\UpdateBankRequest;

class BankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banks = Bank::all();
        return view('banks.index')
        ->with('banks',$banks)
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
     * @param  \App\Http\Requests\StoreBankRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBankRequest $request)
    {
        $banks = new Bank();
        $banks->bank_name = $request->bank_name;
        $banks->save();

        toastr()->success('تم الحفظ بنجاح !!');
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function show(Bank $bank)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function edit(Bank $bank)
    {
        return view('banks.edit')
        ->with('bank',$bank)
        ;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateBankRequest  $request
     * @param  \App\Models\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBankRequest $request, Bank $bank)
    {
        $bank->bank_name = $request->bank_name;
        $bank->update();

        toastr()->success('تم تحديث البيانات بنجاح !!');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bank $bank)
    {
        $beneficiary = Beneficiary::where('bank_id',$bank->id)->first();
        $form_request = FormRequest::where('bank_id',$bank->id)->first();
        if($beneficiary || $form_request)
        {
            toastr()->error(' لا يمكنك حذف البنك  ,البنك مرتبط ببيانات اخرى !!');
            return back();
        }
        $bank->delete();

        toastr()->success('تم الحذف بنجاح !!');
        return back();
    }
}
