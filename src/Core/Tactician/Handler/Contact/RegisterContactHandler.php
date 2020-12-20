<?php


namespace App\Core\Tactician\Handler\Contact;

use App\Core\Exception\Contact\ContactLimitException;
use App\Core\Factory\ContactFactory;
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
     * @var ContactFactory
     */
    private $contactFactory;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(
        ContactRepository $contactRepository,
        ContactFactory $factory,
        EntityManagerInterface $entityManager
    ) {
        $this->contactRepository = $contactRepository;
        $this->contactFactory = $factory;
        $this->entityManager = $entityManager;
    }


    public function handle(RegisterContactCommand $command)
    {
        $contacts = $this->contactRepository->findByEmailSpamming($command->getEmail());
        if (count($contacts) > 1) {
            throw new ContactLimitException();
        }

        $contact = $this->contactFactory->createContactFromCommand($command);

        $this->entityManager->persist($contact);
    }
}