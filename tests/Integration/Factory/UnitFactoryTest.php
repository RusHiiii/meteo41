<?php


namespace App\Tests\Integration\Factory;

use App\Core\Factory\UnitFactory;
use App\Core\Tactician\Command\Unit\EditUnitCommand;
use App\Core\Tactician\Command\Unit\RegisterUnitCommand;
use App\Tests\TestCase;

class UnitFactoryTest extends TestCase
{
    /**
     * @var UnitFactory
     */
    private $unitFactory;

    protected function setUp()
    {
        parent::setUp();
        $this->unitFactory = self::$container->get(UnitFactory::class);
    }

    public function testCreateUnitFromCommand()
    {
        $command = new RegisterUnitCommand('°C', 'km/h', 'mm', 'w/m2', 'unit', '%', 'metric');
        $unit = $this->unitFactory->createUnitFromCommand($command);

        $this->assertEquals('°C', $unit->getTemperatureUnit());
        $this->assertEquals('km/h', $unit->getSpeedUnit());
        $this->assertEquals('mm', $unit->getRainUnit());
        $this->assertEquals('w/m2', $unit->getSolarRadiationUnit());
        $this->assertEquals('unit', $unit->getPmUnit());
        $this->assertEquals('%', $unit->getHumidityUnit());
        $this->assertEquals('metric', $unit->getType());
    }

    public function testEditUnitFromCommand()
    {
        $entities = $this->loadFile('tests/.fixtures/unit.yml');

        $command = new EditUnitCommand('°C', 'km/h', 'mm', 'w/m2', 'unit', '%', 'metric');
        $unit = $this->unitFactory->editUnitFromCommand($entities['unit_1'], $command);

        $this->assertEquals('°C', $unit->getTemperatureUnit());
        $this->assertEquals('km/h', $unit->getSpeedUnit());
        $this->assertEquals('mm', $unit->getRainUnit());
        $this->assertEquals('w/m2', $unit->getSolarRadiationUnit());
        $this->assertEquals('unit', $unit->getPmUnit());
        $this->assertEquals('%', $unit->getHumidityUnit());
        $this->assertEquals('metric', $unit->getType());
    }
}