<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory;

    protected $fillable = [];

    public static function getProvince($regionCode)
    {
        return self::select('provcode', 'name')->where('regcode', $regionCode)->get();
    }
    public static function getAllArea()
    {
        $areas = self::select('area')
            ->whereNotNull('area')
            ->orderBy('area', 'asc')
            ->distinct()
            ->pluck('area');

        return $areas->prepend('All', '')->map(function ($area) {
            return [
                'value' => $area,
                'label' => $area,
            ];
        })->toArray();
    }
}
