<?php

namespace App\Core\Exception\User;

class BadPasswordSecurityException extends \Exception
{
    const DEFAULT_MESSAGE = 'Mot de passe trop faible !';

    public function __construct($messages = self::DEFAULT_MESSAGE, $code = 0, \Exception $previous = null)
    {
        parent::__construct($messages, $code, $previous);
    }
}
