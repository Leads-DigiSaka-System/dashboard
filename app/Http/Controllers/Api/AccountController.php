<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\File;
 
use Illuminate\Http\Exceptions\HttpResponseException;
use Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Auth;
use Illuminate\Support\Facades\DB;

class AccountController extends Controller
{
    public function getFarmerByReferer($referer) {
        $farmers = User::with('role') // eager load the role
                    ->where('referer', $referer)
                    ->get(); // get all fields from users table
    
        return response()->json([
            'status' => 'success',
            'data' => $farmers->map(function($farmer) {
                $farmerData = $farmer->toArray(); 
                $farmerData['role_title'] = Role::find($farmer->role)->title; 
                return $farmerData;
            })
        ]);
    }
    
    public function changePassword(Request $request){

     	$rules = [
            'old_password' => 'required',
            'new_password' => 'required',
            'confirm_new_password' => 'required|same:new_password',
        ];
         $inputArr = $request->all();
        $validator = Validator::make($inputArr, $rules);
        if ($validator->fails()) {
            $errorMessages = $validator->errors()->all();
            throw new HttpResponseException(returnValidationErrorResponse($errorMessages[0]));
        }
        $userObj = $request->user();
        if (!$userObj) {
            return returnErrorResponse('User is not authorized');
        }

        if(!Hash::check($request->old_password, $userObj->password)){
            throw new HttpResponseException(returnValidationErrorResponse('Invalid old Password'));
        }

        $userObj->password = $request->get('new_password');
        if(!$userObj->save()){
            return returnErrorResponse('Unable to change Password');
        }

        $returnArr = $userObj->jsonResponse();
        $returnArr['auth_token'] = $request->bearerToken();
        return returnSuccessResponse('Password updated successfully', $returnArr);
    }

     public function getProfile(Request $request)
    {
        $userObj = $request->user();
        if (!$userObj) {
            return returnErrorResponse('User is not authorized');
        }

        $returnArr = $userObj->jsonResponse();
        $returnArr['auth_token'] = $request->bearerToken();
        

        return returnSuccessResponse('Farmer profile', $returnArr);
    }

    public function getFarmerInfo(Int $user_id)
    {
        $user = User::where('role', '2')
        ->where('id', $user_id)
        ->get();
        if (count($user) == 0) {
            return returnErrorResponse('Farmer not found');
        }else{
            return returnSuccessResponse('Farmer profile', $user);
        }

    }
    public function getAllMobile(){
        $users = User::where('role', '2')
        ->where('phone_number', '!=', '')
        ->select('phone_number', 'phone_code', 'full_name', 'id', 'verified')
        ->get();
    
        return returnSuccessResponse('All mobile numbers', $users);
    }
    public function notification(Request $request){

    	$rules = [
            'notification_type' => 'required|integer|min:1|max:2'
        ];
         $inputArr = $request->all();
        $validator = Validator::make($inputArr, $rules);
        if ($validator->fails()) {
            $errorMessages = $validator->errors()->all();
            throw new HttpResponseException(returnValidationErrorResponse($errorMessages[0]));
        }

        $user = auth()->user();

        if($request->notification_type == User::DEVICE_NOTIFICATION){
        	$attribute = "notification";
        }else{
        	 $attribute = "email_notification";

        }

    	if($user->$attribute == 1){
    		$user->$attribute = 0;
    		$message = "Notification off successfully.";
    	}else{
    		$user->$attribute = 1;
    		$message = "Notification on successfully.";
    	}
    	if($user->save())
    		return returnSuccessResponse($message, $user->jsonResponse());

    }
    public function updateRole(Request $request, $user_id){
        $rules = [
            'role' => 'required',

        ];
        $inputArr = $request->all();
        $validator = Validator::make($inputArr, $rules);
        if ($validator->fails()) {
            $errorMessages = $validator->errors()->all();
            throw new HttpResponseException(returnValidationErrorResponse($errorMessages[0]));
        }

        $userObj = User::find($user_id);
        if (!$userObj) {
            return returnErrorResponse('Farmer is not found');
        }
        $userObj->fill($request->all());
        
        if(!$userObj->save()){
            return returnErrorResponse('Unable to save data');
        }
        
        $returnArr = $userObj->jsonResponse();
        return returnSuccessResponse('Role updated successfully', $returnArr);
    }
    public function updateProfile(Request $request){
            $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'middle_name' => '',
            'profile_image' => '',
            'gender' => 'required',
            'dob' => 'required',
            'barangay' => 'required',
            'region' => 'required',
            'province' => 'required',
            'municipality' => 'required',
            'farming_years' => 'required',
            'farmer_ownership' => 'required',
            'crops' => 'required',
        ];
        
