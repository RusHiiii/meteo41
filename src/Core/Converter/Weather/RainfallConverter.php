<?php

namespace App\Core\Converter\Weather;

use App\Core\Exception\NotImplementedException;

class RainfallConverter implements Converter
{
    /**
     * @param float $value
     * @return float
     */
    public function convertImperialToMetric(float $value)
    {
        $result = $value * 25.4;

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
