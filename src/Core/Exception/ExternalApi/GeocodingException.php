<?php

namespace App\Core\Exception\ExternalApi;

class GeocodingException extends \Exception
{
    const DEFAULT_MESSAGE = 'Impossible de trouver l\'adresse';

    public function __construct($messages = self::DEFAULT_MESSAGE, $code = 0, \Exception $previous = null)
    {
        parent::__construct($messages, $code, $previous);
    }
}
