<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Sector;
use App\Models\FormRequest;
use App\Http\Requests\StoreSectorRequest;
use App\Http\Requests\UpdateSectorRequest;

class SectorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sectors = Sector::all();
        return view('sectors.index')
        ->with('sectors',$sectors)
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
     * @param  \App\Http\Requests\StoreSectorRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSectorRequest $request)
    {
        $sector = new Sector();
        $sector->sector_desc = $request->sector_desc;
        $sector->save();

        toastr()->success('تم الحفظ بنجاح !!');
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sector  $sector
     * @return \Illuminate\Http\Response
     */
    public function show(Sector $sector)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sector  $sector
     * @return \Illuminate\Http\Response
     */
    public function edit(Sector $sector)
    {
        return view('sectors.edit')
        ->with('sector',$sector)
        ;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSectorRequest  $request
     * @param  \App\Models\Sector  $sector
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSectorRequest $request, Sector $sector)
    {
        $sector->sector_desc = $request->sector_desc;
        $sector->update();

        toastr()->success('تم التعديل بنجاح !!');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sector  $sector
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sector $sector)
    {
        $projects = Project::where('sector_id',$sector->id)->first();
        $form_request = FormRequest::where('project_sector_id',$sector->id)->first();
        if($projects || $form_request)
        {
            toastr()->error(' لا يمكنك حذف القطاع  ,القطاع مرتبط ببيانات اخرى !!');
            return back();
        }
        $sector->delete();

        toastr()->success('تم الحذف بنجاح !!');
        return back();
    }
}
