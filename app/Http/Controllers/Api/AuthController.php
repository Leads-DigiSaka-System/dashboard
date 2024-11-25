<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\EmailOtp;
use App\Models\EmployeeMasterList;
use Illuminate\Http\Exceptions\HttpResponseException;
use Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Auth;
use Illuminate\Support\Str;
use App\Models\ErrorLog;
use App\Models\Calendar;
use App\Models\EmailQueue;
use App\Models\Event;
use App\Models\FarmOwnership;
use App\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\File;
use App\Models\AppModel;

class AuthController extends Controller
{
    public function uploadApp(Request $request){
        $file = $request->file('file');
        $allowedTypes = ['apk','svg'];
        $extension = $file->getClientOriginalExtension();
        if (!in_array($extension, $allowedTypes)) {
            return response()->json(['error' => 'Only apk allowed!'], 400);
        }
        $fileName = time() . '_' . $file->getClientOriginalName();
        $file->storeAs('upload/app_files', $fileName, 'public_upload');
        $uploadedApp[] = [
            'filename' => $fileName,
            'created_at' => now(),
            'modified_at' => now(),
            'changelog' => $request->changelog,
            'version' => $request->version,
        ];
        DB::table('app')->insert($uploadedApp);
        return response()->json(['message' => 'Files uploaded successfully'], 200); 
    }   
    public function uploadFile(Request $request)
    {   
        $files = $request->file('files');
        if (!is_array($files)) {
            $files = [$files];
        }

        if(!isset($files)){
            return response()->json(['error' => 'No file has been submitted!'], 400);
        }
       
        $uploadedFiles = [];
        $fileNames = "";
        $isFirst = true;
        foreach ($files as $file) {
            // Validate file type
            $allowedTypes = ['jpg', 'png', 'pdf', 'jpeg'];
            $extension = $file->getClientOriginalExtension();
            if (!in_array($extension, $allowedTypes)) {
                return response()->json(['error' => 'Only JPG, PNG, JPEG, and PDF files are allowed'], 400);
            }
    
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('upload/files', $fileName, 'public_upload'); // Using 'public_upload' disk
    
            $fileNames .= ($isFirst ? $fileName : "|" . $fileName);
        }

        $uploadedFiles = [
            'filename' => $fileNames,
            'created_at' => now(),
            'modified_at' => now(), // Assuming modified_at will be same as created_at initially
            'created_by' => 'system', // You might need to change this according to your authentication system
            'modified_by' => 'system', // Same as created_by, // You might need to change this according to your authentication system
            'farmer_id' =>  $request->farmer_id // Same as created_by
        ];
        File::insert($uploadedFiles);
    
        return response()->json(['message' => 'Files uploaded successfully'], 200);
        
    }
    public function searchUser(Request $request, $search, $role = null)
    {
        $query = User::selectRaw('LOWER(users.first_name) as first_name, LOWER(users.last_name) as last_name, LOWER(roles.title) as role_title, users.*')
            ->leftJoin('roles', 'users.role', '=', 'roles.id')
            ->where(function ($query) use ($search) {
                $query->whereRaw("LOWER(CONCAT(first_name, ' ', last_name)) LIKE ?", ["%".strtolower($search)."%"])
                    ->orWhereRaw("LOWER(phone_number) LIKE ?", ["%".strtolower($search)."%"]);
            })
            ->limit(50);

        if ($role != null && $role != '') {
            $query->where('users.role', $role);
        }

        $users = $query->get();

        return response()->json($users);
    }


    public function searchEmployee($first_name, $last_name)
    {
        $query = EmployeeMasterList::select('*')
            ->where('first_name', 'LIKE', "%{$first_name}%")
            ->where('last_name', 'LIKE', "%{$last_name}%")
            ->limit(50);

        $employees = $query->get();

        return response()->json($employees);
    }

