<?php

namespace App\Exports;

use App\Models\Farms; // Replace with your model
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\Survey;
class SurveyExport implements FromCollection, WithHeadings
{
 protected $id;

 function __construct($id) {
        $this->id = $id;
 }   
    public function collection()
    {
        $survey= new Survey();
        $data = [];
        $surveyObj = $survey->findSurveyById($this->id);
        $survey_data=json_decode($surveyObj->survey_data);
        if(!empty($survey_data))
            {
            $questions=json_decode($survey_data->surveyResponse);
            
            $i=1;
           
              foreach ($questions->responses as $key => $value) {

                 if(!empty($value->answers ))
                 {
                    foreach ($value->answers as $keys => $val) 
                    {

                       $answers[$key][]=($val->text_response)??str_replace(',','',$val->row_value);

                    } 
                 }
                 else{
                    $answers[$key][]='';
                 }
                 $survey_list[]=array(
                        $i++,
                        '"'.$value->question_value.'"',
                        (implode('-',$answers[$key]))??''
                    );
                }
       
        }
      
         return collect($survey_list);
    }
    public function headings(): array
    {
        return ['Id','Question','Answer'];
    }
}

