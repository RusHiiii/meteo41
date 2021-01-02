<?php


namespace App\Tests\Integration\Transformer;

use App\Core\Constant\Contact\ApiSearch;
use App\Core\Transformer\ContactTransformer;
use App\Entity\Core\ViewModels\Contact\ContactSearchView;
use App\Entity\Core\ViewModels\Contact\ContactView;
use App\Repository\Doctrine\ContactRepository;
use App\Tests\TestCase;

class ContactTransformerTest extends TestCase
{
    /**
     * @var ContactRepository
     */
    private $contactRepository;

    /**
     * @var ContactTransformer
     */
    private $contactTransformer;

    protected function setUp()
    {
        parent::setUp();
        $this->contactRepository = self::$container->get(ContactRepository::class);
        $this->contactTransformer = self::$container->get(ContactTransformer::class);
    }

    public function testTransformToView()
    {
        $entities = $this->loadFile('tests/.fixtures/contact.yml');

        $contactView = $this->contactTransformer->transformContactToView($entities['contact_1']);

        $this->assertInstanceOf(ContactView::class, $contactView);
        $this->assertEquals('1', $contactView->getId());
        $this->assertEquals('etst@orange.fr', $contactView->getEmail());
        $this->assertEquals('nom', $contactView->getName());
        $this->assertEquals('subject', $contactView->getSubject());
        $this->assertEquals('message', $contactView->getMessage());
    }

    public function testTransformToSearchView()
    {
        $contacts = $this->contactRepository->findPaginatedContacts(
            [],
            ApiSearch::CONTACT_ORDER_BY_ASC,
            1,
            10
        );

        $contactView = $this->contactTransformer->transformContactToSearchView($contacts);

        $this->assertInstanceOf(ContactSearchView::class, $contactView);
        $this->assertEquals('3', $contactView->getNumberOfResult());
        $this->assertIsArray($contactView->getContacts());
    }
}