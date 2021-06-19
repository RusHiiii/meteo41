<?php

namespace App\Core\Exception\Post;

class PostNotFoundException extends \Exception
{
    const DEFAULT_MESSAGE = 'Post non trouvé !';

    public function __construct($messages = self::DEFAULT_MESSAGE, $code = 0, \Exception $previous = null)
    {
        parent::__construct($messages, $code, $previous);
    }
}
