<?php


namespace App\Tests\Integration\Repository\Contact;


use App\Core\Constant\Contact\ApiSearch;
use App\Repository\Doctrine\ContactRepository;
use App\Tests\TestCase;
use Doctrine\ORM\Tools\Pagination\Paginator;

class ContactRepositoryTest extends TestCase
{
    /**
     * @var ContactRepository
     */
    private $contactRepository;

    protected function setUp()
    {
        parent::setUp();
        $this->contactRepository = self::$container->get(ContactRepository::class);
    }

    public function testFindPaginatedContactsWithDefaultParams()
    {
        $this->loadFile('tests/.fixtures/contact.yml');

        $contacts = $this->contactRepository->findPaginatedContacts(
            [],
            ApiSearch::CONTACT_ORDER_BY_ASC,
            1,
            10
        );

        $this->assertInstanceOf(Paginator::class, $contacts);
        $this->assertEquals(3, $contacts->count());
    }

    public function testFindPaginatedContactsWithSearchBy()
    {
        $this->loadFile('tests/.fixtures/contact.yml');

        $contacts = $this->contactRepository->findPaginatedContacts(
            [
                'email' => 'orange.fr'
            ],
            ApiSearch::CONTACT_ORDER_BY_ASC,
            1,
            10
        );

        $this->assertInstanceOf(Paginator::class, $contacts);
        $this->assertEquals(3, $contacts->count());
    }
}