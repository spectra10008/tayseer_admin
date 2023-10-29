<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMfiProviderUserRequest;
use App\Http\Requests\UpdateMfiProviderUserRequest;
use App\Models\MfiProviderUser;
use Illuminate\Support\Facades\Hash;

class MfiProviderUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Http\Requests\StoreMfiProviderUserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMfiProviderUserRequest $request)
    {
        $mfiProviderUser = new MfiProviderUser();
        $mfiProviderUser->mfi_provider_id = $request->mfi_provider_id;
        $mfiProviderUser->name = $request->name;
        $mfiProviderUser->email = $request->email;
        $mfiProviderUser->password =  Hash::make($request->password);
        $mfiProviderUser->phone = $request->phone;
        $mfiProviderUser->is_active = $request->is_active;
        if ($request->hasFile('profile_pic')) {
            if ($request->file('profile_pic')->isValid()) {
                $path = $request->file('profile_pic')->store(
                    'mfi_provider_user', 'public'
                );
                $mfiProviderUser->profile_pic = $path;
            }
        }
        $mfiProviderUser->save();

        toastr()->success('تم حفظ بيانات المستخدم بنجاح !!');
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MfiProviderUser  $mfiProviderUser
     * @return \Illuminate\Http\Response
     */
    public function show(MfiProviderUser $mfiProviderUser)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MfiProviderUser  $mfiProviderUser
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $mfiProviderUser = MfiProviderUser::find($id);

        return view('mfis.users.edit')
        ->with('mfiProviderUser',$mfiProviderUser)
        ;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMfiProviderUserRequest  $request
     * @param  \App\Models\MfiProviderUser  $mfiProviderUser
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMfiProviderUserRequest $request, $id)
    {
        $mfiProviderUser = MfiProviderUser::find($id);
        $mfiProviderUser->name = $request->name;
        $mfiProviderUser->email = $request->email;
        if(isset($request->password) && $request->password != null)
        {
            $mfiProviderUser->password =  Hash::make($request->password);
        }
        $mfiProviderUser->phone = $request->phone;
        $mfiProviderUser->is_active = $request->is_active;
        if ($request->hasFile('profile_pic')) {
            if ($request->file('profile_pic')->isValid()) {
                $path = $request->file('profile_pic')->store(
                    'mfi_provider_user', 'public'
                );
                $mfiProviderUser->profile_pic = $path;
            }
        }
        $mfiProviderUser->update();

        toastr()->success('تم حفظ بيانات المستخدم بنجاح !!');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MfiProviderUser  $mfiProviderUser
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
            $mfiProviderUser = MfiProviderUser::find($id)->delete();
            toastr()->success('تم حذف بيانات المستخدم بنجاح !!');
            return back();
    }
}
