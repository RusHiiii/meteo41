<?php

namespace App\Core\Calculator;

use App\Core\Exception\OutOfRangeException;

class AqiCalculator
{
    private $value = [
        '12.1' => ['I_high' => 50, 'I_low' => 0, 'C_high' => 12, 'C_low' => 0],
        '35.5' => ['I_high' => 100, 'I_low' => 51, 'C_high' => 35.4, 'C_low' => 12.1],
        '55.5' => ['I_high' => 150, 'I_low' => 101, 'C_high' => 55.4, 'C_low' => 35.5],
        '150.5' => ['I_high' => 200, 'I_low' => 151, 'C_high' => 150.4, 'C_low' => 55.5],
        '250.5' => ['I_high' => 300, 'I_low' => 201, 'C_high' => 250.4, 'C_low' => 150.5],
        '350.5' => ['I_high' => 400, 'I_low' => 301, 'C_high' => 350.4, 'C_low' => 250.5],
        '500.5' => ['I_high' => 500, 'I_low' => 401, 'C_high' => 500.4, 'C_low' => 350.5]
    ];

    /**
     * @param float $pm
     * @return int|string
     * @throws OutOfRangeException
     */
    public function getAqi(float $pm)
    {
        foreach ($this->value as $index => $value) {
            if ($pm < (float) $index) {
                $value = ($value['I_high'] - $value['I_low']) / ($value['C_high'] - $value['C_low']) * ($pm - $value['C_low']) + $value['I_low'];

                return (int) round($value);
            }
        }

        throw new OutOfRangeException();
    }
}
