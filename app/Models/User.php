<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    const ROLE_ADMIN = 0;
    const ROLE_USER = 2;

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
   
    // In your User model
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }
    public function getUserRole(){
        return $this->belongsTo(Role::class, 'role');
    }

    public function setPasswordAttribute($value){
        $this->attributes['password'] = Hash::make($value);
    }

    public function saveNewUser($inputArr){
        return self::create($inputArr);
    }
    public  function findUserById($id){
        return self::find($id);
    }
    public  function findUserByReferer($referer){
        return self::where('referer', $referer);
    }
    public function updateUserById($id,$inputArr){
        return self::where('id',$id)->update($inputArr);
    }

     public function getStatus(){

        $list = [
            self::STATUS_ACTIVE=>"Active",
            self::STATUS_INACTIVE=>"Inactive"
        ];

        return isset($list[$this->status])?$list[$this->status]:"Not defined";
    }

    public function getStatusBadge(){

         $list = [
            self::STATUS_ACTIVE=>"primary",
            self::STATUS_INACTIVE=>"danger"
        ];

        return isset($list[$this->status])?$list[$this->status]:"danger";
    }
    public function roleDetails()
    {
        return $this->belongsTo(Role::class, 'role', 'id');
    }
     public function getRole(){

        $list = [
            self::ROLE_ADMIN=>"Admin",
            self::ROLE_USER=>"User"
        ];

        return isset($list[$this->role])?$list[$this->role]:"Not defined";
    }


    public static function getColumnForSorting($value){

        $list = [
            0=>'id',
            1=>'full_name',
            2=>'email',
            3=>'status',
            4=>'created_at'
        ];

        return isset($list[$value])?$list[$value]:"";
    }

    public function getAllUsers($request = null,$flag = false, $farmer = 1)
    {
        if(isset($request['order'])){
            $columnNumber = $request['order'][0]['column'];
            $order = $request['order'][0]['dir'];
        }
        else {
            $columnNumber = 4;
            $order = "desc";
        }

        $column = self::getColumnForSorting($columnNumber);
        if($columnNumber == 0){
            $order = "desc";
        }

        if(empty($column)){
            $column = 'id';
        }
        $query = self::orderBy($column, $order)
            ->where('role', '!=', self::ROLE_ADMIN)
            ->leftJoin('roles', 'users.role', '=', 'roles.id')
            ->select('users.*', 'roles.title AS role_title');

            if($farmer==1){
                $query->where('role', '=', 2);
            }
            else{
                $query->where('role', '!=', 2);
            }
        if(!empty($request)){

            $search = $request['search']['value'];

            if(!empty($search)){
                 $query->where(function ($query) use($request,$search){
                        $query->orWhere( 'full_name', 'LIKE', '%'. $search .'%')
                            ->orWhere( 'email', 'LIKE', '%'. $search .'%')
                            ->orWhere('created_at', 'LIKE', '%' . $search . '%');
                    });

                 if(empty(strcasecmp("Inactive",$search))){
                    $query->orWhere( 'status',  0);

                 }
                if(empty(strcasecmp("Active",$search))){
                    $query->orWhere( 'status',  1);

                 }

                  // if(is_int(stripos("Inactive", $search))){
                  //           $query->orWhere( 'status',  0);

                  //       }
                 // if(is_int(stripos("Active", $search))){
                 //            $query->orWhere( 'status',  1);

                 //        }
                       

                 if($flag)
                    return $query->count();
            }

            $start =  $request['start'];
            $length = $request['length'];
            $query->offset($start)->limit($length);


        }

        $query = $query->get();
        return $query;
    }
    public function getAllUsersAll($request = null,$flag = false, $farmer = 1)
    {
        
            $columnNumber = 4;
            $order = "desc";
        $column = self::getColumnForSorting($columnNumber);
        if($columnNumber == 0){
            $order = "desc";
        }

        if(empty($column)){
            $column = 'id';
        }
        $query = self::orderBy($column, $order)
            ->where('role', '!=', self::ROLE_ADMIN)
            ->leftJoin('roles', 'users.role', '=', 'roles.id')
            ->select('users.*', 'roles.title AS role_title');

            if($farmer==1){
                $query->where('role', '=', 2);
            }
            else{
                $query->where('role', '!=', 2);
            }
       
        $query = $query->get();
        return $query;
    }
    public static function generateEmailVerificationOtp(){
        // $otp = 1234;
        // return $otp;

        $otp = mt_rand(1000,9999);
        // $otp = 123456;
        $count = self::where('email_verification_otp', $otp)->count();
        if($count > 0){
            $this->generateEmailVerificationOtp();
        }
        return $otp;
    }

     public function jsonResponse(){

        $json['id'] = $this->id;
        $json['full_name'] = $this->full_name;
        $json['first_name'] = $this->first_name;
        $json['last_name'] = $this->last_name;
        $json['email'] = $this->email;
        $json['profile_image'] = $this->profile_image;
        $json['role'] = $this->role;
        $json['status'] = $this->status;
        $json['phone_code'] = $this->phone_code;
        $json['phone_number'] = $this->phone_number;
        $json['branch_id'] = $this->branch_id;
        $json['gender'] = $this->gender;
        $json['dob'] = $this->dob;
        $json['barangay'] = $this->barangay;
        $json['region'] = $this->region;
        $json['province'] = $this->province;
        $json['municipality'] = $this->municipality;
        $json['farming_years'] = $this->farming_years;
        $json['farmer_ownership'] = $this->farmer_ownership;
        $json['crops'] = $this->crops;
        $json['referer'] = $this->referer;
        $json['notification'] = $this->notification;
        $json['email_notification'] = $this->email_notification;
        $json['email_verified_at'] = $this->email_verified_at;
        $json['created_at'] = $this->created_at->toDateTimeString();
        $json['updated_at'] = $this->updated_at->toDateTimeString();
        $json['reward_points'] = $this->reward_points;
        $json['verified'] = $this->verified;

        return $json;
    }

    public function isSuperAdmin(){

        return ($this->created_by ==0);
    }

    public static function getMonthlyUsersRegistered()
    {
        $date = new \DateTime(date('Y-m'));

        $date->modify('-8 months');

        $count = [];
        for ($i = 1; $i <= 8; $i ++) {
            $date->modify('+1 months');
            $month = $date->format('Y-m');
            $displayMonth = $date->format("M");

            $userCount = self::where('created_by', '!=', 0)->where('created_at','like','%' . $month . '%')->count();
            
            $count['month'][$i] = $displayMonth;
            $count['users'][$i] = $userCount;

        }
        return $count;
    }

     public static function getActiveInactiveCount(){

        $data[] = [
            'name'=>'Active User',
            'y'=>self::where(['status'=>self::STATUS_ACTIVE])->where('role',"!=",self::ROLE_ADMIN)->count(),
            'sliced'=>true,
            'selected'=>true,
            'color'=>'#7367f0'
        ];
        $data[] = [
            'name'=>'Inactive User',
            'y'=>self::where(['status'=>self::STATUS_INACTIVE])->where('role',"!=",self::ROLE_ADMIN)->count(),
            'color'=>"#212529"

        ];
       
        return json_encode($data);
    }

}
