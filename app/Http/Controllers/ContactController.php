<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use DB;
use Auth;

class ContactController extends Controller
{

    public function getRegionFilter() {
        $user_role = Auth::user()->role;
        $user_region = Auth::user()->region;

        if($user_role == 0 || $user_role == 1){
            return "%%";
        } else if($user_role == 6){
            return $user_region;
        } else {
            return "";
        }
    }

    public function index(Request $request, User $user){
            if($request->ajax()){
                $restriction = $this->getRegionFilter();
                $users = User::where(function($query) use ($restriction) {
                    $query->where('region', 'like', $restriction);
                    if($restriction == "%%"){
                        $query->orWhereNull('region');
                    }
                })->get();
        
                return datatables()
                    ->of($users)
                    ->addIndexColumn()
                    ->addColumn('status', function ($user) {
                        return '<span class="badge badge-light-' . $user->getStatusBadge() . '">' . $user->getStatus() . '</span>';
                    })
                    ->addColumn('phone_number', function ($user) {
                        return $user->phone_number ? $user->phone_number : 'N/A';
                    })
                    ->addColumn('role', function ($user) {
                        return $user->role_title ? $user->role_title : 'N/A';
                    })
                    ->addColumn('via_app', function ($user) {
                        return $user->via_app == 1 ? "YES" : 'NO';
                    })
                    ->addColumn('employee_id', function ($user) {
                        return $user->employee_id ? $user->employee_id : 'N/A';
                    })
                    ->addColumn('registered_date', function ($user) {
                        return $user->registered_date ? $user->registered_date : 'N/A';
                    })
                    ->addColumn('action', function ($user) {
                        $btn = '';
                        $btn .= '<button class="btn btn-primary" onclick="handleViewProfile(\''.encrypt($user->id).'\')">View Profile</button>&nbsp;&nbsp;';
                        $btn .= '<button class="btn btn-primary" onclick="handleContactProfile(\''.encrypt($user->id).'\')">View Contact</button>';
                        return $btn;
                    })
                    ->rawColumns(['action', 'status'])
                    ->make(true);
            }
        
            return view('contacts.index');
        }
    
}
