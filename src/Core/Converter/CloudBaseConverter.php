<?php

namespace App\Core\Converter;

use App\Core\Exception\NotImplementedException;

class CloudBaseConverter implements Converter
{
    /**
     * @param float $value
     * @return float
     */
    public function convertImperialToMetric(float $value)
    {
        $result = $value / 3.281;

        return round($result);
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
