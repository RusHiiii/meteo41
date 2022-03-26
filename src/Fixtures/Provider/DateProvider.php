<?php

namespace App\Fixtures\Provider;

use Faker\Provider\Base as BaseProvider;
use Symfony\Component\Security\Core\Encoder\NativePasswordEncoder;

class DateProvider extends BaseProvider
{
    public function dateCreate()
    {
        return (new \DateTime())->format("Y-m-d");
    }
}