    public function searchtps($search = '')
    {
        $query = EmployeeMasterList::select('*')
            ->where('area_coverage', 'LIKE', "%{$search}%")
            ->where('position', 'LIKE', "Technical and Promo Specialist")
            ->limit(50);

        $employees = $query->get();

        return response()->json($employees);
    }
    public function upsertCalendar(Request $request, int $id = 0)
    {
        if ($id > 0) {
            $calendar = Calendar::find($id);
            if (!$calendar) {
                return response()->json(['message' => 'Event not found'], 404);
            }

            $rules = [
                'title' => 'required',
                'activity_type' => 'required',
                'start_date' => 'required',
                'end_date' => 'required',
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $errorMessages = $validator->errors()->all();
                throw new HttpResponseException(returnValidationErrorResponse($errorMessages[0]));
            }

            // Manually setting fields not coming from the request
            $calendar->fill($request->all());
            $calendar->updated_at = now();
            $calendar->save();

            return response()->json($calendar);
        }

        $rules = [
            'title' => 'required',
            'activity_type' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errorMessages = $validator->errors()->all();
            throw new HttpResponseException(returnValidationErrorResponse($errorMessages[0]));
        }

        // Creating a new calendar event
        $calendar = new Calendar($request->all());
        $calendar->created_by = auth()->user()->id;
        $calendar->created_at = now();
        $calendar->updated_at = now();
        $calendar->save();

        return response()->json($calendar);
    }
    public function delete(Request $request, $id){
        $event = Event::find($id);

        if ($event) {
            $event->delete();
            return response()->json(['success' => 'Event deleted successfully']);
        } else {
            return response()->json(['error' => 'Event not found'], 404);
        }
    }
    public function getCalendar($month = 0){
        if($month ==0 ){
            $calendar = Calendar::get();
        }
        else{
            $calendar = Calendar::where('start_date', 'like', $month.'-%')->get();
        }
        if($calendar->isEmpty()){
            return response()->json(['message' => 'No events found'], 404);
        }
        return response()->json($calendar);
    }
    public function register(Request $request, User $user)
    {
    	$rules = [
    		'full_name'=>'',
    		'first_name'=>'',
    		'middle_name'=>'nullable',
    		'last_name'=>'',
            'phone_code'=>'required',
            'email'=>'nullable|email|unique:users,email,NULL,id,deleted_at,NULL',
            'role'=>'required',
            'branch_id'=>'required',
            'phone_number' => 'nullable',
            'password' => 'required',
            'fcm_token' => 'nullable',
            'via_app' => 'nullable',
            'referer' => '',
            'varieties_planted' => 'nullable',
            'method' => 'nullable',
            'association' => 'nullable',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errorMessages = $validator->errors()->all();
            throw new HttpResponseException(returnValidationErrorResponse($errorMessages[0]));
        }

        $user = $user->fill($request->all());
        $user->full_name = $request->first_name.' '.$request->last_name;    
        $user->via_app = 1;    

        if(!$user->save()){
            return returnErrorResponse('Unable to register farmer. Please try again later');
        }

        return returnSuccessResponse('Farmer registered successfully!', $user->jsonResponse());
    }
    public function doesExist(Request $request){
        //$returnArr = $request->req;
        if($request->req == "email"){
            $query = DB::table('users')->where('email',$request->value);
        }else{
            $query = DB::table('users')->where('phone_number',$request->value);
        }
        
        return returnSuccessResponse('Credential check successfully!', $query->get()->count() >= 1 ? true : false);
    }   

