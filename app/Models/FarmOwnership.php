<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FarmOwnership extends Model
{
    use HasFactory;

    protected $fillable = [
        
    ];

    public static function getAllFarmOwnerShip()
    {
        return self::select('id', 'name')->get();
    }
}
