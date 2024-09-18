<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DistanceController extends Controller
{
    /**
     * Calculate the distance between two locations.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function calculateDistance(Request $request)
    {
        $request->validate([
            'lat1' => 'required|numeric',
            'lng1' => 'required|numeric',
            'lat2' => 'required|numeric',
            'lng2' => 'required|numeric',
        ]);

        $lat1 = $request->input('lat1');
        $lng1 = $request->input('lng1');
        $lat2 = $request->input('lat2');
        $lng2 = $request->input('lng2');

        $distance = $this->haversineDistance($lat1, $lng1, $lat2, $lng2);

        return response()->json([
            'status' => 'success',
            'distance' => $distance,
        ]);
    }

    /**
     * Calculate the distance using the Haversine formula.
     *
     * @param float $lat1
     * @param float $lng1
     * @param float $lat2
     * @param float $lng2
     * @return float
     */
    private function haversineDistance($lat1, $lng1, $lat2, $lng2)
    {
        $earthRadius = 6371; 

        $lat1 = deg2rad($lat1);
        $lng1 = deg2rad($lng1);
        $lat2 = deg2rad($lat2);
        $lng2 = deg2rad($lng2);

        $dlat = $lat2 - $lat1;
        $dlng = $lng2 - $lng1;
        $a = sin($dlat / 2) ** 2 + cos($lat1) * cos($lat2) * sin($dlng / 2) ** 2;
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }
}
