<?php

namespace App\Http\Controllers\Providers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MfiProviderUser;
use App\Http\Requests\MfiProviders\UpdateProfileRequest;
use App\Http\Requests\MfiProviders\UpdatePasswordRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function edit_profile()
    {
        return view('mfi_providers.auth.edit_profile')
        ;
    }

    public function update_profile(UpdateProfileRequest $request)
    {
        $user = MfiProviderUser::find(Auth::guard('mfis_providers')->id());
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        if ($request->hasFile('profile_pic')) {
            if ($request->file('profile_pic')->isValid()) {
                $path = $request->file('profile_pic')->store('mfi_provider_user','public_file');
                $user->profile_pic = 'files/'.$path;
            }
        }
        $user->update();

        toastr()->success('تم تعديل المستخدم بنجاح !!');
        return back();
    }

    public function update_password(UpdatePasswordRequest $request)
    {
        $user = MfiProviderUser::find(Auth::guard('mfis_providers')->id());
        $user->password = Hash::make($request->password);
        $user->update();

        toastr()->success('تم تعديل كلمة السر بنجاح !!');
        return back();
    }
}
