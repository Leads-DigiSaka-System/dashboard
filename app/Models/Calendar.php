<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calendar extends Model
{
    protected $table = 'events';
    use HasFactory;

    protected $fillable = [
        'title', 
        'activity_type', 
        'start_date', 
        'end_date', 
        'created_by', 
        'created_at', 
        'updated_at'
    ];
    public $timestamps = false;

}