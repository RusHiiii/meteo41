<?php

namespace App\Core\Exception\User;

class BadPasswordConfirmationException extends \Exception
{
    const DEFAULT_MESSAGE = 'Confirmation de mot de passe incorrect !';

    public function __construct($messages = self::DEFAULT_MESSAGE, $code = 0, \Exception $previous = null)
    {
        parent::__construct($messages, $code, $previous);
    }
}
