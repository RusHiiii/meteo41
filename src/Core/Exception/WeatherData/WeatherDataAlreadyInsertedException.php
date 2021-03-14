<?php

namespace App\Core\Exception\WeatherData;

class WeatherDataAlreadyInsertedException extends \Exception
{
    public function __construct($messages = null, $code = 0, \Exception $previous = null)
    {
        parent::__construct($messages, $code, $previous);
    }
}
