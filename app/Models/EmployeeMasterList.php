<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeMasterList extends Model
{
    protected $table = 'employee_masterlist';
    use HasFactory;

    protected $primaryKey = 'id';
    public $timestamps = false;
}
