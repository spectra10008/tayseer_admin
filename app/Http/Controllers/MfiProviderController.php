<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMfiProviderRequest;
use App\Http\Requests\UpdateMfiProviderRequest;
use App\Models\MfiProvider;
use App\Models\FormRequest;
use App\Models\Installment;
use App\Models\Loan;
use App\Models\MfiProviderUser;
use App\Models\Vendor;

class MfiProviderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mfis = MfiProvider::orderby('id', 'desc')->get();
        return view('mfis.index')
            ->with('mfis', $mfis)
        ;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('mfis.create')
        ;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreMfiProviderRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMfiProviderRequest $request)
    {

        $mfiProvider = new MfiProvider();
        $mfiProvider->name_ar = $request->name_ar;
        $mfiProvider->name_en = $request->name_en;
        $mfiProvider->business_email = $request->business_email;
        $mfiProvider->phone = $request->phone;
        $mfiProvider->description_ar = $request->description_ar;
        $mfiProvider->description_en = $request->description_en;
        $mfiProvider->address = $request->address;
        $mfiProvider->is_active = $request->is_active;
        if (isset($request->profile_pic) && $request->profile_pic != null) {
            $path = $request->file('profile_pic')->store('mfis_profiles', 'public');
            // $mfiProfile_pic = $request->file('profile_pic')->store('public/mfisProfilePic');
            $mfiProvider->profile_pic = $path;
        }
        $mfiProvider->save();

        toastr()->success('تم الحفظ بنجاح !!');
        return redirect('/panel-admin/mfis');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MfiProvider  $mfiProvider
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $mfiProvider = MfiProvider::findOrFail($id);

        return view('mfis.show')
            ->with('mfiProvider', $mfiProvider)
        ;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MfiProvider  $mfiProvider
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $mfiProvider = MfiProvider::findOrFail($id);
        return view('mfis.edit')
            ->with('mfiProvider', $mfiProvider)
        ;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMfiProviderRequest  $request
     * @param  \App\Models\MfiProvider  $mfiProvider
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMfiProviderRequest $request, $id)
    {
        $mfiProvider = MfiProvider::findOrFail($id);
        $mfiProvider->name_ar = $request->name_ar;
        $mfiProvider->name_en = $request->name_en;
        $mfiProvider->business_email = $request->business_email;
        $mfiProvider->phone = $request->phone;
        $mfiProvider->description_ar = $request->description_ar;
        $mfiProvider->description_en = $request->description_en;
        $mfiProvider->address = $request->address;
        $mfiProvider->is_active = $request->is_active;
        if (isset($request->profile_pic) && $request->profile_pic != null) {
            $path = $request->file('profile_pic')->store('mfis_profiles', 'public');
            // $mfiProfile_pic = $request->file('profile_pic')->store('public/mfisProfilePic');
            $mfiProvider->profile_pic = $path;
        }
        $mfiProvider->update();

        toastr()->success('تم التعديل بنجاح !!');
        return redirect('/panel-admin/mfis');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MfiProvider  $mfiProvider
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $requests = FormRequest::where('mfi_provider_id',$id)->first();
        $installments = Installment::where('mfi_provider_id',$id)->first();
        $loans = Loan::where('mfi_provider_id',$id)->first();
        $users = MfiProviderUser::where('mfi_provider_id',$id)->first();
        $vendors = Vendor::where('mfi_provider_id',$id)->first();

        if($vendors != null && $requests != null && $installments != null && $loans != null && $users != null)
        {
            toastr()->error('لا يمكنك حذف المؤسسة ، المؤسسة مرتبطة ببيانات اخرى  !!');
            return back();
        }
        $mfiProvider = MfiProvider::findOrFail($id)->delete();

        toastr()->success('تم الحذف بنجاح !!');
        return redirect('/panel-admin/mfis');
    }
}
