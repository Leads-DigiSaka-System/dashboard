<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JasMonitoring extends Model
{
    protected $table = 'jas_monitoring';
    use HasFactory;

    protected $primaryKey = 'monitoring_id';
    public $timestamps = false;

    protected $fillable = [
        'monitoring_id',
        'jas_profile_id',
        'year',
        'product',
        'pest_disease',
        'rate_water',
        'timing',
        'added_by',
        'batch',
        'location',
        'duration',
        'fertilizer',
    ];

    public function profile()
    {
        return $this->belongsTo(JasProfile::class, 'jas_profile_id');
    }

}
