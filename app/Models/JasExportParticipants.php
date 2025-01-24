<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

function formatPhoneNumber($phone)
{
    if (preg_match('/^\+63(\d{10})$/', $phone, $matches)) {
        return '+63-' . substr($matches[1], 0, 3) . '-' . substr($matches[1], 3, 7);
    }
    return $phone;
}

class JasExportParticipants extends Model
{
    use HasFactory;

    protected $table = 'jas_profiles';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'first_name',
        'last_name',
        'middle',
        'birthdate',
        'phone',
        'variety_used_wet',
        'variety_used_dry',
        'average_yield_wet',
        'average_yield_dry',
        'dealers',
        'year',
        'active',
        'farmer_id',
        'batch',
        'area',
        'location',
        'province_id',
        'duration',
        'address',
        'farm_id',
        'level',
    ];

    // Relationship with farms table
    public function farm()
    {
        return $this->hasOne(FarmForExport::class, 'id', 'farm_id');
    }
}
