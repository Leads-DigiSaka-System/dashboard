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
    ];
}
