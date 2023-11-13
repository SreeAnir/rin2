<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    
    
    public function login()
    {
        return view('auth.login');
    }

    
    public function authenticate(Request $request)
    {

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        // $credentials['password'] = 'password';
        if ( Auth::guard('admin')->attempt( $credentials )) {
            $request->session()->regenerate();

            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function store(Request $request)
    {
        # code...
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
    return redirect('/login');
    }
    public function userlogout(Request $request)
    {
        Auth::guard('web')->logout();
        return redirect(route('admin.index'));
    }
    
}