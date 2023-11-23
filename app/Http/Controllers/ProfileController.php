<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ProfileRequest ;
use Exception;
use Illuminate\Support\Facades\DB;
use App\Models\User;
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

    
    public function updateSettings(ProfileRequest $request)
    { 
        try {
            DB::beginTransaction();
            $validatedData = $request->getData();
            $update = User::where('id', auth()->user()->id)->update($validatedData);
            DB::commit();
            if($update){
                $response = ['status' => 'success', 'message' =>  "Profile Updated successfully"  ];
            }else{
                $response = ['status' => 'success', 'message' =>  "Failed Update Profile"  ];
            }
            return redirect()->back()->with($response);

         }
        catch (Exception $e) { 
            DB::rollback();
            $response = ['status' => 'success', 'message' =>  "Failed Update Profile"  ];
            return redirect()->back()->with($response);

        } 
         
    }
}
