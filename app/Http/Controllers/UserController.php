<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\NotificationUser;
use App\Models\Notification;

use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Support\Facades\DB;

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
          
            Auth::guard('web')->loginUsingId($user->id);
            $user =  auth()->guard('web')->user();
            // $notifications = NotificationUser::with('Notification')->latest()->where('user_id' , auth()->user()->id )->unread()->available()->get();
            $notifications = Notification::whereHas('users', function ($query) {
                $query->where('read_at',null )->where(function ($query) {
                    $query->whereNull('expire_on')
                        ->orWhere('expire_on', '>', now()); // Assuming 'expire_on' is a timestamp
                });
            })->get();
            return view('user.profile',compact('user','notifications'));
        }catch(Exception $ex){
            $response = ['status' => 'error', 'message' => $ex->getMessage()];
            return redirect()->back()->with($response);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function settings(Request $request)
    {
        $user =  auth()->guard('web')->user();
        return view('user.settings',compact('user'));
    }

    public function updateSettings(Request $request)
    {
        $user = auth()->user();
        return view('user.settings',compact('user'));
    }
    public function setRead(Request $request)
    {
        try{
            DB::beginTransaction();
            $notification_user = $request->notification_user ;
            $notifications = DB::table('notification_users')->where( 'notification_id',$request->notification_user)->update(['read_at' => now()]);
            DB::commit();
            return response()->json(['status' => "success", 'message' => "Marked as read", 'message_title' => "Success"], 200);
        }
       catch (Exception $e) { 
           DB::rollback();
        return response()->json(['status' => "error", 'message' => "Failed to Mark as read", 'message_title' => "Failed","err"=> $e->getMessage()], 200);
        }
    }

    
    
}
