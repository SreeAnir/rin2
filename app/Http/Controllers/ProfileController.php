<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function settings(Request $request)
    {
        $user =  auth()->guard('web')->user();
        return view('profile.settings',compact('user'));
    }

    public function updateSettings(Request $request)
    {
         
    }
}
