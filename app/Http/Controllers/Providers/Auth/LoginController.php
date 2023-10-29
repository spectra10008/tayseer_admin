<?php

namespace App\Http\Controllers\Providers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\MfiProviders\LoginRequest;
use Auth;
class LoginController extends Controller
{
    public function create()
    {
        return view('mfi_providers.auth.login');
    }

    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended('/panel-mfi/dashboard');
    }


    public function destroy(Request $request)
    {
        Auth::guard('mfis_providers')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/panel-mfi/login');
    }
}
