<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function getStateByCode($stateCode){
        return self::where('state_code', $stateCode)->first();
    }
    public function getStateByName($stateName){
        return self::where('name', $stateName)->first();
    }

    public function saveNewState($inputArr){
        return self::create($inputArr);
    }

    public static function getStatesDropdownArr(){
        return self::pluck('name', 'id')->toArray();
    }
}
