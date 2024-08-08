<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JasProfile extends Model
{
    protected $table = 'jas_profiles';
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
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
        'image' ,
        'technician',
        'area',
        'farmer_id' ,
        'batch' 
    ];

    public function monitoring()
    {
        return $this->hasOne(JasMonitoring::class, 'jas_profile_id');
    }

    public function monitoringData()
    {
        return $this->hasMany(JasMonitoringData::class, 'jas_profile_id');
    }
}
