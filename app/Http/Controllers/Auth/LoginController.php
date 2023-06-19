<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        $title = "Login";
        return view('auth.login', compact('title'));
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $authenticate = auth()->attempt($request->only('email', 'password'));
        if (!$authenticate) {
            return back()->with('login_error', "Invalid Login Credentials");
        }
        if (Auth::check() && Auth::user()->role_id == '1') {
            return redirect()->route('dashboard');
        } else {
            return redirect()->route('employee-dashboard');
        }
    }
}