   public function verifyOtp(Request $request, User $user)
   {
       $rules = [
           'user_id' => 'required',
           'otp' => 'required'
       ];

       $inputArr = $request->all();
       $validator = Validator::make($inputArr, $rules);
       if ($validator->fails()) {
           $errorMessages = $validator->errors()->all();
           throw new HttpResponseException(returnValidationErrorResponse($errorMessages[0]));
       }

       $userObj = User::where('id', $inputArr['user_id'])
                       ->where('email_verification_otp', $inputArr['otp'])
                       ->first();
       if (!$userObj) {
           return returnNotFoundResponse('Invalid OTP');
       }

       $userObj->email_verified_at = Carbon::now();
       $userObj->email_verification_otp = null;
       $userObj->save();

       $updatedUser = User::find($inputArr['user_id']);
       $authToken = $updatedUser->createToken('authToken')->plainTextToken;
       $returnArr = $updatedUser->jsonResponse();
       $returnArr['auth_token'] = $authToken;
       return returnSuccessResponse('Otp verified successfully', $returnArr);
    }

     public function resendOtp(Request $request, User $user)
    {
        $userId = $request->get('user_id');
        if(!$userId){
            throw new HttpResponseException(returnValidationErrorResponse('Please send user id with this request'));
        }
        $userObj = User::where('id', $userId)->first();
        if (!$userObj) {
            return returnNotFoundResponse('User not found with this user id');
        }
       
        $verificationOtp = $userObj->generateEmailVerificationOtp();
        $userObj->email_verification_otp = $verificationOtp;
        $userObj->save();

        EmailQueue::add([
            'to' => $userObj->email,
            'subject' => "Verification Code",
            'view' => 'mail',
            'type'=>0,
            'viewArgs' => [
                'name' => $userObj->full_name,
                'body' => "Your verification otp is: ".$userObj->email_verification_otp
            ]
        ]);
    

        return returnSuccessResponse('Otp resend successfully!',$userObj->jsonResponse());
    }
    public function latest_app(){
        $latestApp = AppModel::latest()->first();

        return response()->json($latestApp);
    }
    public function verify_user($id){
        $user = User::find($id);
    
        if($user){
            $user->update(['verified' => 1]);
            return response()->json(['message' => 'User verified successfully'], 200);
        } else {
            return response()->json(['message' => 'User not found'], 404);
        }
    }
    public function app_details($version){
        $appDetails = AppModel::where('version',$version)->first();
        return response()->json($appDetails);
    }
    public function login(Request $request)
    {
    	$rules = [
    		//'email' => 'required',
            'phone_code' => 'required',
            'phone_number'=>'required',
            'password' => 'required',
            'fcm_token' => 'required',
            'email' => 'nullable'

        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errorMessages = $validator->errors()->all();
            throw new HttpResponseException(returnValidationErrorResponse($errorMessages[0]));
        }

        $inputArr = $request->all();
        if(isset($inputArr['email'])){
            $userObj = User::where('email',$inputArr['email'])
                    ->first();
        }else{
            $userObj = User::where('phone_code',$inputArr['phone_code'])
                        ->where('phone_number',$inputArr['phone_number'])
                        ->first();
        }
        if(empty($userObj))
            return returnNotFoundResponse('Farmer Not found.');

        if($userObj->status == User::STATUS_INACTIVE)
            return returnErrorResponse("Your account is inactive please contact with admin.");

            if (!Hash::check($inputArr['password'], $userObj->password, [])) {
                // return if password
                return response()->json([
                    'statusCode' => 401,
                    'message' => "We are sorry but your login credentials do not match!"
                ], 401);
            }
            
        
        //$userObj->device_type = $inputArr['device_type'];
        $userObj->fcm_token = $inputArr['fcm_token'];
        $userObj->save();

        $userObj->tokens()->delete();
        $authToken = $userObj->createToken('authToken')->plainTextToken;
        $returnArr = $userObj->jsonResponse();
        $returnArr['auth_token'] = $authToken;
        $roleList = Role::getAllRole()->pluck('title', 'id')->toArray();

        $userRole = $roleList[$returnArr["role"]] ?? 'Unknown Role';
        
        return returnSuccessResponse($userRole . ' logged in successfully', $returnArr);
    }

