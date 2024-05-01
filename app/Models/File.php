<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $table = 'files_uploads';
    protected $fillable = ['filename', 'created_at', 'modified_at', 'created_by', 'modified_by', 'farmer_id'];
}
