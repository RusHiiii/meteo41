<?php

namespace App\Fixtures\Provider;

use Faker\Provider\Base as BaseProvider;
use Symfony\Component\Security\Core\Encoder\NativePasswordEncoder;

class DateProvider extends BaseProvider
{
    public function dateCreate(string $period)
    {
        $date = new \DateTime();

        if ($period === 'Y') {
            return $date->format("Y");
        }

        if ($period === 'm') {
            return $date->format("m");
        }

        if ($period === 'd') {
            return $date->format("d");
        }

        throw new \RuntimeException();
    }
}
