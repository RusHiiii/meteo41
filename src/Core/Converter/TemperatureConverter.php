<?php

namespace App\Core\Converter;

use App\Core\Exception\NotImplementedException;

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
     * @throws NotImplementedException
     */
    public function convertMetricToImperial(float $value)
    {
        throw new NotImplementedException();
    }
}
