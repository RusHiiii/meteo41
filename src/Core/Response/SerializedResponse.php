<?php

namespace App\Core\Response;

use Symfony\Component\HttpFoundation\Response;

class SerializedResponse extends Response
{
    public function __construct($content = '', $statusCode = 200)
    {
        parent::__construct($content, $statusCode);
        $this->headers->set('Content-Type', 'application/json');
    }
}
