<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JasMonitoringData extends Model
{
    protected $table = 'jas_monitoring_data';
    use HasFactory;

    protected $primaryKey = 'data_id';
    public $timestamps = false;

    protected $fillable = [
        'data_id',
        'jas_profile_id',
        'monitoring_id',
        'activity_id',
        'timing',
        'remarks',
        'observation',
        'signature',
        'added_by',
        'image1',
        'image2',
        'image3',
        'image4',
        'others',
    ];

    public function profile()
    {
        return $this->belongsTo(JasProfile::class, 'jas_profile_id','id');
    }

    public function activity()
    {
        return $this->hasOne(JasActivity::class, 'activity_id','activity_id');
    }

}
