<?php


namespace App\Tests\Integration\Transformer;

use App\Core\Constant\Contact\ApiSearch;
use App\Core\Transformer\ContactTransformer;
use App\Core\Transformer\ObservationTransformer;
use App\Entity\Core\ViewModels\Contact\ContactSearchView;
use App\Entity\Core\ViewModels\Contact\ContactView;
use App\Entity\Core\ViewModels\Observation\ObservationSearchView;
use App\Entity\Core\ViewModels\Observation\ObservationView;
use App\Repository\Doctrine\ContactRepository;
use App\Repository\Doctrine\ObservationRepository;
use App\Tests\TestCase;

class ObservationTransformerTest extends TestCase
{
    /**
     * @var ObservationRepository
     */
    private $observationRepository;

    /**
     * @var ObservationTransformer
     */
    private $observationTransformer;

    protected function setUp()
    {
        parent::setUp();
        $this->observationRepository = self::$container->get(ObservationRepository::class);
        $this->observationTransformer = self::$container->get(ObservationTransformer::class);
    }

    public function testTransformToView()
    {
        $entities = $this->loadFile('tests/.fixtures/observation.yml');

        $observationView = $this->observationTransformer->transformObservationToView($entities['obs_1']);

        $this->assertInstanceOf(ObservationView::class, $observationView);
        $this->assertEquals('test de message', $observationView->getMessage());
    }

    public function testTransformToSearchView()
    {
        $entities = $this->loadFile('tests/.fixtures/observation.yml');

        $observations = $this->observationRepository->findPaginatedObservation(
            [],
            ApiSearch::CONTACT_ORDER_BY_ASC,
            1,
            10
        );

        $observationView = $this->observationTransformer->transformObservationToSearchView($observations);

        $this->assertInstanceOf(ObservationSearchView::class, $observationView);
        $this->assertEquals(3, $observationView->getNumberOfResult());
        $this->assertIsArray($observationView->getObservations());
    }
}