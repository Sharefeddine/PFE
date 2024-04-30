<?php
function calculateDistanceCordinates($lat1, $lon1, $lat2, $lon2) {
    $earthRadius = 6371; // Radius of the Earth in kilometers
    $lat1 = deg2rad($lat1);
    $lon1 = deg2rad($lon1);
    $lat2 = deg2rad($lat2);
    $lon2 = deg2rad($lon2);
    $deltaLat = $lat2 - $lat1;
    $deltaLon = $lon2 - $lon1;
    $a = sin($deltaLat/2) * sin($deltaLat/2) + cos($lat1) * cos($lat2) * sin($deltaLon/2) * sin($deltaLon/2);
    $c = 2 * atan2(sqrt($a), sqrt(1-$a));
    $distance = $earthRadius * $c;
    return $distance;
}
function calculateDistances($coordinates) {
    $distance = 0 ;
    $count = count($coordinates);
    for ($i = 0; $i < $count - 1; $i++) {
        $lat1 = $coordinates[$i][0];
        $lon1 = $coordinates[$i][1];
        $lat2 = $coordinates[$i+1][0];
        $lon2 = $coordinates[$i+1][1];
        $distance = calculateDistanceCordinates($lat1, $lon1, $lat2, $lon2);
    }
    return number_format($distance, 2) ;
}
?>