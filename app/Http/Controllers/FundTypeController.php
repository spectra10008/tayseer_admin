<?php

namespace App\Http\Controllers;

use App\Models\FundType;
use App\Models\FormRequest;
use App\Http\Requests\StoreFundTypeRequest;
use App\Http\Requests\UpdateFundTypeRequest;

class FundTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $types = FundType::all();

        return view('fund_types.index')
        ->with('types',$types)
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
     * @param  \App\Http\Requests\StoreFundTypeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFundTypeRequest $request)
    {
        $types = new FundType();
        $types->type_name = $request->type_name;
        $types->save();

        toastr()->success('تم الحفظ بنجاح !!');
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FundType  $fundType
     * @return \Illuminate\Http\Response
     */
    public function show(FundType $fundType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FundType  $fundType
     * @return \Illuminate\Http\Response
     */
    public function edit(FundType $fundType)
    {
        return view('fund_types.edit')
        ->with('fundType',$fundType)
        ;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateFundTypeRequest  $request
     * @param  \App\Models\FundType  $fundType
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFundTypeRequest $request, FundType $fundType)
    {
        $fundType->type_name = $request->type_name;
        $fundType->update();

        toastr()->success('تم التعديل بنجاح !!');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FundType  $fundType
     * @return \Illuminate\Http\Response
     */
    public function destroy(FundType $fundType)
    {
        $form_request = FormRequest::where('fund_type_id',$fundType->id)->first();
        if($form_request)
        {
            toastr()->error(' لا يمكنك حذف نوع التمويل  ,نوع التمويل مرتبط ببيانات اخرى !!');
            return back();
        }
        $fundType->delete();

        toastr()->success('تم الحذف بنجاح !!');
        return back();
    }
}