        $inputArr = $request->all();
        $validator = Validator::make($inputArr, $rules);
        if ($validator->fails()) {
            $errorMessages = $validator->errors()->all();
            throw new HttpResponseException(returnValidationErrorResponse($errorMessages[0]));
        }

        $userObj = $request->user();
        if (!$userObj) {
            return returnErrorResponse('Farmer is not authorized');
        }
        if ($file = $request->file('profile_image')) {
                 $name = $file->getClientOriginalName();
                    $path = 'upload/images';
                    $file->move($path, $name);
                    $profile_image = $path . '/' . $name;
                    $userObj->profile_image = $profile_image;     
            }

        $userObj->fill($request->all());
        $userObj->full_name = $request->first_name . ' ' . $request->last_name;
        $userObj->farmer_group = $request->farmer_group ?? '';
        
        
        if(!$userObj->save()){
            return returnErrorResponse('Unable to save data');
        }
        
        
        $returnArr = $userObj->jsonResponse();
        return returnSuccessResponse('Profile updated successfully', $returnArr);
    }

    public function updateProfileAdmin(Request $request){
        $rules = [
            'id' => '',
            'first_name' => 'required',
            'last_name' => 'required',
            'profile_image' => '',
            'gender' => 'required',
            'dob' => 'required',
            'barangay' => 'required',
            'region' => 'required',
            'province' => 'required',
            'municipality' => 'required',
            'farming_years' => 'required',
            'farmer_ownership' => 'required',
            'crops' => 'required',
        ];
    
        $inputArr = $request->all();
        $validator = Validator::make($inputArr, $rules);
        if ($validator->fails()) {
            $errorMessages = $validator->errors()->all();
            throw new HttpResponseException(returnValidationErrorResponse($errorMessages[0]));
        }

        $userObj = User::find($request->id);
        if (!$userObj) {
            return returnErrorResponse('Farmer is not authorized');
        }
        if ($file = $request->file('profile_image')) {
                 $name = $file->getClientOriginalName();
                    $path = 'upload/images';
                    $file->move($path, $name);
                    $profile_image = $path . '/' . $name;
                    $userObj->profile_image = $profile_image;     
            }

        $userObj->fill($request->all());
        $userObj->full_name = $request->first_name . ' ' . $request->last_name;
        
        
        if(!$userObj->save()){
            return returnErrorResponse('Unable to save data');
        }
        
        
        $returnArr = $userObj->jsonResponse();
        return returnSuccessResponse('Profile updated successfully', $returnArr);
    }

    public function userList($role){
        $users = User::where('role', $role)->get();

        if(count($users) == 0){
            return returnErrorResponse('No user found');
        }
        else{
            return returnSuccessResponse('User list', $users);
        }
    }
    
    public function userListVia($via_app = 0, $region = '', $province = '', $municipality = '', $search = ''){
        $query = User::query();
    
        if ($via_app > 0) {
            $query->where('via_app', $via_app);
        }
    
        if ($region !== '') {
            $query->where('region', $region);
        }
    
        if ($province !== '') {
            $query->where('province', $province);
        }
    
        if ($municipality !== '') {
            $query->where('municipality', $municipality);
        }
    
        $users = $query->get();
    
        if ($users->isEmpty()) {
            return returnErrorResponse('No user found');
        } else {
            return returnSuccessResponse('User list', $users);
        }
    }
    
    
    public function getProof($farmerId){
        $files = File::select(['filename'])->where('farmer_id', $farmerId)->orderBy('id', 'desc')->first();
        return returnSuccessResponse('get proof successful',$files);
    }

    public function verifyFarmer(Request $request){
        User::whereId($request->farmerId)->update([
            'verified' => 1,
        ]);
        return returnSuccessResponse('verification successful');
    }

    public function updateProfilePic(Request $request) {

        $userObj = $request->user();

        if (!$userObj) {
            return returnErrorResponse('Farmer is not authorized');
        }

        if ($file = $request->file('profile_image')) {
                $name = $file->getClientOriginalName();
                $path = 'upload/images';
                $file->move($path, $name);
                $profile_image = $path . '/' . $name;
                $userObj->profile_image = $profile_image;     
        }

        if(!$userObj->save()){
            return returnErrorResponse('Unable to save data');
        }

        $returnArr = $userObj->jsonResponse();
        return returnSuccessResponse('Successfully Updated Profile Picture', $returnArr);
    }
}
