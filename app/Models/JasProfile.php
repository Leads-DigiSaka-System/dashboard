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
        'farmer_id',
        'batch',
        'location',
        'duration' ,
        'farm_id' ,
        'level' 
    ];

    public function monitoring()
    {
        return $this->hasMany(JasMonitoring::class, 'jas_profile_id');
    }

    public function monitoringData()
    {
        return $this->hasMany(JasMonitoringData::class, 'jas_profile_id');
    }

    public function farmer()
    {
        return $this->hasOne(User::class, 'id', 'farmer_id');
    }

    public function technician()
    {
        return $this->hasOne(User::class, 'id', 'technician');
    }

    public function technician_profile()
    {
        return $this->hasOne(User::class, 'id', 'technician');
    }
}
