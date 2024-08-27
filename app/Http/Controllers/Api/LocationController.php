<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Municipality;
use App\Models\Barangay;
use App\Models\Province;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Http\Exceptions\HttpResponseException;
use Carbon\Carbon;
use App\Models\Role;
use Illuminate\Support\Facades\DB;


class LocationController extends Controller
{

    //Function to get all regions and return as json
    public function getRegions(){
        $regions = Region::getRegions();
        return response()->json([
            'status' => 'success',
            'data' => $regions
        ]);
    }

    //Function to get all provinces based on regionCode and return as json
    public function getProvinces($regionCode){
        $provinces = Province::getProvince($regionCode);
        return response()->json([
            'status' => 'success',
            'data' => $provinces
        ]);
    }

    //Function to get all municipalities based on provinceCode and return as json
    public function getMunicipalities($regionCode, $provinceCode){
        $municipalities = Municipality::getMunicipalities($provinceCode);
        return response()->json([
            'status' => 'success',
            'data' => $municipalities
        ]);
    }

    //Function to get location based on search and return as json
    public function searchLocation($search){
        $data = Municipality::searchLocation($search);
        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }
    public function searchProvince($prov_code = 0){
     
        $data = Province::where('provcode', $prov_code)->limit(20)->get();
        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }
    public function searchBarangay($search, $reg, $prov, $muni){
        $data = Barangay::searchBarangay($search, $reg, $prov, $muni);
        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }
    
}
