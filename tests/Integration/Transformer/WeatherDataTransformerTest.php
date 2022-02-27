<?php


namespace App\Tests\Integration\Transformer;

use App\Core\Constant\WeatherData\Period;
use App\Core\Converter\Period\PeriodConverter;
use App\Core\Transformer\WeatherDataTransformer;
use App\Entity\Core\ViewModels\Unit\UnitView;
use App\Entity\Core\ViewModels\WeatherData\WeatherDataDetailView;
use App\Entity\Core\ViewModels\WeatherData\WeatherDataGraphSearchView;
use App\Entity\Core\ViewModels\WeatherData\WeatherDataPeriodView;
use App\Entity\Core\ViewModels\WeatherData\WeatherDataSummaryView;
use App\Entity\Core\ViewModels\WeatherStation\WeatherStationView;
use App\Repository\Doctrine\WeatherDataRepository;
use App\Repository\Doctrine\WeatherStationRepository;
use App\Tests\TestCase;

class WeatherDataTransformerTest extends TestCase
{
    /**
     * @var WeatherDataRepository
     */
    private $weatherDataRepository;

    /**
     * @var WeatherStationRepository
     */
    private $weatherStationRepository;

    /**
     * @var WeatherDataTransformer
     */
    private $weatherDataTransformer;

    protected function setUp()
    {
        parent::setUp();
        $this->weatherDataRepository = self::$container->get(WeatherDataRepository::class);
        $this->weatherStationRepository = self::$container->get(WeatherStationRepository::class);
        $this->weatherDataTransformer = self::$container->get(WeatherDataTransformer::class);
    }

    public function testTransformToSummaryView()
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

    public function testTransformToDetailView()
    {
        $entities = $this->loadFile('tests/.fixtures/weatherData.yml');

        $weatherDataView = $this->weatherDataTransformer->transformWeatherDataToDetail($entities['weather_data_1'], null);

        $this->assertInstanceOf(WeatherDataDetailView::class, $weatherDataView);

        $this->assertInstanceOf(WeatherStationView::class, $weatherDataView->getWeatherStation());
        $this->assertInstanceOf(UnitView::class, $weatherDataView->getUnit());
        $this->assertEquals(8.6, $weatherDataView->getTemperature());
        $this->assertEquals(55, $weatherDataView->getHumidity());
        $this->assertEquals(1025.6, $weatherDataView->getRelativePressure());
        $this->assertEquals(9.7, $weatherDataView->getWindSpeedAvg());
    }

    public function testTransformToPeriodView()
    {
        $entities = $this->loadFile('tests/.fixtures/weatherData.yml');

        $endDate = date('Y-m-d H:i:s', strtotime('now'));
        $startDate = date('Y-01-01 00:00:00', strtotime('now'));

        $data = $this->weatherDataRepository->findWeatherDataHistory($startDate, $endDate, Period::YEARLY, 'AAA');
        $weatherStation = $this->weatherStationRepository->find(1);

        $weatherDataView = $this->weatherDataTransformer->transformWeatherDataToPeriod($data, $weatherStation);

        $this->assertInstanceOf(WeatherDataPeriodView::class, $weatherDataView);

        $this->assertInstanceOf(WeatherStationView::class, $weatherDataView->getWeatherStation());
        $this->assertInstanceOf(UnitView::class, $weatherDataView->getUnit());
        $this->assertEquals(8.7, $weatherDataView->getMaxTemperature());
        $this->assertEquals(56, $weatherDataView->getMaxHumidity());
        $this->assertEquals(1025.6, $weatherDataView->getMinRelativePressure());
        $this->assertEquals(22.0, $weatherDataView->getMaxWindGust());
    }

    public function testTransformToGraphViewYearly()
    {
        $entities = $this->loadFile('tests/.fixtures/weatherData.yml');

        $endDate = date('Y-m-d H:i:s', strtotime('now'));
        $startDate = date('Y-01-01 00:00:00', strtotime('now'));

        $data = $this->weatherDataRepository->findWeatherDataGraph($startDate, $endDate, Period::YEARLY, 'AAA');
        $weatherStation = $this->weatherStationRepository->find(1);

        $weatherDataView = $this->weatherDataTransformer->transformWeatherDataGraphSearchView($weatherStation, $data, new \DateTime($startDate), new \DateTime($endDate));

        $this->assertInstanceOf(WeatherDataGraphSearchView::class, $weatherDataView);

        $this->assertInstanceOf(WeatherStationView::class, $weatherDataView->getWeatherStation());
        $this->assertInstanceOf(UnitView::class, $weatherDataView->getUnit());
        $this->assertEquals(0, $weatherDataView->getNumberOfResult());
        $this->assertIsArray($weatherDataView->getDatas());
    }

    public function testTransformToGraphViewDaily()
    {
        $entities = $this->loadFile('tests/.fixtures/weatherData.yml');

        $endDate = date('Y-m-d H:i:s', strtotime('now'));
        $startDate = date('Y-01-01 00:00:00', strtotime('now'));

        $data = $this->weatherDataRepository->findWeatherDataGraph($startDate, $endDate, Period::DAILY, 'AAA');
        $weatherStation = $this->weatherStationRepository->find(1);

        $weatherDataView = $this->weatherDataTransformer->transformWeatherDataGraphSearchView($weatherStation, $data, new \DateTime($startDate), new \DateTime($endDate));

        $this->assertInstanceOf(WeatherDataGraphSearchView::class, $weatherDataView);

        $this->assertInstanceOf(WeatherStationView::class, $weatherDataView->getWeatherStation());
        $this->assertInstanceOf(UnitView::class, $weatherDataView->getUnit());
        $this->assertEquals(2, $weatherDataView->getNumberOfResult());
        $this->assertIsArray($weatherDataView->getDatas());
    }
}