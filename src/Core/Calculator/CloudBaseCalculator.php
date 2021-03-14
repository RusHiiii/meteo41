<?php

namespace App\Core\Calculator;

class CloudBaseCalculator
{
    /**
     * @param float $tempF
     * @param float $dewPointF
     * @return float|int
     */
    public function getCloudBase(float $tempF, float $dewPointF)
    {
        $cloudBase = (($tempF - $dewPointF) / 4.4) * 1000;

        return round($cloudBase);
    }
}
