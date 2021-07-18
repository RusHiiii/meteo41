<?php

namespace App\Core\Calculator;

class HeatIndexCalculator
{
    /**
     * @param float $tempF
     * @param int $humidity
     * @return float
     */
    public function getHeatIndex(float $tempF, int $humidity)
    {
        if ($tempF <= 40) {
            return $tempF;
        }

        $hi = 0.5 * ($tempF + 61.0 + ($tempF - 68.0) * 1.2 + $humidity * 0.094);
        if ($hi >= 80) {
            $hi = -42.379 + (2.04901523 * $tempF) + (10.14333127 * $humidity) + (-0.22475541 * $tempF * $humidity) + (-6.83783 * exp(-3) * $tempF ** 2) + (-5.481717 * exp(-2) * $humidity ** 2) + (1.22874 * exp(-3) * $tempF ** 2 * $humidity) + (8.5282 * exp(-4) * $tempF * $humidity ** 2) + (-1.99 * exp(-6) * $tempF ** 2 * $humidity ** 2);

            if ($humidity <= 13 && $tempF >= 80 && $tempF <= 112) {
                $adj1 = (13 - $humidity) / 4;
                $adj2 = sqrt((17 - abs($tempF - 95)) / 17);
                $adj = $adj1 * $adj2;
                $hi = $hi - $adj;

                return round($hi, 1);
            }

            if ($humidity > 85 && $tempF >= 80 && $tempF <= 87) {
                $adj1 = ($humidity - 85) / 10;
                $adj2 = (87 - $tempF) / 5;
                $adj = $adj1 * $adj2;
                $hi = $hi + $adj;

                return round($hi, 1);
            }
        }

        return round($hi, 1);
    }
}
