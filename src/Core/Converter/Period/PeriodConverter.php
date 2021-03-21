<?php


namespace App\Core\Converter\Period;


use App\Core\Constant\WeatherData\Period;

class PeriodConverter
{
    /**
     * @param string $period
     * @param string $timestamp
     * @return array
     * @throws \Exception
     */
    public function convertPeriodToDate(string $period, string $timestamp)
    {
        $startDate = $endDate = new \DateTime(strtotime($timestamp));

        if ($period === Period::DAILY) {
            $startDate = $startDate->format('Y-m-d 00:00:00');
        }

        if ($period === Period::MONTHLY) {
            $startDate = $startDate->format('Y-m-01 00:00:00');
        }

        if ($period === Period::WEEKLY) {
            $startDate = $startDate
                ->modify('monday this week')
                ->format('Y-m-d 00:00:00');
        }

        if ($period === Period::YEARLY) {
            $startDate = $startDate->format('Y-01-01 00:00:00');
        }

        return [$endDate->format('Y-m-d H:i:s'), $startDate];
    }
}