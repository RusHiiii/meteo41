<?php

namespace App\Core\Exception\User;

class UserNotFoundException extends \Exception
{
    const DEFAULT_MESSAGE = 'Utilisateur non trouvé !';

    public function __construct($messages = self::DEFAULT_MESSAGE, $code = 0, \Exception $previous = null)
    {
        parent::__construct($messages, $code, $previous);
    }
}
