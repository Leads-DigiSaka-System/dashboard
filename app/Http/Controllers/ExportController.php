<?php

namespace App\Http\Controllers;

use App\Exports\ItemsExport;
use App\Exports\SurveyExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Farms; 
use App\Models\Survey;
use Illuminate\Http\Response;
class ExportController extends Controller
{
      public function exportItems($id)
    {
         return Excel::download(new ItemsExport($id), 'farms.xlsx');
           
    }
    public function exportSurveyItems(Survey $survey,$id)
    {
        return Excel::download(new SurveyExport($id), 'survey.xlsx');

    }
        
}