     public function logout(Request $request)
    {
        $userObj = $request->user();
        if (!$userObj) {
            return returnNotAuthorizedResponse('You are not authorized');
        }

        $userObj->tokens()->delete();
        $userObj->fcm_token = null;
        $userObj->save();
        return returnSuccessResponse('User logged out successfully');
    }

    public function forgotPassword(Request $request, User $user)
    {
        $rules = [
            'email' => 'required',
        ];

        $messages = [
            'email.required' => 'Please enter email address.'
        ];

        $inputArr = $request->all();
        $validator = Validator::make($inputArr, $rules, $messages);
        if ($validator->fails()) {
            $errorMessages = $validator->errors()->all();
            throw new HttpResponseException(returnValidationErrorResponse($errorMessages[0]));
        }

        $userObj = User::where('email', $inputArr['email'])
                        ->first();
        if (!$userObj) {
            return returnNotFoundResponse('User not found with this email address');
        }


        $resetPasswordOtp = $userObj->generateEmailVerificationOtp();
        $userObj->email_verification_otp = $resetPasswordOtp;
        $userObj->save();

          EmailQueue::add([
            'to' => $userObj->email,
            'subject' => "Reset Password OTP",
            'view' => 'mail',
            'type'=>0,
            'viewArgs' => [
                'name' => $userObj->full_name,
                'body' => "Your reset password otp is: ".$userObj->email_verification_otp
            ]
        ]);

        return returnSuccessResponse('Reset password OTP sent successfully', $userObj->jsonResponse());
    }

    public function emailOtp(Request $request, User $user)
    {
        $rules = [
            'email' => 'required|email',
        ];

        $messages = [
            'email.required' => 'Please enter an email address.',
            'email.email' => 'Please enter a valid email address.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $errorMessages = $validator->errors()->all();
            throw new HttpResponseException(returnValidationErrorResponse($errorMessages[0]));
        }

        $email = $request->input('email');
        $otp = Str::random(6);

        $userObj = EmailOtp::firstOrNew(['email' => $email]);
        $userObj->otp = $otp;
        $userObj->save();

        EmailQueue::add([
            'to' => $email,
            'subject' => "SignUp OTP",
            'view' => 'mail',
            'type' => 0,
            'viewArgs' => [
                'name' => $userObj->full_name ?? 'User', // Ensure a fallback if full_name is not set
                'body' => "Your Email OTP is: $otp",
            ],
        ]);
        return returnSuccessResponse('OTP sent successfully', ['otp' => $otp]);
    }


    public function verifyEmailOtp(Request $request)
    {
        $rules = [
            'email' => 'required',
            'otp' => 'required'
        ];

        $inputArr = $request->all();
        $validator = Validator::make($inputArr, $rules);
        if ($validator->fails()) {
            $errorMessages = $validator->errors()->all();
            throw new HttpResponseException(returnValidationErrorResponse($errorMessages[0]));
        }

        $userObj = EmailOtp::where('email', $inputArr['email'])
                        ->where('otp', $inputArr['otp'])
                        ->first();
        if (!$userObj) {
            return returnNotFoundResponse('Invalid OTP');
        }

        $userObj->verified = 1;
        $userObj->save();

        return returnSuccessResponse('Otp verified successfully');
    }
    public function resetPassword(Request $request, User $user)
    {

    	$rules = [
                    'user_id' => 'required',
                    'reset_password_otp' => 'required',
                    'new_password' => 'required',
                    'confirm_new_password' => 'required|same:new_password'

                ];
         $inputArr = $request->all();
        $validator = Validator::make($inputArr, $rules);
        if ($validator->fails()) {
            $errorMessages = $validator->errors()->all();
            throw new HttpResponseException(returnValidationErrorResponse($errorMessages[0]));
        }

        $userObj = User::where('id', $inputArr['user_id'])
                        ->where('email_verification_otp', $inputArr['reset_password_otp'])
                        ->first();
        if (!$userObj) {
            return returnNotFoundResponse('Invalid reset password OTP');
        }

        $userObj->email_verification_otp = null;
        $userObj->password = $inputArr['new_password'];
        $userObj->save();

        return returnSuccessResponse('Password reset successfully');
    }

