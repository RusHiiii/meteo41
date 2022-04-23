<?php


namespace App\Tests\Integration\Factory;

use App\Core\Factory\WeatherDataFactory;
use App\Core\Tactician\Command\WeatherData\RegisterWeatherDataCommand;
use App\Tests\TestCase;

class WeatherDataFactoryTest extends TestCase
{
    /**
     * @var WeatherDataFactory
     */
    private $weatherDataFactory;

    protected function setUp()
    {
        parent::setUp();
        $this->weatherDataFactory = self::$container->get(WeatherDataFactory::class);
    }

    public function testCreateDataFromCommand()
    {
        $entities = $this->loadFile('tests/.fixtures/weatherStation.yml');

        $command = new RegisterWeatherDataCommand(
            'test',
            '2020-07-17 20:05:30',
            '50',
            '50',
            '30.20',
            '30.20',
            '56',
            '65',
            '311',
            '322',
            '20',
            '21',
            '32',
            '12',
            '0',
            '0',
            '0',
            '0',
            '0',
            '1',
            '23',
            '211',
            '2',
            '6',
            '6',
            '0',
            '0',
            '0',
            '868',
            'model'
        );
        $weatherData = $this->weatherDataFactory->createWeatherDataFromCommand($command, 23, 23, 1020.3, 1003.3, 12, 13, 45, 12, 0, 0, 0, 0, 0, 0, 123, 24, 12, 23, 960, 1, 12, 23, 20, 20, $entities['unit_1'], $entities['weather_station_1']);

        $this->assertEquals(23, $weatherData->getTemperature());
        $this->assertEquals(23, $weatherData->getHeatIndex());
        $this->assertEquals(1020.3, $weatherData->getRelativePressure());
        $this->assertEquals(1003.3, $weatherData->getAbsolutePressure());
        $this->assertEquals(12, $weatherData->getWindSpeed());
        $this->assertEquals(13, $weatherData->getWindSpeedAvg());
        $this->assertEquals(45, $weatherData->getWindGust());
        $this->assertEquals(12, $weatherData->getWindMaxDailyGust());
        $this->assertEquals(0, $weatherData->getRainRate());
        $this->assertEquals(0, $weatherData->getRainEvent());
        $this->assertEquals(0, $weatherData->getRainHourly());
        $this->assertEquals(0, $weatherData->getRainDaily());
        $this->assertEquals(0, $weatherData->getRainWeekly());
        $this->assertEquals(0, $weatherData->getRainMonthly());
        $this->assertEquals(123, $weatherData->getRainYearly());
        $this->assertEquals(24, $weatherData->getHumidex());
        $this->assertEquals(12, $weatherData->getDewPoint());
        $this->assertEquals(23, $weatherData->getWindChill());
        $this->assertEquals(960, $weatherData->getCloudBase());
        $this->assertEquals(1, $weatherData->getBeaufortScale());
        $this->assertEquals(12, $weatherData->getAqi());
        $this->assertEquals(23, $weatherData->getAqiAvg());
    }
}