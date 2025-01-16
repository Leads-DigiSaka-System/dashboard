<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FarmForExport extends Model
{
    use HasFactory;

    protected $table = 'farms';
    public $timestamps = true;

    protected $fillable = [
        'id',
        'name',
        'farm_id',
        'area_location',
        'farmer_id',
        'region',
        'province',
        'municipality',
        'barangay',
        'area',
        'isDemo',
        'category',
    ];
}
