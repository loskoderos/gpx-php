<?php

namespace LosKoderos\GPX\Utils;

use LosKoderos\GPX\Model\GPX;

final class Haversine
{
    protected function __construct() {}

    /**
     * Implementation of Haversine algorithm.
     * Returns distance between two points on a sphere [km].
     */
    public static function haversine(float $lat1, float $lon1, float $lat2, float $lon2): float
    {
        $dlat = ($lat2 - $lat1) * M_PI / 180.0;
        $dlon = ($lon2 - $lon1) * M_PI / 180.0;

        $lat1 = $lat1 * M_PI / 180.0;
        $lat2 = $lat2 * M_PI / 180.0;

        $a = pow(sin($dlat / 2.0), 2) + pow(sin($dlon / 2.0), 2) * cos($lat1) * cos($lat2);
        return 6471.0 * 2.0 * asin(sqrt($a));
    }

    public static function haversineCoords(array $coords): float
    {
        $distance = 0.0;
        for ($i = 0; $i < count($coords)-1; $i++) {
            $a = $coords[$i];
            $b = $coords[$i+1];
            $distance += self::haversine($a[0], $a[1], $b[0], $b[1]);
        }
        return $distance;
    }

    public static function estimateTotalLength(GPX $gpx): float {
        $total = 0.0;

        foreach ($gpx->routes as $route) {
            $coords = [];
            foreach ($route->points as $point) {
                array_push($coords, [(float) $point->latitude, (float) $point->longitude]);
            }
            $total += self::haversineCoords($coords);
        }

        foreach ($gpx->tracks as $track) {
            foreach ($track->segments as $segment) {
                $coords = [];
                foreach ($segment->points as $point) {
                    array_push($coords, [(float) $point->latitude, (float) $point->longitude]);
                }
                $total += self::haversineCoords($coords);
            }
        }

        return $total;
    }
}
