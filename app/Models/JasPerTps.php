<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JasPerTps extends Model
{
    use HasFactory;

    protected $table = 'jas_profiles';  // Adjust the table name if necessary
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
        'duration',
        'address',
        'farm_id',
        'level',
        'technician', // The technician column we will filter by
    ];

    // Scope for retrieving records by technician column
    public function scopeByTechnician($query, $technician_id)
    {
        return $query->where('technician', $technician_id);
    }
}


?>