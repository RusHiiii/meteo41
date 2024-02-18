<?php

namespace App\Core\Converter\Period;

use App\Core\Constant\WeatherData\Period;

class PeriodConverter
{
    /**
     * @param string $period
     * @return array
     */
    public static function convertPeriodToDate(string $period)
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

    /**
     * @param string $period
     * @return int
     */
    public static function convertPeriodToTtl(string $period)
    {
        // 30mn cache duration
        $ttl = 1800;

        // 2h cache duration
        if ($period === Period::WEEKLY) {
            return 7200;
        }

        // 4h cache duration
        if ($period === Period::MONTHLY) {
            return 14400;
        }

        // 6h cache duration
        if ($period === Period::YEARLY) {
            return 21600;
        }

        // 8h cache duration
        if ($period === Period::RECORD) {
            return 28800;
        }

        return $ttl;
    }

    /**
     * @param string $period
     * @return int
     */
    public static function convertPeriodToMod(string $period)
    {
        // every 2mn
        $mod = 2;

        // every 10mn
        if ($period === Period::WEEKLY) {
            return 10;
        }

        // every 30mn
        if ($period === Period::MONTHLY) {
            return 30;
        }

        // every 120mn
        if ($period === Period::YEARLY) {
            return 120;
        }

        return $mod;
    }
}
