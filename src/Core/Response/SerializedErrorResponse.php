<?php


namespace App\Core\Response;



use Symfony\Component\HttpFoundation\Response;

class SerializedErrorResponse extends Response
{
    public function __construct($content = '', $statusCode = 400)
    {
        parent::__construct($content, $statusCode);
        $this->headers->set('Content-Type', 'application/json');
    }
}