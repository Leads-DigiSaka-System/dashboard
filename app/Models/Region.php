<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use HasFactory;

    protected $fillable = [
       
    ];

    public static function getRegions()
    {
        return self::select('regcode', 'name')->get();
    }
}
