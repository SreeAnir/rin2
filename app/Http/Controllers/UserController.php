<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\NotificationUser;
use Illuminate\Support\Facades\Auth;
use Exception;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('auth:web')->except(['impersonate']);
    }
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     * cahnge it to hash
     */
    public function impersonate(User $user)
    {
        try{
          
            try {
                Auth::guard('web')->loginUsingId($user->id);
                $user =  auth()->guard('web')->user();
                $notifications = NotificationUser::with('Notification')->latest()->where('user_id' , auth()->user()->id )->get();
                return view('user.profile',compact('user','notifications'));
            } catch (Exception $e) {
                $response = ['status' => 'error', 'message' => $e->getMessage()];
                return redirect()->back()->with($response);
            }
        }catch(Exception $ex){
            $response = ['status' => 'error', 'message' => $e->getMessage()];
            return redirect()->back()->with($response);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function settings(Request $request)
    {
        $user =  auth()->guard('web')->user();
        // $user = auth()->user();
        return view('user.settings',compact('user'));
    }

    public function updateSettings(Request $request)
    {
        $user = auth()->user();
        return view('user.settings',compact('user'));
    }
    
    
}
