<?php


namespace App\Core\Tactician\Handler\Contact;


use App\Core\Assembler\ContactAssembler;
use App\Core\Exception\Contact\ContactLimitException;
use App\Core\Tactician\Command\Contact\RegisterContactCommand;
use App\Repository\Doctrine\ContactRepository;
use Doctrine\ORM\EntityManagerInterface;

class RegisterContactHandler
{
    /**
     * @var ContactRepository
     */
    private $contactRepository;

    /**
     * @var ContactAssembler
     */
    private $contactAssembler;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(
        ContactRepository $contactRepository,
        ContactAssembler $assembler,
        EntityManagerInterface $entityManager
    ) {
        $this->contactRepository = $contactRepository;
        $this->contactAssembler = $assembler;
        $this->entityManager = $entityManager;
    }


    public function handle(RegisterContactCommand $command)
    {
        $contacts = $this->contactRepository->findByEmailSpamming($command->getEmail());
        if (count($contacts) > 1) {
            throw new ContactLimitException();
        }

        $contact = $this->contactAssembler->createContactFromCommand($command);

        $this->entityManager->persist($contact);
    }
}