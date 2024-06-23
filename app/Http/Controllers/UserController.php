<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Region;
use App\Models\Province;
use Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use App\Jobs\ProcessEmail;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UsersExport;
use Carbon\Carbon;
use App\Models\Farms;
class UserController extends Controller
{

    public function index(Request $request, User $user)
    {
        if ($request->ajax()) {
            $users = $user->getAllUsers($request, false, 1);
            $totalUsers = User::where('role', '!=', User::ROLE_ADMIN)
            ->where('role', 2)
            ->count();
            $search = $request['search']['value'];
            $setFilteredRecords = $totalUsers;

            if (! empty($search)) {
                $setFilteredRecords = $user->getAllUsers($request, true, 1);
                if(empty($setFilteredRecords))
                    $totalUsers = 0;
            }
            return datatables()
                    ->of($users)
                    ->addIndexColumn()
                    ->addColumn('status', function ($user) {
                        return '<span class="badge badge-light-' . $user->getStatusBadge() . '">' . $user->getStatus() . '</span>';
                    })
                    ->addColumn('created_at', function ($user) {
                        return $user->created_at;
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
                    ->addColumn('registered_by', function ($user) {
                        return $user->referer ? $user->referer : 'N/A';
                    })
                    ->addColumn('registered_date', function ($user) {
                        return $user->registered_date ? $user->registered_date : 'N/A';
                    })
                    ->addColumn('region', function ($user) {
                        if(!empty($user->region)) {
                            $region = Region::where('regcode',$user->region)->first();
                            $region = $region->name;
                        } else {
                            $region = "N/A";
                        }
                        
                        return $region;
                    })
                    ->addColumn('province', function ($user) {
                        if(!empty($user->province)) {
                            $province = Province::where('provcode',$user->province)->first();
                            $province = $province->name;
                        } else {
                            $province = "N/A";
                        }
                        return $province;
                    })
                    ->addColumn('action', function ($user) {
                            $btn = '';
                            $btn = '<a href="' . route('farmers.show', encrypt($user->id)) . '" title="View"><i class="fas fa-eye"></i></a>&nbsp;&nbsp;';
                            /*$btn .= '<a href="' . route('farmers.edit', encrypt($user->id)) . '" title="Edit"><i class="fas fa-edit"></i></a>&nbsp;&nbsp;';*/
                            $btn .= '<a href="javascript:void(0);" delete_form="delete_customer_form"  data-id="' . encrypt($user->id) . '" class="delete-datatable-record text-danger delete-users-record" title="Delete"><i class="fas fa-trash"></i></a>';
                        return $btn;
                    })
                    ->rawColumns([
                        'action',
                        'status'        
                    ])
                    ->setTotalRecords($totalUsers)
                    ->setFilteredRecords($setFilteredRecords)
                    ->skipPaging()
                    ->make(true);
        }

        $regions = Region::all();
        return view('user.index', ['regions' => $regions]);
    }

    public function getProvinceByRegion(Request $request) {
        $provinces = Province::select('provcode','name')->where('regcode',$request->region_id)->get();
        return response()->json($provinces);
    }

    public function export(Request $request, User $user)
    {
            $users = $user->getAllUsersAll($request, false, 1);
            $totalUsers = User::where('role', '!=', User::ROLE_ADMIN)
                ->where('role', 2)
                ->count();
            $search = '';
            $setFilteredRecords = $totalUsers;

            if (!empty($search)) {
                $setFilteredRecords = $user->getAllUsers($request, true, 1);
                if (empty($setFilteredRecords))
                    $totalUsers = 0;
            }

            $usersCollection = collect($users)->map(function ($item) {
                return [
                    '#',
                    $item->full_name,
                    $item->phone_number ? $item->phone_number : 'N/A',
                    $item->role_title ? $item->role_title : 'N/A',
                    $item->getStatus(),
                    $item->via_app == 1 ? "YES" : 'NO',
                    $item->created_at,
                    $item->referer,
                ];
            });

            return Excel::download(new UsersExport($usersCollection), 'users.xlsx');

    }
    public function leadsUser(Request $request, User $user)
    {
        if ($request->ajax()) {
            $users = $user->getAllUsers($request, false, 0);
            $totalUsers = User::where('role', '!=', User::ROLE_ADMIN)
            ->where('role','!=', 2)
            ->count();
            $search = $request['search']['value'];
            $setFilteredRecords = $totalUsers;

            if (! empty($search)) {
                $setFilteredRecords = $user->getAllUsers($request, true, 0);
                if(empty($setFilteredRecords))
                    $totalUsers = 0;
            }
            return datatables()
                    ->of($users)
                    ->addIndexColumn()
                    ->addColumn('status', function ($user) {
                        return '<span class="badge badge-light-' . $user->getStatusBadge() . '">' . $user->getStatus() . '</span>';
                    })
                    ->addColumn('created_at', function ($user) {
                        return $user->created_at;
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
                            $btn = '<a href="' . route('farmers.show', encrypt($user->id)) . '" title="View"><i class="fas fa-eye"></i></a>&nbsp;&nbsp;';
                            /*$btn .= '<a href="' . route('farmers.edit', encrypt($user->id)) . '" title="Edit"><i class="fas fa-edit"></i></a>&nbsp;&nbsp;';*/
                            $btn .= '<a href="javascript:void(0);" delete_form="delete_customer_form"  data-id="' . encrypt($user->id) . '" class="delete-datatable-record text-danger delete-users-record" title="Delete"><i class="fas fa-trash"></i></a>';
                        return $btn;
                    })
                    ->rawColumns([
                        'action',
                        'status'        
                    ])
                    ->setTotalRecords($totalUsers)
                    ->setFilteredRecords($setFilteredRecords)
                    ->skipPaging()
                    ->make(true);
        }

        return view('user.leads');
    }

    public function create(Role $role)
    {
        return view('user.create');
    }

    public function store(Request $request, User $user)
    {
        $rules = array(
            'full_name' => 'required',
            'email' => 'required|email:rfc,dns,filter|unique:users,email,NULL,id,deleted_at,NULL',
            'phone_code' => 'required',
            'iso_code' => 'required',
            'phone_number' => 'required|unique:users,phone_number,NULL,id,deleted_at,NULL|min:8|max:15',
            'password' => 'required',
            'confirm_password' => 'required|same:password'
        );

        $message = [
            'confirm_password.same' => 'Password and confirm password should be same.',
        ];
        $validator = Validator::make($request->all(), $rules, $message);
        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        }

        $userArr = $request->except(['confirm_password','_token']);
        $userArr['email_verified_at'] = Carbon::now();
        $userArr['created_by'] = auth()->user()->id;
        $userObj = $user->saveNewUser($userArr);

        if (! $userObj) {
            return redirect()->back()->with('error', 'Unable to create user. Please try again later.');
        }
        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function show($id)
    {
        try{
            $user = new User;
            $id = decrypt($id);
            $userObj = $user->findUserById($id);
            $farms=Farms::where('farmer_id',$id)->paginate(10);
            return view('user.view', compact("userObj","farms"));
        } catch (\Exception $ex) {
            if($ex->getMessage() == "The payload is invalid."){
                return redirect()->back()->with('error', "Invalid-request");
            }
            return redirect()->back()->with('error', "Something went wrong. Please try again later.");
        }
    }

    public function edit($id)
    {
        try{
            $id = decrypt($id);
            $user = new User;
            $userObj = $user->findUserById($id);
            if (! $userObj) {
                return redirect()->back()->with('error', 'This user does not exist');
            }
            return view('user.edit', compact('userObj'));
        } catch (\Exception $ex) {
            if($ex->getMessage() == "The payload is invalid."){
                return redirect()->back()->with('error', "Invalid-request");
            }
            return redirect()->back()->with('error', "Something went wrong. Please try again later.");
        }
    }

    public function update($id,Request $request)
    {
        $userId = decrypt($id);
        $rules = array(
            'full_name' => 'required',
            'email' => 'required|email:rfc,dns,filter|unique:users,email,' . $userId . ',id,deleted_at,NULL',
            'phone_code' => 'required',
            'iso_code' => 'required',
            'phone_number' => 'required|unique:users,phone_number,' . $userId . ',id,deleted_at,NULL|min:8|max:15'
        );

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        }

        $user = new User;
        $userObj = $user->findUserById($userId);
        if (! $userObj) {
            return redirect()->back()->with('error', 'This user does not exist');
        }

        $userArr = $request->except(['_method','_token']);
        $hasUpdated = $user->updateUserById($userId,$userArr);

        if ($hasUpdated) 
            return redirect()->route('users.index')->with('success', 'User updated successfully.');
        
        return redirect()->back()->with('error', 'Unable to update user. Please try again later.');
    }

    public function destroy($id)
    {
        $id = decrypt($id);
        $user = new User;
        $userObj = $user->findUserById($id);

        if (! $userObj) {
            return returnNotFoundResponse('This farmer does not exist');
        }

        $hasDeleted = $userObj->delete();
        if ($hasDeleted) {
            return returnSuccessResponse('Farmer deleted successfully');
        }

        return returnErrorResponse('Something went wrong. Please try again later');
    }

    public function changeStatus($id)
    {
        $id = decrypt($id);
        $userObject = new User;
        $userObject = $userObject->findUserById($id);

        if (! empty($userObject)) {
            $status = User::STATUS_ACTIVE;

            if ($userObject->status == User::STATUS_ACTIVE) {
                $status = User::STATUS_INACTIVE;
            }

            $userObject->update(['status'=>$status]);
        }

        return Redirect::back()->withInput()->with('success', 'Status Changed successfully');
    }

    public function profile()
    {
        $userObject = auth()->user();
        return view('user.profile', compact("userObject"));
    }

    public function showUpdateProfileForm()
    {
        $userObject = Auth()->user();
        return view('user.updateProfile', compact("userObject"));
    }

    public function updateProfile(Request $request)

    {
        $userObject = Auth()->user();

        $rules = array(
            'full_name' => 'required',
            'email' => 'required|email:rfc,dns,filter|unique:users,email,' . $userObject->id,
            'phone_number' => 'required|unique:users,phone_number,' . $userObject->id . ',id,deleted_at,NULL|min:8|max:10'
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        }

        $userObject = $userObject->fill($request->except(['file']));
        if ($request->hasFile('file')) {
            $userObject->profile_image = saveUploadedFile($request->file);
        }
        if ($userObject->save()) {
            return redirect()->route('user.home')->with('success', 'profile updated successfully.');
        }

        return redirect()->back()->with('error_message', 'Unable to update user. Please try again later.');
    }

    public function changePasswordView()
    {
        return view('user.changePassword');
    }

    public function changePassword(Request $request)
    {
        $rules = array(
            'old_password' => "required",
            'password' => 'required',
            'confirm_password' => 'required|same:password'
        );
        $message = [
            'confirm_password.same' => 'Password and confirm password should be same.'
        ];
        $validator = Validator::make($request->all(), $rules, $message);
        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        }

        $userObject = auth()->user();

        if (! Hash::check($request->old_password, $userObject->password)) {
            return Redirect::back()->withInput()->with('error', 'Old password didnot match');
        }

        if (! empty($userObject)) {
            $userObject->password = $request->input('password');
            if ($userObject->save()) {

                return redirect()->route('user.home')->with('success', 'Password updated successfully');
            }
        }

        return Redirect::back()->withInput()->with('error', 'Some error occured. Please try again later');
    }
}
