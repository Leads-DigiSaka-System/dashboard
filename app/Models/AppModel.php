<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppModel extends Model
{
    protected $table = 'app';
    protected $fillable = [
        'filename', 'created_at', 'modified_at', 'changelog', 'views', 'downloads', 'version'
    ];
}
