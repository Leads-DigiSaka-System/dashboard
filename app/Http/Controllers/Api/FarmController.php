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

class FarmController extends Controller
{

    public function index(Request $request,Farms$farms)
    {
        $farmsArr=$farms->getFarmList(Auth::id());
        $listArr=array();

        if(!empty($farmsArr))
        {
            foreach ($farmsArr as $key => $value) {

            $survey_detail=Survey::where('farmer_id',Auth::id())->where('farm_id',$value->id)->first();
            if(!empty($survey_detail))
            {
                $value->isSurvey=true;
            }
            else{
                $value->isSurvey=false;
            }

            $value['farm_image']=explode(',' ,$value->farm_image);
            array_push($listArr,$value);
         }
        }
        return returnSuccessResponse('Farm list get successfully.', $listArr);

    }
    public function store(Request $request, Farms $farm)
    {
        $rules = array(
            //'farm_id' =>  'required|unique:farms,farm_id,NULL,id',
            'area_location' => 'required',
            'farm_image'=>'required',
            'region' => 'required',
            'province' => 'required',
            'municipality' => 'required',
            'area' => 'required',
            'image_latitude'=>'required',
            'image_longitude'=>'required',
            'barangay' => 'required'
        );

         
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errorMessages = $validator->errors()->all();
            throw new HttpResponseException(returnValidationErrorResponse($errorMessages[0]));
        }
       /*  if ($request->file('profile_image')) {
                $file = $request->file('profile_image');
                $filename = $file->getClientOriginalName();
                $filename = time() . '_' . $filename;
                $path = 'upload/images';
                $file->move($path, $filename);
                $profile_image = $path . '/' . $filename;
            }*/
            $farm_images = array();
            if ($files = $request->file('farm_image')) {
                foreach ($files as $file) {
                    $name = $file->getClientOriginalName();
                    $path = 'upload/images';
                    $file->move($path, $name);
                    $farm_images[] = $path . '/' . $name;
                }
            }
            
            $farmArr['farmer_id'] = isset($request->farmer_id) ? $request->farmer_id : Auth::id();
            $farmArr['area_location']=$request->area_location;
            $farmArr['image_latitude']=$request->image_latitude;
            $farmArr['image_longitude']=$request->image_longitude;
            $farmArr['region'] = $request->region;
            $farmArr['province'] = $request->province;
            $farmArr['municipality'] = $request->municipality;
            $farmArr['area'] = $request->area;
            $farmArr['barangay'] =$request->barangay;
            $farmArr['isDemo'] = $request->isDemo;
            $farmArr['category'] = $request->category;
            
            $farmArr['farm_image']=implode(",", $farm_images);
            $farmObj = $farm->saveNewFarm($farmArr);
            if (!$farmObj) {
            return returnErrorResponse('Unable to add farm. Please try again later');
            }
            $farmObj->farm_id=$farmCode='FARM'.$farmObj->id;
            $farmObj->save();

