<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Farms;
use App\Models\User;
use App\Models\Survey;
use Illuminate\Http\Exceptions\HttpResponseException;
use Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Auth;

class DigiSakaExplorrerController extends Controller
{

    public function loginWithToken(Request $request)
    {
        $rules = [
            'phone_code' => 'required',
            'phone_number' => 'required',
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
        if (isset($inputArr['email'])) {
            $userObj = User::where('email', $inputArr['email'])->first();
        } else {
            $userObj = User::where('phone_code', $inputArr['phone_code'])
                            ->where('phone_number', $inputArr['phone_number'])
                            ->first();
        }

        if (empty($userObj)) {
            return returnNotFoundResponse('Farmer Not found.');
        }

        if ($userObj->status == User::STATUS_INACTIVE) {
            return returnErrorResponse("Your account is inactive, please contact with admin.");
        }

        if (!Hash::check($inputArr['password'], $userObj->password, [])) {
            // Return if password doesn't match
            return response()->json([
                'statusCode' => 401,
                'message' => "We are sorry but your login credentials do not match!"
            ], 401);
        }

        $userObj->fcm_token = $inputArr['fcm_token'];
        $userObj->save();

        // Delete existing tokens and generate a new one
        $userObj->tokens()->delete();
        $authToken = $userObj->createToken('authToken')->plainTextToken;

        // Return only the id and auth_token in the response
        $response = [
            'id' => $userObj->id,
            'auth_token' => $authToken
        ];

        return returnSuccessResponse('Logged in successfully', $response);
    }

    public function create(Request $request, Farms $farm)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'farmer_id' => 'required|integer',
            'data' => 'required|array',
            'data.type' => 'required|string|in:Feature',
            'data.geometry' => 'required|array',
            'data.geometry.type' => 'required|string|in:Polygon',
            'data.geometry.coordinates' => 'required|array|min:1',
            'farm_image' => 'nullable|array',
            'farm_image.*' => 'file|mimes:jpeg,png,jpg,gif|max:2048',
            'region' => 'required|string',
            'province' => 'required|string',
            'municipality' => 'required|string',
            'barangay' => 'required|string',
            'area' => 'nullable|numeric',
            'image_latitude' => 'nullable|string',
            'image_longitude' => 'nullable|string',
            'isDemo' => 'nullable|integer',
            'category' => 'nullable|string'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }

        // Format the coordinates into the required structure: {"latLngs": [[lat, lng], [lat, lng], ...]}
        $coordinates = $request->data['geometry']['coordinates'];
        $formattedCoordinates = ['latLngs' => $coordinates];

        // Check if farm with the same coordinates already exists
        $existingFarm = Farms::whereJsonContains('area_location', $formattedCoordinates)->first();
        
        if ($existingFarm) {
            return response()->json(['error' => 'Farm with these coordinates already exists.'], 409);
        }

        // Handling image upload
        $farm_images = [];
        if ($files = $request->file('farm_image')) {
            foreach ($files as $file) {
                $name = time() . '_' . $file->getClientOriginalName();
                $path = 'upload/images';
                $file->move(public_path($path), $name);
                $farm_images[] = $path . '/' . $name;
            }
        }

        $farmArr = [
            'name' => $request->name,
            'farmer_id' => $request->farmer_id,
            'area_location' => json_encode($formattedCoordinates), // Store the coordinates in the desired format
            'image_latitude' => $request->image_latitude,
            'image_longitude' => $request->image_longitude,
            'region' => $request->region,
            'province' => $request->province,
            'municipality' => $request->municipality,
            'barangay' => $request->barangay,
            'area' => $request->area,
            'isDemo' => $request->isDemo ?? 0,
            'category' => $request->category,
            'farm_image' => implode(",", $farm_images)
        ];

        // Save farm entry
        $farmObj = $farm->create($farmArr);
        if (!$farmObj) {
            return response()->json(['error' => 'Unable to add farm. Please try again later'], 500);
        }

        // Generate farm_id after saving
        $farmObj->farm_id = 'FARM' . $farmObj->id;
        $farmObj->save();

        // Format response
        $response = [
            "id" => $farmObj->id,
            "name" => $farmObj->name,
            "data" => [
                "type" => "Feature",
                "geometry" => [
                    "type" => "Polygon",
                    "coordinates" => $coordinates // Directly use the coordinates array in the response
                ],
                "properties" => new \stdClass() // Empty object
            ]
        ];

        return response()->json($response, 201);
    }

    public function getFarmFields()
    {
        $fields = Farms::orderBy('id', 'desc')->get(['id', 'name']);
        
        return response()->json($fields);
    }

    public function show($id)
    {
        $farmField = Farms::find($id);

        if (!$farmField) {
            return response()->json(['error' => 'FarmField not found'], 404);
        }

        $coordinates = json_decode($farmField->area_location, true); 

        $response = [
            'id' => $farmField->id,
            'name' => $farmField->name,
            'data' => [
                'type' => 'Feature',
                'geometry' => [
                    'type' => 'Polygon',
                    'coordinates' => $coordinates
                ],
                'properties' => new \stdClass(), 
            ],
        ];

        return response()->json($response);
    }

    public function destroy($id)
    {
        $farmField = Farms::find($id);

        if (!$farmField) {
            return response()->json(['error' => 'FarmField not found'], 404);
        }

        $farmField->delete();

        // Return success message
        return response()->json(['message' => 'FarmField deleted successfully']);
    }


}
