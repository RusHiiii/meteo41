<?php


namespace App\Tests\Integration\Transformer;


use App\Core\Transformer\UnitTransformer;
use App\Entity\Core\ViewModels\Unit\UnitSearchView;
use App\Entity\Core\ViewModels\Unit\UnitView;
use App\Repository\Doctrine\UnitRepository;
use App\Tests\TestCase;

class UnitTransformerTest extends TestCase
{
    /**
     * @var UnitRepository
     */
    private $unitRepository;

    /**
     * @var UnitTransformer
     */
    private $unitTransformer;

    protected function setUp()
    {
        parent::setUp();
        $this->unitTransformer = self::$container->get(UnitTransformer::class);
        $this->unitRepository = self::$container->get(UnitRepository::class);
    }

    public function testTransformToView()
    {
        $entities = $this->loadFile('tests/.fixtures/unit.yml');

        $unitView = $this->unitTransformer->transformUnitToView($entities['unit_1']);

        $this->assertInstanceOf(UnitView::class, $unitView);

        $this->assertEquals('°C', $unitView->getTemperatureUnit());
        $this->assertEquals('m/s', $unitView->getSpeedUnit());
        $this->assertEquals('mm', $unitView->getRainUnit());
        $this->assertEquals('lux', $unitView->getSolarRadiationUnit());
        $this->assertEquals('um/m', $unitView->getPmUnit());
        $this->assertEquals('%', $unitView->getHumidityUnit());
        $this->assertEquals('metric', $unitView->getType());
        $this->assertEquals('m', $unitView->getCloudBaseUnit());
        $this->assertEquals('°', $unitView->getWindDirUnit());
    }

    public function testTransformToSearchView()
    {
        $this->loadFile('tests/.fixtures/unit.yml');

        $units = $this->unitRepository->findAll();

        $unitSearchView = $this->unitTransformer->transformUnitToSearchView($units);

        $this->assertInstanceOf(UnitSearchView::class, $unitSearchView);
        $this->assertEquals(1, $unitSearchView->getNumberOfResult());
        $this->assertIsArray($unitSearchView->getUnits());
    }
}