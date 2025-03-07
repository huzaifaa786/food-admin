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
        dd($distance);
        

        return $distance;
    }
    public static function calculateDistanceSql($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000;

        $dLat = "({$lat2} - {$lat1}) * pi() / 180";
        $dLon = "({$lon2} - {$lon1}) * pi() / 180";

        $a = "pow(sin({$dLat} / 2), 2) + cos({$lat1} * pi() / 180) * cos({$lat2} * pi() / 180) * pow(sin({$dLon} / 2), 2)";
        $c = "2 * atan2(sqrt({$a}), sqrt(1 - {$a}))";

        $distance = "{$earthRadius} * {$c}";

        return $distance;
    }

    public static function calculateTimeToReach($lat1, $lon1, $lat2, $lon2)
    {
        $distance = self::calculateDistance($lat1, $lon1, $lat2, $lon2);

        $distanceInKm = $distance / 1000;

        $timeInHours = $distanceInKm / 25;

        $timeInMinutes = round($timeInHours * 60);

        if ($timeInHours < 1) {
            return $timeInMinutes . ' m';
        } else {
            return round($timeInHours, 1) . ' h';
        }
    }

    public static function formatDistance($distance)
    {
        if ($distance < 1000) {
            return round($distance) . ' m';
        } else {
            return round($distance / 1000, 2) . ' km';
        }
    }
}
