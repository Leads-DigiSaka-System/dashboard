<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Municipality extends Model
{
    use HasFactory;

    protected $fillable = [];

    //get all municipalities based on provinceCode
    public static function getMunicipalities($provinceCode)
    {
        return self::select('munCode', 'name')->where('provcode', $provinceCode)->get();
    }

    //search municipalities, provinces, and regions based on search text joined with provinces and regions use join not union
    public static function searchLocation($search)
    {
        return self::select(
            'municipalities.name as mun_name',
            'municipalities.muncode as muncode',
            'provinces.name as provname',
            'municipalities.provcode as provcode',
            'regions.name as regname',
            'municipalities.regcode as regcode'
        )
            ->join('provinces', 'municipalities.provcode', '=', 'provinces.provcode')
            ->join('regions', 'municipalities.regcode', '=', 'regions.regcode')
            ->where('municipalities.name', 'like', '%' . $search . '%')
            ->orWhere('provinces.name', 'like', '%' . $search . '%')
            ->orWhere('regions.name', 'like', '%' . $search . '%')
            ->limit(10)
            ->get();
    }
}
