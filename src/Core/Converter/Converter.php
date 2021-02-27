<?php

namespace App\Core\Converter;

interface Converter
{
    public function convertImperialToMetric(float $value);

    public function convertMetricToImperial(float $value);
}
