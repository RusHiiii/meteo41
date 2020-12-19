<?php


namespace App\Tests\Integration\Assembler;

use App\Core\Assembler\ContactAssembler;
use App\Core\Tactician\Command\Contact\RegisterContactCommand;
use App\Repository\Doctrine\ContactRepository;
use App\Tests\TestCase;
use Doctrine\ORM\EntityManagerInterface;

class ContactAssemblerTest extends TestCase
{
    /**
     * @var ContactRepository
     */
    private $contactRepository;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var ContactAssembler
     */
    private $contactAssembler;

    protected function setUp()
    {
        parent::setUp();
        $this->contactRepository = self::$container->get(ContactRepository::class);
        $this->entityManager = self::$container->get(EntityManagerInterface::class);
        $this->contactAssembler = self::$container->get(ContactAssembler::class);
    }

    public function testCreateContactFromCommand()
    {
        $command = new RegisterContactCommand('name', 'email@email.fr', 'subject', 'message');
        $contact = $this->contactAssembler->createContactFromCommand($command);

        $this->assertEquals('name', $contact->getName());
        $this->assertEquals('subject', $contact->getSubject());
        $this->assertEquals('email@email.fr', $contact->getEmail());
        $this->assertEquals('message', $contact->getMessage());
    }
}