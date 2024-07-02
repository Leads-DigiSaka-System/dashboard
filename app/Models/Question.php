<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'field_name',
        'field_type',
        'required_field',
        'conditional',
        'sub_field_type',
        'questionnaire_id',
        'farm_categ',
        'status'
    ];

    public static function getColumnForSorting($value){

        $list = [
            0=>'id',
            1=>'field_name',
            2=>'field_type',
            3=>'sub_field_type',
            4=>'created_at'
        ];

        return isset($list[$value])?$list[$value]:"";
    }

    public function getAllQuestions($request = null, $flag = false) {

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
        $query = self::orderBy($column, $order);

        if(!empty($request)){

            $search = $request['search']['value'];

            if(!empty($search)){
                $query->orWhere('id', 'LIKE', '%'. $search .'%')
                ->orWhere('field_name', 'LIKE', '%'. $search .'%')
                ->orWhere('field_type', 'LIKE', '%'. $search .'%')
                ->orWhere('sub_field_type', 'LIKE', '%'. $search .'%');

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
