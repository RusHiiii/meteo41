<?php

namespace App\Core\Exception\Unit;

class UnitNotFoundException extends \Exception
{
    const DEFAULT_MESSAGE = 'Unité non trouvée !';

    public function __construct($messages = self::DEFAULT_MESSAGE, $code = 0, \Exception $previous = null)
    {
        parent::__construct($messages, $code, $previous);
    }
}
