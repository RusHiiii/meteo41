<?php


namespace App\Tests\Integration\Factory;

use App\Core\Factory\ContactFactory;
use App\Core\Factory\ObservationFactory;
use App\Core\Tactician\Command\Contact\EditContactCommand;
use App\Core\Tactician\Command\Contact\RegisterContactCommand;
use App\Core\Tactician\Command\Observation\EditObservationCommand;
use App\Core\Tactician\Command\Observation\RegisterObservationCommand;
use App\Entity\WebApp\User;
use App\Entity\WebApp\WeatherStation;
use App\Repository\Doctrine\ContactRepository;
use App\Repository\Doctrine\ObservationRepository;
use App\Tests\TestCase;

class ObservationFactoryTest extends TestCase
{
    /**
     * @var ObservationRepository
     */
    private $observationRepository;

    /**
     * @var ObservationFactory
     */
    private $observationFactory;

    protected function setUp()
    {
        parent::setUp();
        $this->observationRepository = self::$container->get(ObservationRepository::class);
        $this->observationFactory = self::$container->get(ObservationFactory::class);
    }

    public function testCreateObservationFromCommand()
    {
        $entities = $this->loadFile('tests/.fixtures/observation.yml');

        $command = new RegisterObservationCommand('mesage', 1);
        $observation = $this->observationFactory->createObservationFromCommand($command, $entities['user_1'], $entities['weather_station_1']);

        $this->assertEquals('mesage', $observation->getMessage());
        $this->assertInstanceOf(WeatherStation::class, $observation->getWeatherStation());
        $this->assertInstanceOf(User::class, $observation->getUser());
    }

    public function testEditObservationFromCommand()
    {
        $entities = $this->loadFile('tests/.fixtures/observation.yml');

        $command = new EditObservationCommand('mesage', 1, 10);
        $observation = $this->observationFactory->editObservationFromCommand($entities['obs_1'], $command, $entities['weather_station_1']);

        $this->assertEquals('mesage', $observation->getMessage());
        $this->assertInstanceOf(WeatherStation::class, $observation->getWeatherStation());
        $this->assertInstanceOf(User::class, $observation->getUser());
    }
}