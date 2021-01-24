<?php


namespace App\Tests\Integration\Repository;


use App\Core\Constant\User\ApiSearch;
use App\Repository\UserRepository;
use App\Tests\TestCase;
use Doctrine\ORM\Tools\Pagination\Paginator;

class UserRepositoryTest extends TestCase
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    protected function setUp()
    {
        parent::setUp();
        $this->userRepository = self::$container->get(UserRepository::class);
    }

    public function testFindPaginatedUsersWithDefaultParams()
    {
        $this->loadFile('tests/.fixtures/user.yml');

        $contacts = $this->userRepository->findPaginatedUsers(
            [],
            ApiSearch::USER_ORDER_BY_DESC,
            1,
            10
        );

        $this->assertInstanceOf(Paginator::class, $contacts);
        $this->assertEquals(2, $contacts->count());
    }

    public function testFindPaginatedUsersWithSearchBy()
    {
        $this->loadFile('tests/.fixtures/user.yml');

        $contacts = $this->userRepository->findPaginatedUsers(
            [
                ApiSearch::USER_SEARCH_BY_EMAIL => "damiens"
            ],
            ApiSearch::USER_ORDER_BY_DESC,
            1,
            10
        );

        $this->assertInstanceOf(Paginator::class, $contacts);
        $this->assertEquals(1, $contacts->count());
    }
}