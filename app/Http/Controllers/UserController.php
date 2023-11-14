<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\NotificationUser;
use App\Models\Notification;

use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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
            $notifications = collect();
            if($user->notification_switch){ 
                $notifications = Notification::whereHas('users', function ($query) use( $user) {
                    $query->where('read_at',null )->where('user_id' , $user->id)->where(function ($query) {
                        $query->whereNull('expire_on')
                            ->orWhere('expire_on', '>', now()); // Assuming 'expire_on' is a timestamp
                    });
                })->get();
            }
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
         //put data to update
    }
    public function setRead(Request $request)
    {
        try{
            DB::beginTransaction();
            $time = now() ;
            if($request->mark_all){
                $user_id =auth()->guard('web')->user()->id; 
                $notifications = DB::table('notification_users')->where( 'user_id',$user_id)->whereNull('read_at')->update(['read_at' => $time ]);
            }else{
                $notification_user = $request->notification_user ;
                $notifications = DB::table('notification_users')->where( 'notification_id',$request->notification_user)->update(['read_at' => $time ]);
            }
            DB::commit();
            return response()->json(['status' => "success", 'message' => "Marked as read", 'message_title' => "Success","time" =>   Carbon::parse($time)->format('M j, Y g:i A') ], 200);
        }
       catch (Exception $e) { 
           DB::rollback();
        return response()->json(['status' => "error", 'message' => "Failed to Mark as read", 'message_title' => "Failed","err"=> $e->getMessage()], 200);
        }
    }

    
    
}
