<?php

namespace App\Core\Exception\User;

class RoleNotFoundException extends \Exception
{
    public function __construct($messages = null, $code = 0, \Exception $previous = null)
    {
        parent::__construct($messages, $code, $previous);
    }
}
