<?php

namespace App\Helpers;

class LocationHelper
{
    public static function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000;

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        $distance = $earthRadius * $c;

        return self::formatDistance($distance);
    }

    private static function formatDistance($distance)
    {
        if ($distance < 1000) {
            return round($distance) . ' m';
        } else {
            return round($distance / 1000, 2) . ' km';
        }
    }
}
