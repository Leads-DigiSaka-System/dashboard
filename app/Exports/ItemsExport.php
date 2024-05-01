<?php

namespace App\Exports;

use App\Models\Farms; // Replace with your model
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ItemsExport implements FromCollection, WithHeadings
{
 protected $id;

 function __construct($id) {
        $this->id = $id;
 }   
    public function collection()
    {

        $data = [];
         if($this->id!='all')
            {
               $listings = Farms::where('farmer_id',$this->id)->get(); 
            }
            else{
                $listings = Farms::all();
            }
        foreach ($listings as $key => $listing) {
             $farm_images=explode(',',$listing->farm_image);
                foreach ($farm_images as $keys => $image) {

                 $farm_image[$key][]=url($image);
                }
            $data[] = [
            $listing->id,
            $listing->farm_id,
            $listing->farmerDetails->full_name,
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

