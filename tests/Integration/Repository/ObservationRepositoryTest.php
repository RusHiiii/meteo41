<?php


namespace App\Tests\Integration\Repository;


use App\Core\Constant\Observation\ApiSearch;
use App\Repository\Doctrine\ObservationRepository;
use App\Tests\TestCase;
use Doctrine\ORM\Tools\Pagination\Paginator;

class ObservationRepositoryTest extends TestCase
{
    /**
     * @var ObservationRepository
     */
    private $observationRepository;

    protected function setUp()
    {
        parent::setUp();
        $this->observationRepository = self::$container->get(ObservationRepository::class);
    }

    public function testFindPaginatedObservationsWithDefaultParams()
    {
        $this->loadFile('tests/.fixtures/observation.yml');

        $obs = $this->observationRepository->findPaginatedObservation(
            [],
            ApiSearch::OBSERVATION_ORDER_BY_ASC,
            1,
            10
        );

        $this->assertInstanceOf(Paginator::class, $obs);
        $this->assertEquals(3, $obs->count());
    }

    public function testFindPaginatedContactsWithSearchBy()
    {
        $this->loadFile('tests/.fixtures/observation.yml');

        $obs = $this->observationRepository->findPaginatedObservation(
            [
                ApiSearch::OBSERVATION_SEARCH_BY_MESSAGE => 'meteo'
            ],
            ApiSearch::OBSERVATION_ORDER_BY_ASC,
            1,
            10
        );

        $this->assertInstanceOf(Paginator::class, $obs);
        $this->assertEquals(1, $obs->count());
    }
}