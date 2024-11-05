<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveySet extends Model
{
    use HasFactory;

    protected $table = 'survey_set';

    protected $fillable = [
        'title',
        'slug',
        'description',
        'questionnaire_data',
        'expiry_date',
        'farm_categ',
        'status',
        'is_finalized',
    ];

    public static function getColumnForSorting($value){

        $list = [
            0=>'id',
            1=>'title',
            2=>'slug',
            3=>'description',
            4=>'questionnaire_data',
            5=>'status'
        ];

        return isset($list[$value])?$list[$value]:"";
    }

     public function getAllSurveySet($request = null, $flag = false) {

        if(isset($request['order'])){
            $columnNumber = $request['order'][0]['column'];
            $order = $request['order'][0]['dir'];
        }
        else {
            $columnNumber = 4;
            $order = "desc";
        }

        $column = self::getColumnForSorting($columnNumber);
        if($columnNumber == 0){
            $order = "desc";
        }

        if(empty($column)){
            $column = 'id';
        }
        $query = self::where('is_deleted',0)->orderBy($column, $order);

        if(!empty($request)){

            $search = $request['search']['value'];

            if(!empty($search)){
                $query->orWhere('id', 'LIKE', '%'. $search .'%')
                ->orWhere('title', 'LIKE', '%'. $search .'%')
                ->orWhere('description', 'LIKE', '%'. $search .'%');

                 if($flag)
                    return $query->count();
            }

            $start =  $request['start'];
            $length = $request['length'];

            $query->offset($start)->limit($length);

        }

        return $query->get();
    }
}
