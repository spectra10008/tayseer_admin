<?php

namespace App\Http\Controllers\Providers;

use App\Models\Vendor;
use App\Http\Requests\MfiProviders\StoreVendorRequest;
use App\Http\Requests\MfiProviders\UpdateVendorRequest;
use App\Models\MfiProvider;
use App\Http\Controllers\Controller;
use Auth;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vendors = Vendor::where('mfi_provider_id',Auth::guard('mfis_providers')->user()->mfi_provider_id)->orderby('id','desc')->get();
        return view('mfi_providers.vendors.index')
        ->with('vendors',$vendors)
        ;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $mfis = MfiProvider::where('is_active',1)->get();
        return view('mfi_providers.vendors.create')
        ->with('mfis',$mfis)
        ;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreVendorRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreVendorRequest $request)
    {
        $vendors = new Vendor();
        $vendors->name = $request->name;
        $vendors->email = $request->email;
        $vendors->phone = $request->phone;
        $vendors->address = $request->address;
        $vendors->sale_info = $request->sale_info;
        $vendors->mfi_provider_id = Auth::guard('mfis_providers')->user()->mfi_provider_id;
        $vendors->location = $request->latitude.','.$request->longitude;
        if (isset($request->profile_pic) && $request->profile_pic != null) {
        $path = $request->file('profile_pic')->store('public/vendors');
        $vendors->profile_pic = $path;
        }
        $vendors->save();

        toastr()->success('تم حفظ البيانات بنجاح !!');
        return redirect('/panel-mfi/vendors');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function show(Vendor $vendor)
    {
        if(Auth::guard('mfis_providers')->user()->mfi_provider_id != $vendor->mfi_provider_id)
        {
            toastr()->error('عذراً ، ليس لديك الصلاحية لعرض محتويات التاجر !!');
            return back();
        }

        return view('mfi_providers.vendors.show')
        ->with('vendor',$vendor)
        ;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function edit(Vendor $vendor)
    {
        return view('mfi_providers.vendors.edit')
        ->with('vendor',$vendor)
        ;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateVendorRequest  $request
     * @param  \App\Models\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateVendorRequest $request, Vendor $vendor)
    {
        $vendor->name = $request->name;
        $vendor->email = $request->email;
        $vendor->phone = $request->phone;
        $vendor->address = $request->address;
        $vendor->sale_info = $request->sale_info;
        $vendor->location = $request->latitude.','.$request->longitude;
        if(isset($request->profile_pic) && $request->profile_pic != null)
        {
            $path = $request->file('profile_pic')->store('public/vendors');
            $vendor->profile_pic = $path;
        }
        $vendor->save();

        toastr()->success('تم تعديل البيانات بنجاح !!');
        return redirect('/panel-mfi/vendors');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vendor $vendor)
    {
        $vendor->delete();

        toastr()->success('تم حذف البيانات بنجاح !!');
        return redirect('/panel-mfi/vendors');
    }
}
