<?php

namespace App\Core\Tactician\Command\WeatherData;

class RegisterWeatherDataCommand
{
    private int $weatherStationId;

    private string $stationtype;

    private string $dateutc;

    private string $tempinf;

    private string $humidityin;

    private string $baromrelin;

    private string $baromabsin;

    private string $tempf;

    private string $humidity;

    private string $winddir;

    private string $winddir_avg10m;

    private string $windspeedmph;

    private string $windspdmph_avg10m;

    private string $windgustmph;

    private string $maxdailygust;

    private string $rainratein;

    private string $eventrainin;

    private string $hourlyrainin;

    private string $dailyrainin;

    private string $weeklyrainin;

    private string $monthlyrainin;

    private string $yearlyrainin;

    private string $solarradiation;

    private string $uv;

    private string $pm25_ch1;

    private string $pm25_avg_24h_ch1;

    private string $wh65batt;

    private string $wh25batt;

    private string $pm25batt1;

    private ?string $leafwetness_ch1;

    private ?string $tf_ch1;

    private ?string $leaf_batt1;

    private ?string $tf_batt1;

    private string $freq;

    private string $model;

    /**
     * RegisterWeatherDataCommand constructor.
     * @param string $stationtype
     * @param string $dateutc
     * @param string $tempinf
     * @param string $humidityin
     * @param string $baromrelin
     * @param string $baromabsin
     * @param string $tempf
     * @param string $humidity
     * @param string $winddir
     * @param string $winddir_avg10m
     * @param string $windspeedmph
     * @param string $windspdmph_avg10m
     * @param string $windgustmph
     * @param string $maxdailygust
     * @param string $rainratein
     * @param string $eventrainin
     * @param string $hourlyrainin
     * @param string $dailyrainin
     * @param string $weeklyrainin
     * @param string $monthlyrainin
     * @param string $yearlyrainin
     * @param string $solarradiation
     * @param string $uv
     * @param string $pm25_ch1
     * @param string $pm25_avg_24h_ch1
     * @param string $wh65batt
     * @param string $wh25batt
     * @param string $pm25batt1
     * @param string $freq
     * @param string $model
     * @param string|null $leafwetness_ch1
     * @param string|null $tf_ch1
     * @param string|null $leaf_batt1
     * @param string|null $tf_batt1
     */
    public function __construct(
        string $stationtype,
        string $dateutc,
        string $tempinf,
        string $humidityin,
        string $baromrelin,
        string $baromabsin,
        string $tempf,
        string $humidity,
        string $winddir,
        string $winddir_avg10m,
        string $windspeedmph,
        string $windspdmph_avg10m,
        string $windgustmph,
        string $maxdailygust,
        string $rainratein,
        string $eventrainin,
        string $hourlyrainin,
        string $dailyrainin,
        string $weeklyrainin,
        string $monthlyrainin,
        string $yearlyrainin,
        string $solarradiation,
        string $uv,
        string $pm25_ch1,
        string $pm25_avg_24h_ch1,
        string $wh65batt,
        string $wh25batt,
        string $pm25batt1,
        string $freq,
        string $model,
        ?string $leafwetness_ch1 = null,
        ?string $tf_ch1 = null,
        ?string $leaf_batt1 = null,
        ?string $tf_batt1 = null
    ) {
        $this->stationtype = $stationtype;
        $this->dateutc = $dateutc;
        $this->tempinf = $tempinf;
        $this->humidityin = $humidityin;
        $this->baromrelin = $baromrelin;
        $this->baromabsin = $baromabsin;
        $this->tempf = $tempf;
        $this->humidity = $humidity;
        $this->winddir = $winddir;
        $this->winddir_avg10m = $winddir_avg10m;
        $this->windspeedmph = $windspeedmph;
        $this->windspdmph_avg10m = $windspdmph_avg10m;
        $this->windgustmph = $windgustmph;
        $this->maxdailygust = $maxdailygust;
        $this->rainratein = $rainratein;
        $this->eventrainin = $eventrainin;
        $this->hourlyrainin = $hourlyrainin;
        $this->dailyrainin = $dailyrainin;
        $this->weeklyrainin = $weeklyrainin;
        $this->monthlyrainin = $monthlyrainin;
        $this->yearlyrainin = $yearlyrainin;
        $this->solarradiation = $solarradiation;
        $this->uv = $uv;
        $this->pm25_ch1 = $pm25_ch1;
        $this->pm25_avg_24h_ch1 = $pm25_avg_24h_ch1;
        $this->wh65batt = $wh65batt;
        $this->wh25batt = $wh25batt;
        $this->pm25batt1 = $pm25batt1;
        $this->freq = $freq;
        $this->model = $model;
        $this->leafwetness_ch1 = $leafwetness_ch1;
        $this->leaf_batt1 = $leaf_batt1;
        $this->tf_ch1 = $tf_ch1;
        $this->tf_batt1 = $tf_batt1;
    }


