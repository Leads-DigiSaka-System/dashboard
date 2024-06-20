<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    protected $table = 'journals';
    use HasFactory;

    public $timestamps = false;
}
