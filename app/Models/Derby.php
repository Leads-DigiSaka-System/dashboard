<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Derby extends Model
{
    use HasFactory;

    protected $fillable = [];
    public function farmerDetails()
    {
        return $this->belongsTo(User::class, 'farmer_id', 'id');
    }
    public static function getAreaPlantedPerVariety()
    {
        $result = self::where('variety', '!=', '')
            ->groupBy('variety')
            ->selectRaw('variety, SUM(area_ha) as total_area')
            ->get()
            ->pluck('total_area', 'variety')
            ->toArray();

        return $result;
    }

    public static function getVarietyPlantedPerRegion()
    {
        $result = self::where('variety', '!=', '')
            ->groupBy('variety', 'region')
            ->selectRaw('variety, region, SUM(area_ha) as total_area')
            ->get()
            ->groupBy('region')
            ->map(function ($varietyData) {
                return $varietyData->pluck('total_area', 'variety')->toArray();
            })
            ->toArray();

        return $result;
    }
}
