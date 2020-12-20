<?php


namespace App\Core\Tactician\Handler\Contact;


use App\Core\Exception\Contact\ContactNotFoundException;
use App\Core\Tactician\Command\Contact\DeleteContactCommand;
use App\Repository\Doctrine\ContactRepository;
use Doctrine\ORM\EntityManagerInterface;

class DeleteContactHandler
{
    /**
     * @var ContactRepository
     */
    private $contactRepository;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(
        ContactRepository $contactRepository,
        EntityManagerInterface $entityManager
    ) {
        $this->contactRepository = $contactRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @param DeleteContactCommand $command
     * @throws ContactNotFoundException
     */
    public function handle(DeleteContactCommand $command)
    {
        $contact = $this->contactRepository->find($command->getId());
        if ($contact === null) {
            throw new ContactNotFoundException();
        }

        $this->entityManager->remove($contact);
    }
}