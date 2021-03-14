<?php


namespace App\Tests\Integration\Transformer;

use App\Core\Constant\WeatherStation\ApiSearch;
use App\Core\Transformer\WeatherStationTransformer;
use App\Entity\Core\ViewModels\WeatherStation\WeatherStationSearchView;
use App\Entity\Core\ViewModels\WeatherStation\WeatherStationView;
use App\Repository\Doctrine\WeatherStationRepository;
use App\Tests\TestCase;

class WeatherStationTransformerTest extends TestCase
{
    /**
     * @var WeatherStationRepository
     */
    private $weatherStationRepository;

    /**
     * @var WeatherStationTransformer
     */
    private $weatherStationTransformer;

    protected function setUp()
    {
        parent::setUp();
        $this->weatherStationRepository = self::$container->get(WeatherStationRepository::class);
        $this->weatherStationTransformer = self::$container->get(WeatherStationTransformer::class);
    }

    public function testTransformToView()
    {
        $entities = $this->loadFile('tests/.fixtures/weatherStation.yml');

        $weatherStationView = $this->weatherStationTransformer->transformWeatherStationToView($entities['weather_station_1']);

        $this->assertInstanceOf(WeatherStationView::class, $weatherStationView);

        $this->assertEquals('Station de Blois', $weatherStationView->getName());
        $this->assertEquals('ma longue description', $weatherStationView->getDescription());
        $this->assertEquals('courte descrition', $weatherStationView->getShortDescription());
        $this->assertEquals('FR', $weatherStationView->getCountry());
        $this->assertEquals('46 rue des moulins', $weatherStationView->getAddress());
        $this->assertEquals('Blois', $weatherStationView->getCity());
        $this->assertEquals(4.5956, $weatherStationView->getLat());
        $this->assertEquals(4.2356, $weatherStationView->getLng());
        $this->assertEquals('HP 2551', $weatherStationView->getModel());
        $this->assertEquals('200m', $weatherStationView->getElevation());
        $this->assertEquals('AAA', $weatherStationView->getReference());
    }

    public function testTransformToSearchView()
    {
        $entities = $this->loadFile('tests/.fixtures/weatherStation.yml');

        $weatherStations = $this->weatherStationRepository->findPaginatedWeatherStations(
            [],
            ApiSearch::WEATHER_STATION_ORDER_BY_ASC,
            1,
            10
        );

        $weatherStationSearchView = $this->weatherStationTransformer->transformWeatherStationToSearchView($weatherStations);

        $this->assertInstanceOf(WeatherStationSearchView::class, $weatherStationSearchView);
        $this->assertEquals(2, $weatherStationSearchView->getNumberOfResult());
    }
}