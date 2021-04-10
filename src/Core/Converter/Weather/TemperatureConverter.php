<?php

namespace App\Core\Converter\Weather;

class TemperatureConverter implements Converter
{
    /**
     * @param float $value
     * @return float
     */
    public function convertImperialToMetric(float $value)
    {
        $result = ($value - 32) / 1.8;

        return round($result, 1);
    }

    /**
     * @param float $value
     * @return float
     */
    public function convertMetricToImperial(float $value)
    {
        $result = ($value * 1.8) + 32;

        return round($result, 1);
    }
}
