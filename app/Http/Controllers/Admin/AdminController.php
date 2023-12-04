<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\UsersDataTable ;
use App\Models\User;
use DataTables;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
   /* List out users */
    public function index(UsersDataTable $dataTable)
    {
        try {
            return $dataTable->render("admin.index");
        } catch (Exception $e) {
            $response = ['status' => 'error', 'message' => $e->getMessage()];
            return redirect()->back()->with($response);
        }
    }

    public function getUsers(Request $request)
    {
        if ($request->ajax()) {
            $data = User::withCount('unreadNotifications')->latest()->users()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                     $actionBtn = '<a  target="_blank"  href="'. route('impersonate',[$row->id]).'" class="edit btn btn-success btn-sm">Impersonate</a> ';

                    return $actionBtn;
                })
                ->addColumn('unread', function($row){
                  return  $row->unread_notifications_count;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }
  
}
