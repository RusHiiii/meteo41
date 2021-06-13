<?php

namespace App\Core\Exception\WeatherStation;

class DuplicateWeatherStationFoundException extends \Exception
{
    const DEFAULT_MESSAGE = 'Station météo dupliquée !';

    public function __construct($messages = self::DEFAULT_MESSAGE, $code = 0, \Exception $previous = null)
    {
        parent::__construct($messages, $code, $previous);
    }
}
