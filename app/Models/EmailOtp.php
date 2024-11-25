<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailOtp extends Model
{
    protected $table = 'email_otp';
    use HasFactory;
    protected $fillable = [
        'email',  
        'otp',
    ];
    public $timestamps = false;
}
