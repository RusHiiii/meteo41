<?php

namespace App\Core\Exception\WeatherData;

class NoWeatherDataFoundException extends \Exception
{
    const DEFAULT_MESSAGE = 'Aucune données météo disponible actuellement :(';

    public function __construct($messages = self::DEFAULT_MESSAGE, $code = 0, \Exception $previous = null)
    {
        parent::__construct($messages, $code, $previous);
    }
}
