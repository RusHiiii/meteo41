<?php

namespace App\Core\Exception\Observation;

class ObservationNotFoundException extends \Exception
{
    const DEFAULT_MESSAGE = 'Observation non trouvée !';

    public function __construct($messages = self::DEFAULT_MESSAGE, $code = 0, \Exception $previous = null)
    {
        parent::__construct($messages, $code, $previous);
    }
}
