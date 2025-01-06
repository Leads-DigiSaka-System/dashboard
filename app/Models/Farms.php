<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Intervention\Image\ImageManagerStatic as Image;
class Farms extends Model
{
    use HasFactory;
    protected $fillable = [
        'farmer_id',
        'farm_id',
        'area_location',
        'profile_image',
        'farm_image',
        'image_latitude',
        'image_longitude',
        'region',
        'province',
        'municipality',
        'barangay',
        'area',
        'isDemo',
        'category'
    ];

      public static function getColumnForSorting($value){

        $list = [
            0=>'id',
            1=>'name',
            2=>'farm_id',
            3=>'area_location',
            4=>'created_at'
        ];

        return isset($list[$value])?$list[$value]:"";
    }
     public function farmerDetails()
    {
        return $this->belongsTo(User::class, 'farmer_id', 'id');
    }
      public function getAllFarms($request = null,$flag = false)
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
        $query = self::orderBy($column, $order);


        if(!empty($request)){

            $search = $request['search']['value'];

            if(!empty($search)){
                 $query->whereHas('farmerDetails',function ($query) use($request,$search){
             $query->orWhere( 'name', 'LIKE', '%'. $search .'%')
                            ->orWhere('farm_id', 'LIKE', '%'. $search .'%')
                            ->orWhere('area_location', 'LIKE', '%'. $search .'%')
                            ->orWhere('created_at', 'LIKE', '%' . $search . '%')
                            ->orWhere('full_name', 'LIKE', '%'. $search .'%');

                    });






                 if($flag)
                    return $query->count();
            }

            $start =  $request['start'];
            $length = $request['length'];
            $query->with('farmerDetails.roleDetails');

            $query->offset($start)->limit($length);

        }

        $query = $query->get();

        foreach ($query as $result) {
            $result->registered_date = $result->created_at ? Carbon::parse($result->created_at)->format('M d, Y g:iA') : 'N/A';
        }
        return $query;
    }

    public  function findFarmById($id){
        return self::find($id);
    }

       public function saveNewFarm($inputArr){
        return self::create($inputArr);
    }

    public function getFarmList($farmer_id)
    {
        return self::with('farmerDetails')->where('farmer_id',$farmer_id)->get();
    }
    public function getFarmAll($demo = 'all', $category = 'all')
    {
        $query = self::with('farmerDetails');

        if ($demo !== 'all') {
            $query->where('isDemo', $demo);
        }

        if ($category !== 'all') {
            $query->where('category', $category);
        }

        return $query->get();
    }
      public function getFarmDetail($farm_id)
    {
        return self::with('farmerDetails')->where('id',$farm_id)->first();
    }

    //get all farm with farmer details
    public static function getAllFarmWithFarmerDetails($restriction = NULL)
    {
        return self::with('farmerDetails')->where(function($query) use ($restriction) {
            $query->where('region', 'like', $restriction);
            if($restriction == "%%"){
                $query->orWhereNull('region');
            }
        })->get();
    }

    public static function getRandomFarmWthFarmerDetails($restriction = NULL) {
        $farms = self::whereHas('farmerDetails', function ($query) {
            $query->where('via_app', 1);
        })
        ->with('farmerDetails')
        ->where(function($query) use ($restriction) {
            $query->where('region', 'like', $restriction);
            if ($restriction == "%%") {
                $query->orWhereNull('region');
            }
        })
        ->inRandomOrder()
        ->limit(5)
        ->get();
    
        // Filter farms to exclude pure black images
        foreach ($farms as $farm) {
            if (!empty($farm->farm_image)) {
                $images = explode(',', $farm->farm_image);
                $filteredImages = [];
                foreach ($images as $image) {
                    $imagePath = public_path($image);
                    if (file_exists($imagePath) && !self::isPureBlack($imagePath)) {
                        $filteredImages[] = $image;
                    }
                }
                // Update farm_image with only valid images
                $farm->farm_image = implode(',', $filteredImages);
            }
        }
    
        return $farms;
    }
    
    private static function isPureBlack($imagePath) {
        $img = imagecreatefromstring(file_get_contents($imagePath));
        $width = imagesx($img);
        $height = imagesy($img);
    
        for ($x = 0; $x < $width; $x++) {
            for ($y = 0; $y < $height; $y++) {
                $rgb = imagecolorat($img, $x, $y);
                $colors = imagecolorsforindex($img, $rgb);
    
                if ($colors['red'] !== 0 || $colors['green'] !== 0 || $colors['blue'] !== 0) {
                    imagedestroy($img);
                    return false;
                }
            }
        }
    
        imagedestroy($img);
        return true; // Image is pure black
    }
}
