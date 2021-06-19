<?php

namespace App\Core\Exception\WeatherStation;

class WeatherStationNotFoundException extends \Exception
{
    const DEFAULT_MESSAGE = 'Station météo non trouvée !';

    public function __construct($messages = self::DEFAULT_MESSAGE, $code = 0, \Exception $previous = null)
    {
        parent::__construct($messages, $code, $previous);
    }
}
