<?php

namespace App\Core\Calculator;

class WindChillCalculator
{
    /**
     * @param float $tempF
     * @param float $windSpeedMph
     * @return float|int
     */
    public function getWindChill(float $tempF, float $windSpeedMph)
    {
        if ($tempF <= 50 && $windSpeedMph >= 3) {
            $windChill = 35.74 + (0.6215 * $tempF) - (35.75 * ($windSpeedMph ** 0.16)) + ((0.4275 * $tempF) * ($windSpeedMph ** 0.16));
            return round($windChill, 1);
        }

        return $tempF;
    }
}
