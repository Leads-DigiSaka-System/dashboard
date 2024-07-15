<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barangay extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'refbrgy';

    //get all municipalities based on provinceCode
    public static function getMunicipalities($provinceCode)
    {
        return self::select('munCode', 'name')->where('provcode', $provinceCode)->get();
    }

    //search municipalities, provinces, and regions based on search text joined with provinces and regions use join not union
    public static function searchBarangay($search, $reg, $prov, $muni)
    {
        return self::select('*')
            ->where('brgyDesc', 'like', '%' . $search . '%')
            ->where('regCode', 'like', '%' . $reg . '%')
            ->where('provCode', 'like', '%' . $prov . '%')
            ->where('citymunCode', 'like', '%' . $muni . '%')
            ->limit(10)
            ->get();
    }
    
    
}
