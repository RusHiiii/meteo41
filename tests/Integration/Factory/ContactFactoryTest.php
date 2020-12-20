<?php


namespace App\Tests\Integration\Factory;

use App\Core\Factory\ContactFactory;
use App\Core\Tactician\Command\Contact\RegisterContactCommand;
use App\Repository\Doctrine\ContactRepository;
use App\Tests\TestCase;

class ContactFactoryTest extends TestCase
{
    /**
     * @var ContactRepository
     */
    private $contactRepository;

    /**
     * @var ContactFactory
     */
    private $contactFactory;

    protected function setUp()
    {
        parent::setUp();
        $this->contactRepository = self::$container->get(ContactRepository::class);
        $this->contactFactory = self::$container->get(ContactFactory::class);
    }

    public function testCreateContactFromCommand()
    {
        $command = new RegisterContactCommand('name', 'email@email.fr', 'subject', 'message');
        $contact = $this->contactFactory->createContactFromCommand($command);

        $this->assertEquals('name', $contact->getName());
        $this->assertEquals('subject', $contact->getSubject());
        $this->assertEquals('email@email.fr', $contact->getEmail());
        $this->assertEquals('message', $contact->getMessage());
    }
}