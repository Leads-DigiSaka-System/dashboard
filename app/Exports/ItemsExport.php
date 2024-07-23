<?php

namespace App\Exports;

use App\Models\Farms; // Replace with your model
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Auth, DB;

class ItemsExport implements FromCollection, WithHeadings
{
 protected $id;

 function __construct($id) {
        $this->id = $id;
 }   

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
    public function collection()
    {

        $data = [];
         if($this->id!='all')
            {
            //    $listings = Farms::where('farmer_id',$this->id)->get(); 
                $restriction = $this->getRegionFilter();
                $listings = DB::table("farms")
                    ->select("users.*", "roles.title as role_title", "farms.*")
                    ->join("users", "users.id", "=", "farms.farmer_id")
                    ->join("roles", "roles.id", "=", "users.role")
                    ->where('farmer_id',$this->id)
                    ->where(function($query) use ($restriction) {
                        $query->where('farms.region', 'like', $restriction);
                        if($restriction == "%%"){
                            $query->orWhereNull('farms.region');
                        }
                    })->get();
            }
            else{
                // $listings = Farms::all();
                $restriction = $this->getRegionFilter();
                $listings = DB::table("farms")
                    ->select("users.*", "roles.title as role_title", "farms.*")
                    ->join("users", "users.id", "=", "farms.farmer_id")
                    ->join("roles", "roles.id", "=", "users.role")
                    ->where(function($query) use ($restriction) {
                        $query->where('farms.region', 'like', $restriction);
                        if($restriction == "%%"){
                            $query->orWhereNull('farms.region');
                        }
                    })->get();
            }
        foreach ($listings as $key => $listing) {
             $farm_images=explode(',',$listing->farm_image);
                foreach ($farm_images as $keys => $image) {

                 $farm_image[$key][]=url($image);
                }
            $data[] = [
            $listing->id,
            $listing->farm_id,
            $listing->full_name,
            implode(',',$farm_image[$key]),
            $listing->area_location,
            $listing->image_latitude,
            $listing->image_longitude,
            date('d-m-Y',(strtotime($listing->created_at))),
            // Add more fields as needed
        ];
        }
         return collect($data);
    }
    public function headings(): array
    {
        return ['Id', 'Farm Id', 'Farmer Name','Farm Image','Coordinates','Image Latitude','Image Longitude','Created At'];
    }
}

