<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class SalesTeamController extends Controller
{
    public function index(Request $request, User $user){
        if($request->ajax()){
            $users = User::where("role", 5)->get();
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
                    // $btn = '<a href="' . route('farmers.show', encrypt($user->id)) . '" title="View"></a>&nbsp;&nbsp;';
                    // $btn .= '<a href="javascript:void(0);" delete_form="delete_customer_form"  data-id="' . encrypt($user->id) . '" class="delete-datatable-record text-danger delete-users-record" title="Delete"><i class="fas fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns([
                    'action',
                    'status',
                ])
            ->make(true);
        }

        return view('sales.index');
    }

    public function getProfile($id){
        $id = decrypt($id);
        $user_info = User::find($id);
        return $user_info;
    }
}
