<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Demo extends Model
{
    use HasFactory;

    protected $guarded = [];

    public static function getDemoPerformed($product, $area, $provcode)
    {
        $query = self::join('provinces', 'demos.province', '=', 'provinces.provcode');

        if ($product !== null && $product !== 'All') {
            $query->where('product', $product);
        }

        if ($area !== null && $area !== 'All') {
            $query->where('area', $area);
        }

        if ($provcode !== null && $provcode !== 'All' && $provcode !== '1') {
            $query->where('province', $provcode);
        }

        return $query->count();
    }

    public static function getSampleUsed($product, $area, $provcode)
    {
        $query = self::join('provinces', 'demos.province', '=', 'provinces.provcode');

        if ($product !== null && $product !== 'All') {
            $query->where('product', $product);
        }

        if ($area !== null && $area !== 'All') {
            $query->where('area', $area);
        }

        if ($provcode !== null && $provcode !== 'All' && $provcode !== '1') {
            $query->where('province', $provcode);
        }

        return $query->sum('quantity');
    }

    public static function getPoints($product, $area, $provcode)
    {
        $query = self::join('users', 'demos.farmer_id', '=', 'users.id')
            ->join('provinces', 'demos.province', '=', 'provinces.provcode')
            ->join('municipalities', 'demos.municipality', '=', 'municipalities.muncode')
            ->join('products', 'demos.product', '=', 'products.id');

        if ($product !== null && $product !== 'All') {
            $query->where('demos.product', $product);
        }

        if ($area !== null && $area !== 'All') {
            $query->where('provinces.area', $area);
        }

        if ($provcode !== null && $provcode !== 'All' && $provcode !== '1') {
            $query->where('demos.province', $provcode);
        }

        return $query->select('demos.*', 'users.full_name', 'provinces.name as province_name', 'provinces.area', 'municipalities.name as municipality_name', 'products.*')->get();
    }
}
