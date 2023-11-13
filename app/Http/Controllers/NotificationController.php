<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use App\DataTables\NotificationDataTable;
use App\Models\NotificationUser;
use App\Models\Notification;
use App\Models\User;
use App\Http\Requests\NotificationRequest;
use Exception;
use Illuminate\Support\Facades\DB;

use DataTables;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    
    public function index()
    {
        try {
            $user  = auth()->user(); 
        
            if ($user->isAdmin()) {  
                return  view("notification.index");
            } else {

                return  view("notification.users-notificaion");
            }
          
        } catch (Exception $e) {
            $response = ['status' => 'error', 'message' => $e->getMessage()];
            return redirect()->back()->with($response);
        }
    }

    public function getNotifications(Request $request)
    {
        if ($request->ajax()) {
            $data = NotificationUser::with('Notification')->latest()->where('user_id' , auth()->user()->id )->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                     $actionBtn = '<ahref="'. route('impersonate',[$row->id]).'" class="edit btn btn-info btn-sm">Read</a> ';
                    return $actionBtn;
                })
                ->addColumn('unread', function($row){
                    return ($row->read_at ?:"Not Read");
                })
                ->addColumn('notification_type', function($row){
                    return $row->notification->notification_type;
                })
                 ->addColumn('note', function($row){
                    return $row->notification->note;
                })
                
                ->rawColumns(['action'])
                ->make(true);
        }
    }
    public function getAllNotifications(Request $request)
    { 
        if ($request->ajax()) {
            $data = Notification::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                     $actionBtn = '<a href="'. route('impersonate',[$row->id]).'" class="edit btn btn-info btn-sm">Read</a> ';
                    return $actionBtn;
                })
                ->addColumn('notification_type_label', function($row){
                    return $row->notificationTypeLabel( $row->notification_type);
                })
                 ->addColumn('note', function($row){
                    return $row->note;
                })
                ->addColumn('created_at_format', function($row){
                    return $row->created_at_format;
                })
                
                    ->addColumn('recipients', function($row){
                        return ( $row->users->count() > 0 ? implode(',',$row->users->pluck('name')->toArray()):"No Recipients");
                    })
                ->rawColumns(['action'])
                ->make(true); 
        }
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    { 
        $users = User::users()->get();
        $notification_types = Notification::getTypeList();
       return view('notification.create',compact('users','notification_types'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NotificationRequest $request)
    { 
        try {
            DB::beginTransaction();
        $validatedData = $request->getData();
        $notification = Notification::create([
            'notification_type' => $validatedData['notification_type'],
            'note' => $validatedData['note'],
            'expire_on' => $validatedData['expire_on'],
        ]);
        if ($validatedData['users'] == 'all') {
            $users = User::pluck('id')->toArray();
            $notification->users()->attach($users);
        } else {
            $notification->users()->attach($validatedData['users']);
        }
            DB::commit();
        return response()->json(['status' => "success", 'message' => "Sent Notification to users", 'message_title' => "Success"], 200);

         }
        catch (Exception $e) { 
            DB::rollback();
        return response()->json(['status' => "error", 'message' => "Failed to send notification", 'message_title' => "Failed"], 200);

        } 
         
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
