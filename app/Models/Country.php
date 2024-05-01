<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function getCountryByCode($countryCode){
        return self::where('country_code', $countryCode)->first();
    }

    public function getCountryByName($countryName){
        return self::where('name', $countryName)->first();
    }

    public function saveNewCountry($inputArr){
        return self::create($inputArr);
    }

    public static function getCountriesDropdownArr(){
        return self::pluck('name', 'id')->toArray();
    }
}
