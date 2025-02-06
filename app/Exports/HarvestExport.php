<?php

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
        // Retrieve the harvest data along with related jasProfile data
        return Harvest::with('jasProfile')
            ->get()
            ->map(function ($harvest) {
                // Concatenate full name from jasProfile
                $fullName = $harvest->jasProfile
                    ? $harvest->jasProfile->first_name . ' ' . $harvest->jasProfile->middle . ' ' . $harvest->jasProfile->last_name
                    : null; // If no jasProfile, set full_name to null
                
                // Return the data for export
                return [
                    'id' => $harvest->id,
                    'full_name' => $fullName,
                    'farm_location' => $harvest->farm_location,
                    'planting_date' => $harvest->planting_date,
                    'harvesting_date' => $harvest->harvesting_date,
                    'method' => $harvest->method_harvesting,
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
        // Center all data and apply header styling
        $sheet->getStyle('A1:R1')->getFont()->setBold(true); // Make header bold
        $sheet->getStyle('A1:R1')->getAlignment()->setHorizontal('center'); // Center header text
        $sheet->getStyle('A1:R1')->getAlignment()->setVertical('center'); // Center header vertically

        $sheet->getStyle('A2:R' . ($sheet->getHighestRow()))->getAlignment()->setHorizontal('center'); // Center data

        // Resize columns to fit content
        foreach (range('A', 'R') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }
    }

    public function columnFormats(): array
    {
        return [
            'A' => '0',  // ID column as number
            'B' => '@',  // Full Name column as text
            'C' => '@',  // Farm Location column as text
            'D' => 'yyyy-mm-dd', // Planting Date column as date
            'E' => 'yyyy-mm-dd', // Harvesting Date column as date
            'F' => '@',  // Method column as text
            'G' => '0',  // JasProfile ID column as number
            'H' => '@',  // Variety column as text
            'I' => '@',  // Seeding Rate column as text
            'J' => '@',  // Farm Size column as text
            'K' => '0',  // Number of Canvas column as number
            'L' => '0',  // Total Yield Weight (kg) column as number
            'M' => '0',  // Total Yield Weight (tons) column as number
            'N' => '@',  // Validator column as text
            'O' => 'yyyy-mm-dd', // Created At column as date
            'P' => 'yyyy-mm-dd'  // Updated At column as date
        ];
    }
}
