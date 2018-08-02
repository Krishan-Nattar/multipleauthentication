<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class AdminLoginController extends Controller
{
    //

    use AuthenticatesUsers;
    protected $redirectTo = '/admin/home';

    public function __construct()
    {
        $this->middleware('guest:admin', ['except'=>['logout']]);
    }

    public function showLoginForm()
    {
        return view('auth.admin_login2');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email'=>'required|email',
            'password'=>'required|min:6'
        ]);
        if (Auth::guard('admin')->attempt([
            'email'=>$request->email,
            'password'=>$request->password],
        $request->remember)){
            return redirect()->intended(route('admin.dashboard'));
        } else {
        return redirect()->back()->withInput($request->only('email', 'remember'));
        }
    }
    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect('/admin');
    }
}
