<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    use HasFactory;

    protected $fillable = [
        'farm_id',
        'farmer_id',
        'survey_id',
        'survey_data',
        'status',
    ];
    const STATUS_COMPLETED = 1;
    const STATUS_PENDING = 0;

    public function getStatus()
    {

        $list = [
            self::STATUS_PENDING => "Pending",
            self::STATUS_COMPLETED => "Completed"
        ];

        return isset($list[$this->status]) ? $list[$this->status] : "Not defined";
    }

    public function getStatusBadge()
    {

        $list = [
            self::STATUS_COMPLETED => "primary",
            self::STATUS_PENDING => "danger"
        ];

        return isset($list[$this->status]) ? $list[$this->status] : "danger";
    }
    public function saveNewSurvey($inputArr)
    {
        return self::create($inputArr);
    }
    public static function getColumnForSorting($value)
    {

        $list = [
            0 => 'id',
            1 => 'farm_id',
            2 => 'status',
            4 => 'created_at'
        ];

        return isset($list[$value]) ? $list[$value] : "";
    }
    public function farmerDetails()
    {
        return $this->belongsTo(User::class, 'farmer_id', 'id');
    }
    public function farmDetails()
    {
        return $this->belongsTo(Farms::class, 'farm_id', 'id');
    }
    public function getAllSurvey($request = null, $flag = false, $version = null)
    {
        if (isset($request['order'])) {
            $columnNumber = $request['order'][0]['column'];
            $order = $request['order'][0]['dir'];
        } else {
            $columnNumber = 4;
            $order = "desc";
        }

        $column = self::getColumnForSorting($columnNumber);
        if ($columnNumber == 0) {
            $order = "desc";
        }

        if (empty($column)) {
            $column = 'id';
        }
        $query = self::orderBy($column, $order);
        
        if ($version !== null) {
            $query->where('version', $version);
        }

        if (!empty($request)) {

            $search = $request['search']['value'];

            if (!empty($search)) {
                $query->whereHas('farmerDetails', function ($query) use ($request, $search) {
                    $query->orWhere('status', 'LIKE', '%' . $search . '%')
                        ->orWhere('created_at', 'LIKE', '%' . $search . '%')
                        ->orWhere('full_name', 'LIKE', '%' . $search . '%');
                    ;
                });






                if ($flag)
                    return $query->count();
            }

            $start = $request['start'];
            $length = $request['length'];
            $query->offset($start)->limit($length);


        }

        $query = $query->get();
        return $query;
    }

    public function findSurveyById($id)
    {
        return self::find($id);
    }

    public function findSurveyByIdAndByVersion($id, $version)
    {
        return self::where('id', $id)
            ->where('version', $version)
            ->first();
    }

    public static function getAllSurveyByVersion($version)
    {
        return self::where('version', $version)->get();
    }
}
