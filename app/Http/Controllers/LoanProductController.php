<?php

namespace App\Http\Controllers;

use App\Models\LoanProduct;
use App\Models\Loan;
use App\Http\Requests\StoreLoanProductRequest;
use App\Http\Requests\UpdateLoanProductRequest;

class LoanProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $loans_products = LoanProduct::orderby('id', 'desc')->get();

        return view('loans_products.index')
            ->with('loans_products', $loans_products)
        ;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('loans_products.create')
        ;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreLoanProductRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLoanProductRequest $request)
    {
        $loans_products = new LoanProduct();
        $loans_products->product_name = $request->product_name;
        $loans_products->product_desc = $request->product_desc;
        $loans_products->product_requirments = $request->product_requirments;
        $loans_products->save();

        toastr()->success('تم الحفظ بنجاح !!');
        return redirect('/panel-admin/loans-products');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LoanProduct  $loanProduct
     * @return \Illuminate\Http\Response
     */
    public function show(LoanProduct $loanProduct)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LoanProduct  $loanProduct
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $loanProduct = LoanProduct::find($id);

        return view('loans_products.edit')
            ->with('loanProduct', $loanProduct)
        ;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateLoanProductRequest  $request
     * @param  \App\Models\LoanProduct  $loanProduct
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLoanProductRequest $request, $id)
    {
        $loanProduct = LoanProduct::find($id);
        $loanProduct->product_name = $request->product_name;
        $loanProduct->product_desc = $request->product_desc;
        $loanProduct->product_requirments = $request->product_requirments;
        $loanProduct->save();

        toastr()->success('تم تحديث بنجاح !!');
        return redirect('/panel-admin/loans-products');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LoanProduct  $loanProduct
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $loan = Loan::where('product_id',$id)->first();
        if($loan)
        {
            toastr()->error(' لا يمكنك حذف المنتج  ,المنتج مرتبط ببيانات اخرى !!');
            return back();
        }
        $loanProduct = LoanProduct::find($id)->delete();

        toastr()->success('تم الحذف بنجاح !!');
        return back();
    }
}
