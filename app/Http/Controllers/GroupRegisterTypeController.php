<?php

namespace App\Http\Controllers;

use App\Models\GroupRegisterType;
use App\Models\Group;
use App\Http\Requests\StoreGroupRegisterTypeRequest;
use App\Http\Requests\UpdateGroupRegisterTypeRequest;

class GroupRegisterTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $types = GroupRegisterType::all();

        return view('group_register_types.index')
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
     * @param  \App\Http\Requests\StoreGroupRegisterTypeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGroupRegisterTypeRequest $request)
    {
        $types = new GroupRegisterType();
        $types->type_desc = $request->type_desc;
        $types->save();

        toastr()->success('تم الحفظ بنجاح !!');
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\GroupRegisterType  $groupRegisterType
     * @return \Illuminate\Http\Response
     */
    public function show(GroupRegisterType $groupRegisterType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\GroupRegisterType  $groupRegisterType
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $type =  GroupRegisterType::find($id);

        return view('group_register_types.edit')
        ->with('type',$type)
        ;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateGroupRegisterTypeRequest  $request
     * @param  \App\Models\GroupRegisterType  $groupRegisterType
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateGroupRegisterTypeRequest $request, GroupRegisterType $groupRegisterType)
    {
        $groupRegisterType->type_desc = $request->type_desc;
        $groupRegisterType->save();

        toastr()->success('تم تحديث البيانات بنجاح !!');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\GroupRegisterType  $groupRegisterType
     * @return \Illuminate\Http\Response
     */
    public function destroy(GroupRegisterType $groupRegisterType)
    {
        $group = Group::where('register_type_id',$groupRegisterType->id)->first();
        if($group)
        {
            toastr()->error(' لا يمكنك حذف المجموعة , المجموعة مرتبطة ببيانات اخرى !!');
            return back();
        }
        $groupRegisterType->delete();

        toastr()->success('تم الحذف بنجاح !!');
        return back();
    }
}
