<?php

namespace App\Core\Exception\ExternalApi;

class OpenWeatherException extends \Exception
{
    const DEFAULT_MESSAGE = 'Impossible de trouver la météo';

    public function __construct($messages = self::DEFAULT_MESSAGE, $code = 0, \Exception $previous = null)
    {
        parent::__construct($messages, $code, $previous);
    }
}
