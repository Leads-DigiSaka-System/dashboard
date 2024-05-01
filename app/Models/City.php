<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function getCityByName($cityName){
        return self::where('name', $cityName)->first();
    }

    public function saveNewCity($inputArr){
        return self::create($inputArr);
    }

    public static function getCitiesDropdownArr(){
        return self::pluck('name', 'id')->toArray();
    }
}