            return returnSuccessResponse('Farm added successfully!', $farmObj);
         }

      public function detail(Request $request,Farms $farms)
      {
        $rules = array(
            'farm_id' =>  'required',
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errorMessages = $validator->errors()->all();
            throw new HttpResponseException(returnValidationErrorResponse($errorMessages[0]));
        }
        $farm_id=$request->farm_id;
        $farmObj=$farms->getFarmDetail($farm_id);
        if(!empty($farmObj))
        {
        $farmObj['farm_image']=explode(",",$farmObj['farm_image']);
         return returnSuccessResponse('Farm detail', $farmObj);   
        }
         return returnNotFoundResponse('farm not found with this farm id');
     }

    public function update(Request $request)
    {

        $rules = [
            'id'=>'required',
            'area_location' => '',
            'farm_image'=>'',
            'region' => '',
            'province' => '',
            'municipality' => '',
            'area' => '',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errorMessages = $validator->errors()->all();
            throw new HttpResponseException(returnValidationErrorResponse($errorMessages[0]));
        }
        $thumb_image='';
        $id=$request->id;
          $farm_images = array();
            if ($files = $request->file('farm_image')) {
                foreach ($files as $file) {
                    $name = $file->getClientOriginalName();
                    $path = 'upload/images';
                    $file->move($path, $name);
                    $completePath[] = $path . '/' . $name;
                }
            }
         $farms = Farms::find($id);
        
        $farms->area_location ??= $request->area_location;
        $farms->image_latitude ??= $request->image_latitude;
        $farms->image_longitude ??= $request->image_longitude;
        $farms->region ??= $request->region;
        $farms->province ??= $request->province;
        $farms->municipality ??= $request->municipality;
        $farms->barangay ??= $request->barangay;
        $farms->area ??= $request->area;
        $farms->farm_image = isset($completePath) ?  implode(",", $completePath) : $farms->farm_image;
        
        if(!$farms->save()){
            return returnErrorResponse('Unable to update farm. Please try again later');
        }
        
        return returnSuccessResponse('Farm update successfully',$farms);
    }

      public function delete(Request $request)
    {
        

        $rules = [
            'farm_id'=>'required'
           ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errorMessages = $validator->errors()->all();
            throw new HttpResponseException(returnValidationErrorResponse($errorMessages[0]));
        }
        $farm_id=$request->farm_id;
        $farms = Farms::find($farm_id);
        if($farms->delete())
        {
         return returnSuccessResponse('Farms delete successfully');
        }
        return returnErrorResponse('Unable to delete farm. Please try again later');


    }
    public function farmer_delete(Request $request)
    {
        $rules = [
            'farmer_id'=>'required'
           ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errorMessages = $validator->errors()->all();
            throw new HttpResponseException(returnValidationErrorResponse($errorMessages[0]));
        }
        $farmer_id=$request->farmer_id;
        $farmer = User::where('id',$farmer_id)->first();
        if(empty($farmer))
        {
            return returnErrorResponse('Farmer not found');
        }
        if($farmer->delete())
        {
         return returnSuccessResponse('Farmer deleted successfully');
        }
        return returnErrorResponse('Unable to delete farmer. Please try again later');


    }
    public function getAllFarms($id = 0){
        if($id>0){
            $farms = Farms::where('id',$id)->get();
            return returnSuccessResponse('Farm list get successfully.', $farms);
        }
        $farms = Farms::all();
        return returnSuccessResponse('Farm list get successfully.', $farms);
    }
    public function getFarmsByID($id,Farms $farms){
        $farmObj=$farms->getFarmList($id);
        $listArr=array();

        if(!empty($farmObj))
        {
            foreach ($farmObj as $key => $value) {

            $survey_detail=Survey::where('farmer_id',Auth::id())->where('farm_id',$value->id)->first();
            if(!empty($survey_detail))
            {
                $value->isSurvey=true;
            }
            else{
                $value->isSurvey=false;
            }

            $value['farm_image']=explode(',' ,$value->farm_image);
            array_push($listArr,$value);
         }
        }
        return returnSuccessResponse('Farm list get successfully.', $listArr);
    }
    public function getFarms($demo, $category, Farms $farms)
    {
        $farmObj=$farms->getFarmAll($demo, $category);
        $listArr=array();

        if(!empty($farmObj))
        {
            foreach ($farmObj as $key => $value) {

            $survey_detail=Survey::where('farmer_id',Auth::id())->where('farm_id',$value->id)->first();
            if(!empty($survey_detail))
            {
                $value->isSurvey=true;
            }
            else{
                $value->isSurvey=false;
            }

            $value['farm_image']=explode(',' ,$value->farm_image);
            array_push($listArr,$value);
         }
        }
        return returnSuccessResponse('Farm list get successfully.', $listArr);
    }
       
}
