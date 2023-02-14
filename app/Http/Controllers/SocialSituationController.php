<?php

namespace App\Http\Controllers;

use App\Models\SocialSituation;
use App\Models\Beneficiary;
use App\Models\FormRequest;
use App\Http\Requests\StoreSocialSituationRequest;
use App\Http\Requests\UpdateSocialSituationRequest;

class SocialSituationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $social_situations = SocialSituation::all();
        return view('social_situations.index')
        ->with('social_situations',$social_situations)
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
     * @param  \App\Http\Requests\StoreSocialSituationRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSocialSituationRequest $request)
    {
        $social_situations = new SocialSituation();
        $social_situations->situation_desc = $request->situation_desc;
        $social_situations->save();

        toastr()->success('تم الحفظ بنجاح !!');
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SocialSituation  $socialSituation
     * @return \Illuminate\Http\Response
     */
    public function show(SocialSituation $socialSituation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SocialSituation  $socialSituation
     * @return \Illuminate\Http\Response
     */
    public function edit(SocialSituation $socialSituation)
    {
        return view('social_situations.edit')
        ->with('socialSituation',$socialSituation)
        ;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSocialSituationRequest  $request
     * @param  \App\Models\SocialSituation  $socialSituation
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSocialSituationRequest $request, SocialSituation $socialSituation)
    {
        $socialSituation->situation_desc = $request->situation_desc;
        $socialSituation->update();

        toastr()->success('تم التعديل بنجاح !!');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SocialSituation  $socialSituation
     * @return \Illuminate\Http\Response
     */
    public function destroy(SocialSituation $socialSituation)
    {
        $beneficiary = Beneficiary::where('social_situation_id',$socialSituation->id)->first();
        $form_request = FormRequest::where('social_situation_id',$socialSituation->id)->first();
        if($beneficiary || $form_request)
        {
            toastr()->error(' لا يمكنك حذف الحالة الاجتماعية ,الحالة الاجتماعية مرتبطة ببيانات اخرى !!');
            return back();
        }
        $socialSituation->delete();

        toastr()->success('تم الحذف بنجاح !!');
        return back();
    }
}
