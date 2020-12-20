<?php


namespace App\Tests\Integration\Transformer;

use App\Core\Transformer\ContactTransformer;
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
}