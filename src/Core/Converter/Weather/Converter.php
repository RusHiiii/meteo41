<?php

namespace App\Core\Converter\Weather;

interface Converter
{
    public function convertImperialToMetric(float $value);

    public function convertMetricToImperial(float $value);
}
