<?php 

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\JasPerTps;
use Illuminate\Http\Request;


class JasPerTpsController extends Controller
{
    // Method to fetch participants based on technician ID
    public function getParticipantsByTechnician($technician_id)
    {
        // Retrieve participants based on technician ID
        $participants = JasPerTps::byTechnician($technician_id)->get();

        return response()->json($participants);
    }
}

?>