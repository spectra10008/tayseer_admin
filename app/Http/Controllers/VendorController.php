<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use App\Http\Requests\StoreVendorRequest;
use App\Http\Requests\UpdateVendorRequest;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vendors = Vendor::orderby('id','desc')->get();
        return view('vendors.index')
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
        return view('vendors.create')
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
        $vendors->location = $request->latitude.','.$request->longitude;
        $path = $request->file('profile_pic')->store('public/vendors');
        $vendors->profile_pic = $path;
        $vendors->save();

        toastr()->success('تم حفظ البيانات بنجاح !!');
        return redirect('/panel-admin/vendors');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function show(Vendor $vendor)
    {
        return view('vendors.show')
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
        return view('vendors.edit')
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
        return back();
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
        return redirect('/panel-admin/vendors');
    }
}