    /**
     * @return int
     */
    public function getWeatherStationId(): int
    {
        return $this->weatherStationId;
    }

    /**
     * @param int $weatherStationId
     */
    public function setWeatherStationId(int $weatherStationId): void
    {
        $this->weatherStationId = $weatherStationId;
    }

    public function getModel()
    {
        return (string) $this->model;
    }


    public function getHumidity()
    {
        return (int) $this->humidity;
    }

    public function getUv()
    {
        return (int) $this->uv;
    }

    public function getStationType()
    {
        return (string) $this->stationtype;
    }

    public function getDate()
    {
        $date = \DateTime::createFromFormat('Y-m-d H:i:s', $this->dateutc, new \DateTimeZone('UTC'));
        $date->setTimezone(new \DateTimeZone('Europe/Paris'));

        return $date;
    }

    public function getIndoorTemperatureF()
    {
        return (float) $this->tempinf;
    }

    public function getSoilTemperatureF()
    {
        return (float) $this->tf_ch1;
    }

    public function getIndoorHumidity()
    {
        return (int) $this->humidityin;
    }

    public function getLeafWetness()
    {
        return (int) $this->leafwetness_ch1;
    }

    public function getRelativePressureInhg()
    {
        return (float) $this->baromrelin;
    }

    public function getAbsolutePressureInhg()
    {
        return (float) $this->baromabsin;
    }

    public function getOutdoorTemperatureF()
    {
        return (float) $this->tempf;
    }

    public function getWindDirection()
    {
        return (int) $this->winddir;
    }

    public function getAverageWindDirection10m()
    {
        return (int) $this->winddir_avg10m;
    }

    public function getWindSpeedMph()
    {
        return (float) $this->windspeedmph;
    }

    public function getAverageWindSpeedMph10m()
    {
        return (float) $this->windspdmph_avg10m;
    }

    public function getWindGustMph()
    {
        return (float) $this->windgustmph;
    }

    public function getMaxDailyGustMph()
    {
        return (float) $this->maxdailygust;
    }

    public function getRainRateInch()
    {
        return (float) $this->rainratein;
    }

    public function getEventRainInch()
    {
        return (float) $this->eventrainin;
    }

    public function getHourlyRainInch()
    {
        return (float) $this->hourlyrainin;
    }

    public function getDailyRainInch()
    {
        return (float) $this->dailyrainin;
    }

    public function getWeeklyRainInch()
    {
        return (float) $this->weeklyrainin;
    }

    public function getMonthlyRainInch()
    {
        return (float) $this->monthlyrainin;
    }

    public function getYearlyRainInch()
    {
        return (float) $this->yearlyrainin;
    }

    public function getSolarRadiation()
    {
        return (float) $this->solarradiation;
    }

    public function getPm25()
    {
        return (float) $this->pm25_ch1;
    }

    public function getAveragePm25Days()
    {
        return (float) $this->pm25_avg_24h_ch1;
    }

    public function getWh65Battery()
    {
        return (int) $this->wh65batt;
    }

    public function getWh25battery()
    {
        return (int) $this->wh25batt;
    }

    public function getPm25battery()
    {
        return (int) $this->pm25batt1;
    }

    public function getFrequency()
    {
        return (string) $this->freq;
    }
}
