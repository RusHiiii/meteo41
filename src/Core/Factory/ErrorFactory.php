<?php

namespace App\Core\Factory;

use App\Entity\Core\Error;

class ErrorFactory
{
    public function create(\Exception $e)
    {
        $classname = (new \ReflectionClass($e))->getShortName();

        return new Error(
            $classname,
            empty($e->getMessage()) ? $classname : $e->getMessage()
        );
    }
}
