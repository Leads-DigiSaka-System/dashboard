<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JasActivity extends Model
{
    protected $table = 'jas_activities';
    use HasFactory;

    public $timestamps = false;

    public function monitoringData()
    {
        return $this->hasMany(JasMonitoringData::class, 'activity_id','activity_id');
    }
}
