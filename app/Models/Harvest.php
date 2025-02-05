<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Harvest extends Model
{
    use HasFactory;

    protected $table = 'harvest';

    protected $fillable = [
        'jasprofile_id',
        'variety',
        'seeding_rate',
        'planting_date',
        'harvesting_date',
        'farm_location',
        'farm_size',
        'method_harvesting',
        'number_of_canvas',
        'total_yield_weight_kg',
        'total_yield_weight_tons',
        'validator',
        'validator_signature',
        'kgs_per_cavan'
    ];
}
