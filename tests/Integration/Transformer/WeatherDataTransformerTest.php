<?php


namespace App\Tests\Integration\Transformer;

use App\Core\Transformer\WeatherDataTransformer;
use App\Entity\Core\ViewModels\Unit\UnitView;
use App\Entity\Core\ViewModels\WeatherData\WeatherDataSummaryView;
use App\Entity\Core\ViewModels\WeatherStation\WeatherStationView;
use App\Repository\Doctrine\WeatherDataRepository;
use App\Tests\TestCase;

class WeatherDataTransformerTest extends TestCase
{
    /**
     * @var WeatherDataRepository
     */
    private $weatherDataRepository;

    /**
     * @var WeatherDataTransformer
     */
    private $weatherDataTransformer;

    protected function setUp()
    {
        parent::setUp();
        $this->weatherDataRepository = self::$container->get(WeatherDataRepository::class);
        $this->weatherDataTransformer = self::$container->get(WeatherDataTransformer::class);
    }

    public function testTransformToView()
    {
        $entities = $this->loadFile('tests/.fixtures/weatherData.yml');

        $weatherDataView = $this->weatherDataTransformer->transformWeatherDataToSummary($entities['weather_data_1']);

        $this->assertInstanceOf(WeatherDataSummaryView::class, $weatherDataView);

        $this->assertInstanceOf(WeatherStationView::class, $weatherDataView->getWeatherStation());
        $this->assertInstanceOf(UnitView::class, $weatherDataView->getUnit());
        $this->assertEquals(8.6, $weatherDataView->getTemperature());
        $this->assertEquals(55, $weatherDataView->getHumidity());
        $this->assertEquals(1025.6, $weatherDataView->getRelativePressure());
        $this->assertEquals(9.7, $weatherDataView->getWindSpeedAvg());
    }
}