<?php


namespace App\Tests\Integration\Repository;


use App\Core\Constant\WeatherStation\ApiSearch;
use App\Repository\Doctrine\WeatherStationRepository;
use App\Tests\TestCase;
use Doctrine\ORM\Tools\Pagination\Paginator;

class WeatherStationRepositoryTest extends TestCase
{
    /**
     * @var WeatherStationRepository
     */
    private $weatherStationRepository;

    protected function setUp()
    {
        parent::setUp();
        $this->weatherStationRepository = self::$container->get(WeatherStationRepository::class);
    }

    public function testFindPaginatedWeatherStationsWithDefaultParams()
    {
        $this->loadFile('tests/.fixtures/weatherStation.yml');

        $weatherStations = $this->weatherStationRepository->findPaginatedWeatherStations(
            [],
            ApiSearch::WEATHER_STATION_ORDER_BY_ASC,
            1,
            10
        );

        $this->assertInstanceOf(Paginator::class, $weatherStations);
        $this->assertEquals(2, $weatherStations->count());
    }

    public function testFindPaginatedContactsWithSearchBy()
    {
        $this->loadFile('tests/.fixtures/weatherStation.yml');

        $weatherStations = $this->weatherStationRepository->findPaginatedWeatherStations(
            [
                ApiSearch::WEATHER_STATION_SEARCH_BY_NAME => 'Blois',
                ApiSearch::WEATHER_STATION_SEARCH_BY_COUNTRY => 'FR'
            ],
            ApiSearch::WEATHER_STATION_ORDER_BY_ASC,
            1,
            10
        );

        $this->assertInstanceOf(Paginator::class, $weatherStations);
        $this->assertEquals(2, $weatherStations->count());
    }
}