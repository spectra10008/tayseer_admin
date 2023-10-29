<?php

namespace App\Http\Controllers\Providers;

use Illuminate\Http\Request;
use App\Http\Requests\MfiProviders\UserStoreRequest;
use App\Http\Requests\MfiProviders\UserUpdateRequest;
use App\Models\MfiProviderUser;
use App\Models\Topic;
use Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

class UserController extends Controller
{

    public function index()
    {
        $users = MfiProviderUser::where('mfi_provider_id',Auth::guard('mfis_providers')->user()->mfi_provider_id)->orderBy('id','Desc')->where('id','!=',1)->get();

        return view('mfi_providers.users.index')
        ->with('users',$users)
        ;
    }

    public function store(UserStoreRequest $request)
    {

        $users = new MfiProviderUser();
        $users->name = $request->name;
        $users->email = $request->email;
        $users->password =  Hash::make($request->password);
        $users->phone = $request->phone;
        $users->mfi_provider_id = Auth::guard('mfis_providers')->user()->mfi_provider_id;
        $users->is_active = $request->is_active;
        if ($request->hasFile('profile_pic')) {
            if ($request->file('profile_pic')->isValid()) {
                $path = $request->file('profile_pic')->store('mfi_users','public_file');
                $users->profile_pic = 'files/'.$path;
            }
        }
        $users->save();

        toastr()->success('تم حفظ بيانات المستخدم بنجاح !!');
        return back();
    }


    public function edit($id)
    {
        $user = MfiProviderUser::find($id);

        return view('mfi_providers.users.edit')
        ->with('user',$user)
        ;
    }



    public function update(UserUpdateRequest $request,$id)
    {

        $users =  MfiProviderUser::find($id);
        $users->name = $request->name;
        $users->email = $request->email;
        if(isset($request->password) && $request->password != null)
        {
            $users->password =  Hash::make($request->password);
        }
        $users->phone = $request->phone;
        $users->is_active = $request->is_active;
        if ($request->hasFile('profile_pic')) {
            if ($request->file('profile_pic')->isValid()) {
                $path = $request->file('profile_pic')->store('mfi_users','public_file');
                $users->profile_pic = 'files/'.$path;
            }
        }
        $users->update();

        toastr()->success('تم حفظ بيانات المستخدم بنجاح !!');
        return back();
    }

    public function destroy($id)
    {

            $users =  MfiProviderUser::find($id)->delete();
            toastr()->success('تم حذف بيانات المستخدم بنجاح !!');
            return back();

    }

}
