<?php

namespace App\Core\Calculator;

use App\Core\Converter\Weather\TemperatureConverter;

class HumidexCalculator
{
    /** @var TemperatureConverter */
    private $temperatureConverter;

    /**
     * DewPointCalculator constructor.
     * @param TemperatureConverter $temperatureConverter
     */
    public function __construct(
        TemperatureConverter $temperatureConverter
    ) {
        $this->temperatureConverter = $temperatureConverter;
    }

    /**
     * @param float $tempF
     * @param float $dewPointF
     * @return float
     */
    public function getHumidex(float $tempF, float $dewPointF)
    {
        $tempC = $this->temperatureConverter->convertImperialToMetric($tempF);
        $dewPointC = $this->temperatureConverter->convertImperialToMetric($dewPointF);

        $humidex = $tempC + 0.5555 * (6.11 * exp(5417.7530 * ((1 / 273.16) - (1 / (273.15 + $dewPointC)))) - 10);

        if ($humidex < $tempC) {
            return $tempC;
        }

        return round($humidex, 1);
    }
}