    public function sendSMSOTP(Request $request)
    {
        date_default_timezone_set('Asia/Manila');
        
        $countryCode = preg_replace('/[^\p{L}\p{N}\s]/u', '', $request->country_code);
        $number = $request->to;
        $fullNumber = $countryCode . $number;

        // Check if the number is already in the database
        $verification = DB::table('verifications')->where('number', $fullNumber)->first();

        // Determine the current time
        $now = Carbon::now();

        // If no existing verification record is found
        if (!$verification) {
            $response = $this->myCurl(
                'To=%2B' . $fullNumber . '&Channel=sms',
                "https://verify.twilio.com/v2/Services/VAd2e21b5c21757f6ee0ee2aef26efa46e/Verifications"
            );

            // Check if the response status is pending
            if (json_decode($response, true)["status"] == "pending") {
                DB::table('verifications')->insert([
                    'number' => $fullNumber,
                    'last_sent' => $now,
                ]);
                return response()->json(['status' => 'success']);
            } else {
                return response()->json(['error' => 'invalid number'], 400);
            }
        } else {
            // If a verification record is found
            $lastSent = Carbon::parse($verification->last_sent);
            $diffInSeconds = $now->diffInSeconds($lastSent);

            // Check if the last OTP was sent more than 5 minutes ago
            if ($diffInSeconds > 300) {
                $response = $this->myCurl(
                    'To=%2B' . $fullNumber . '&Channel=sms',
                    "https://verify.twilio.com/v2/Services/VAd2e21b5c21757f6ee0ee2aef26efa46e/Verifications"
                );

                // Check if the response status is pending
                if (json_decode($response, true)["status"] == "pending") {
                    DB::table('verifications')->updateOrInsert(
                        ['number' => $fullNumber],
                        ['last_sent' => $now]
                    );
                    return response()->json(['status' => 'success']);
                } else {
                    return response()->json(['error' => 'invalid number'], 400);
                }
            } else {
                // Return the time difference if less than 5 minutes
                return response()->json(['wait' => $diffInSeconds]);
            }
        }
    }

   
    public function verifySMSOTP(Request $request)
    {
        $countryCode = preg_replace('/[^\p{L}\p{N}\s]/u', '', $request->country_code);
        $number = $request->to;
        $code = $request->code;
        $fullNumber = $countryCode . $number;

        $response = $this->myCurl(
            'To=%2B' . $fullNumber . '&Code=' . $code,
            'https://verify.twilio.com/v2/Services/VAd2e21b5c21757f6ee0ee2aef26efa46e/VerificationCheck'
        );

        $responseArray = json_decode($response, true);

        if ($responseArray["status"] === "approved") {
            // Update the verification status in the database
            DB::table('verifications')->where('number', $fullNumber)->update(['status' => 'approved']);

            // Return success response
            return response()->json([
                'status' => 'success',
                'message' => 'Verification successful.'
            ]);
        } else {
            // Return failure response
            return response()->json([
                'status' => 'error',
                'message' => 'Incorrect verification code.'
            ], 400);
        }
    }

    function  myCurl($fields,$url){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/x-www-form-urlencoded',
        ]);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, 'AC14ff1f5c9884022eb526c176626b2e9b:4b64df1c82c0d4ab9286a671cc20b9b1');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

        $response = curl_exec($ch);

        curl_close($ch);
        return $response;
    }

    // Function to get all roles and return as json
    public function getRoles(){
        $role = Role::getAllRole();
        return response()->json([
            'status' => 'success',
            'data' => $role
        ]);
    }
    
    public function getFarmOwnerShip(){
        $farm = FarmOwnership::getAllFarmOwnerShip();
        return response()->json([
            'status' => 'success',
            'data' => $farm
        ]);
    }
}
