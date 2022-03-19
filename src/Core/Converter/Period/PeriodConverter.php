<?php

namespace App\Core\Converter\Period;

use App\Core\Constant\WeatherData\Period;

class PeriodConverter
{
    /**
     * @param string $period
     * @return array
     */
    public function convertPeriodToDate(string $period)
    {
        $startDate = $endDate = date('Y-m-d H:i:s', strtotime('now'));

        if ($period === Period::DAILY) {
            $startDate = date('Y-m-d 00:00:00', strtotime('now'));
        }

        if ($period === Period::MONTHLY) {
            $startDate = date('Y-m-01 00:00:00', strtotime('now'));
        }

        if ($period === Period::WEEKLY) {
            $startDate = date('Y-m-d 00:00:00', strtotime('this week'));
        }

        if ($period === Period::YEARLY) {
            $startDate = date('Y-01-01 00:00:00', strtotime('now'));
        }

        if ($period === Period::RECORD) {
            $startDate = date('1970-01-01 00:00:00', strtotime('now'));
        }

        return [$endDate, $startDate];
    }
}
