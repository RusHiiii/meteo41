<?php


namespace App\Tests\Integration\Factory;

use App\Core\Factory\WeatherStationFactory;
use App\Core\Tactician\Command\WeatherStation\EditWeatherStationCommand;
use App\Core\Tactician\Command\WeatherStation\RegisterWeatherStationCommand;
use App\Repository\Doctrine\WeatherStationRepository;
use App\Tests\TestCase;

class WeatherStationFactoryTest extends TestCase
{
    /**
     * @var WeatherStationFactory
     */
    private $weatherStationFactory;

    /**
     * @var WeatherStationRepository
     */
    private $weatherStationRepository;

    protected function setUp()
    {
        parent::setUp();
        $this->weatherStationFactory = self::$container->get(WeatherStationFactory::class);
        $this->weatherStationRepository = self::$container->get(WeatherStationRepository::class);
    }

    public function testCreateContactFromCommand()
    {
        $command = new RegisterWeatherStationCommand(
            'name',
            'description',
            'short',
            'FR',
            'address',
            'Blois',
            4.1562,
            4.5623,
            'XXXX',
            'HP2551',
            '250m'
        );
        $weatherStation = $this->weatherStationFactory->createWeatherStationFromCommand($command);

        $this->assertEquals('name', $weatherStation->getName());
        $this->assertEquals('description', $weatherStation->getDescription());
        $this->assertEquals('short', $weatherStation->getShortDescription());
        $this->assertEquals('FR', $weatherStation->getCountry());
        $this->assertEquals('address', $weatherStation->getAddress());
        $this->assertEquals('Blois', $weatherStation->getCity());
        $this->assertEquals(4.1562, $weatherStation->getLat());
        $this->assertEquals(4.5623, $weatherStation->getLng());
        $this->assertEquals('XXXX', $weatherStation->getApiToken());
        $this->assertEquals('HP2551', $weatherStation->getModel());
        $this->assertEquals('250m', $weatherStation->getElevation());
    }

    public function testEditWeatherStationFromCommand()
    {
        $entities = $this->loadFile('tests/.fixtures/weatherStation.yml');

        $command = new EditWeatherStationCommand(
            'name',
            'description',
            'short',
            'FR',
            'address',
            'Blois',
            4.1562,
            4.5623,
            'XXXX',
            'HP2551',
            '250m'
        );

        $weatherStation = $this->weatherStationFactory->editWeatherStationFromCommand($entities['weather_station_1'], $command);

        $this->assertEquals('name', $weatherStation->getName());
        $this->assertEquals('description', $weatherStation->getDescription());
        $this->assertEquals('short', $weatherStation->getShortDescription());
        $this->assertEquals('FR', $weatherStation->getCountry());
        $this->assertEquals('address', $weatherStation->getAddress());
        $this->assertEquals('Blois', $weatherStation->getCity());
        $this->assertEquals(4.1562, $weatherStation->getLat());
        $this->assertEquals(4.5623, $weatherStation->getLng());
        $this->assertEquals('XXXX', $weatherStation->getApiToken());
        $this->assertEquals('HP2551', $weatherStation->getModel());
        $this->assertEquals('250m', $weatherStation->getElevation());
    }
}