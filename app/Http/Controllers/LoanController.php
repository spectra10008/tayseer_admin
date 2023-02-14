<?php

namespace App\Http\Controllers;

use App\Models\FormRequest;
use App\Models\Loan;
use App\Models\User;
use App\Models\LoanProduct;
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
        $form_requests = FormRequest::orderby('id', 'desc')->get();
        $products = LoanProduct::all();
        $users = User::where('user_type_id',1)->get();

        return view('Loans.create')
        ->with('form_requests', $form_requests)
        ->with('products', $products)
        ->with('users', $users)
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function show(Loan $loan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function edit(Loan $loan)
    {
        //
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
        //
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
