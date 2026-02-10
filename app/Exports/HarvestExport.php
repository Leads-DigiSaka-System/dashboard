<?php

// namespace App\Exports;

// use App\Models\Harvest;
// use Maatwebsite\Excel\Concerns\FromCollection;
// use Maatwebsite\Excel\Concerns\WithHeadings;
// use Maatwebsite\Excel\Concerns\WithStyles;
// use Maatwebsite\Excel\Concerns\WithColumnFormatting;
// use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

// class HarvestExport implements FromCollection, WithHeadings, WithStyles, WithColumnFormatting
// {
//     public function collection()
//     {
//         // Retrieve the harvest data along with related jasProfile data
//         return Harvest::with('jasProfile')
//             ->get()
//             ->map(function ($harvest) {
//                 // Concatenate full name from jasProfile
//                 $fullName = $harvest->jasProfile
//                     ? $harvest->jasProfile->first_name . ' ' . $harvest->jasProfile->middle . ' ' . $harvest->jasProfile->last_name
//                     : null; // If no jasProfile, set full_name to null
                
//                 // Return the data for export
//                 return [
//                     'id' => $harvest->id,
//                     'full_name' => $fullName,
//                     'farm_location' => $harvest->farm_location,
//                     'planting_date' => $harvest->planting_date,
//                     'harvesting_date' => $harvest->harvesting_date,
//                     'method' => $harvest->method_harvesting,
//                     'jasprofile_id' => $harvest->jasprofile_id,
//                     'variety' => $harvest->variety,
//                     'seeding_rate' => $harvest->seeding_rate,
//                     'farm_size' => $harvest->farm_size,
//                     'number_of_canvas' => $harvest->number_of_canvas,
//                     'total_yield_weight_kg' => $harvest->total_yield_weight_kg,
//                     'total_yield_weight_tons' => $harvest->total_yield_weight_tons,
//                     'validator' => $harvest->validator,
//                     'created_at' => $harvest->created_at,
//                     'updated_at' => $harvest->updated_at
//                 ];
//             });
//     }

//     public function headings(): array
//     {
//         return [
//             'ID', 'Full Name', 'Farm Location', 'Planting Date', 'Harvesting Date', 'Method',
//             'JasProfile ID', 'Variety', 'Seeding Rate', 'Farm Size', 'Number of Canvas',
//             'Total Yield Weight (kg)', 'Total Yield Weight (tons)', 'Validator',
//             'Created At', 'Updated At'
//         ];
//     }

//     public function styles(Worksheet $sheet)
//     {
//         // Center all data and apply header styling
//         $sheet->getStyle('A1:R1')->getFont()->setBold(true); // Make header bold
//         $sheet->getStyle('A1:R1')->getAlignment()->setHorizontal('center'); // Center header text
//         $sheet->getStyle('A1:R1')->getAlignment()->setVertical('center'); // Center header vertically

//         $sheet->getStyle('A2:R' . ($sheet->getHighestRow()))->getAlignment()->setHorizontal('center'); // Center data

//         // Resize columns to fit content
//         foreach (range('A', 'R') as $column) {
//             $sheet->getColumnDimension($column)->setAutoSize(true);
//         }
//     }

//     public function columnFormats(): array
//     {
//         return [
//             'A' => '0',  // ID column as number
//             'B' => '@',  // Full Name column as text
//             'C' => '@',  // Farm Location column as text
//             'D' => 'yyyy-mm-dd', // Planting Date column as date
//             'E' => 'yyyy-mm-dd', // Harvesting Date column as date
//             'F' => '@',  // Method column as text
//             'G' => '0',  // JasProfile ID column as number
//             'H' => '@',  // Variety column as text
//             'I' => '@',  // Seeding Rate column as text
//             'J' => '@',  // Farm Size column as text
//             'K' => '0',  // Number of Canvas column as number
//             'L' => '0',  // Total Yield Weight (kg) column as number
//             'M' => '0',  // Total Yield Weight (tons) column as number
//             'N' => '@',  // Validator column as text
//             'O' => 'yyyy-mm-dd', // Created At column as date
//             'P' => 'yyyy-mm-dd'  // Updated At column as date
//         ];
//     }
// }

namespace App\Exports;

use App\Models\Harvest;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class HarvestExport implements FromCollection, WithHeadings, WithStyles, WithColumnFormatting
{
    public function collection()
    {
        return Harvest::selectRaw('
            MIN(id) as id,
            jasprofile_id,
            MIN(farm_location) as farm_location,
            MIN(planting_date) as planting_date,
            MIN(harvesting_date) as harvesting_date,
            MIN(method_harvesting) as method,
            MIN(variety) as variety,
            MIN(seeding_rate) as seeding_rate,
            MIN(farm_size) as farm_size,
            MIN(number_of_canvas) as number_of_canvas,
            MIN(total_yield_weight_kg) as total_yield_weight_kg,
            MIN(total_yield_weight_tons) as total_yield_weight_tons,
            MIN(validator) as validator,
            MIN(created_at) as created_at,
            MIN(updated_at) as updated_at'
        )
        ->groupBy('jasprofile_id')
        ->with('jasProfile')
        ->get()
        ->map(function ($harvest) {
            $fullName = $harvest->jasProfile
                ? trim("{$harvest->jasProfile->first_name} {$harvest->jasProfile->middle} {$harvest->jasProfile->last_name}")
                : null;

            return [
                'id' => $harvest->id,
                'full_name' => $fullName,
                'farm_location' => $harvest->farm_location,
                'planting_date' => $harvest->planting_date,
                'harvesting_date' => $harvest->harvesting_date,
                'method' => $harvest->method,
                'jasprofile_id' => $harvest->jasprofile_id,
                'variety' => $harvest->variety,
                'seeding_rate' => $harvest->seeding_rate,
                'farm_size' => $harvest->farm_size,
                'number_of_canvas' => $harvest->number_of_canvas,
                'total_yield_weight_kg' => $harvest->total_yield_weight_kg,
                'total_yield_weight_tons' => $harvest->total_yield_weight_tons,
                'validator' => $harvest->validator,
                'created_at' => $harvest->created_at,
                'updated_at' => $harvest->updated_at
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID', 'Full Name', 'Farm Location', 'Planting Date', 'Harvesting Date', 'Method',
            'JasProfile ID', 'Variety', 'Seeding Rate', 'Farm Size', 'Number of Canvas',
            'Total Yield Weight (kg)', 'Total Yield Weight (tons)', 'Validator',
            'Created At', 'Updated At'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:P1')->getFont()->setBold(true);
        $sheet->getStyle('A1:P1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A1:P1')->getAlignment()->setVertical('center');
        $sheet->getStyle('A2:P' . ($sheet->getHighestRow()))->getAlignment()->setHorizontal('center');

        foreach (range('A', 'P') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }
    }

    public function columnFormats(): array
    {
        return [
            'A' => '0',
            'B' => '@',
            'C' => '@',
            'D' => 'yyyy-mm-dd',
            'E' => 'yyyy-mm-dd',
            'F' => '@',
            'G' => '0',
            'H' => '@',
            'I' => '@',
            'J' => '@',
            'K' => '0',
            'L' => '0',
            'M' => '0',
            'N' => '@',
            'O' => 'yyyy-mm-dd',
            'P' => 'yyyy-mm-dd'
        ];
    }
}
