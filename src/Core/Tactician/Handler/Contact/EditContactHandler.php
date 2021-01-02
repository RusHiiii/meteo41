<?php

namespace App\Core\Tactician\Handler\Contact;

use App\Core\Exception\Contact\ContactNotFoundException;
use App\Core\Factory\ContactFactory;
use App\Core\Tactician\Command\Contact\EditContactCommand;
use App\Repository\Doctrine\ContactRepository;

class EditContactHandler
{
    /**
     * @var ContactRepository
     */
    private $contactRepository;

    /**
     * @var ContactFactory
     */
    private $contactFactory;

    public function __construct(
        ContactRepository $contactRepository,
        ContactFactory $factory
    ) {
        $this->contactRepository = $contactRepository;
        $this->contactFactory = $factory;
    }


    public function handle(EditContactCommand $command)
    {
        $contact = $this->contactRepository->find($command->getId());
        if ($contact === null) {
            throw new ContactNotFoundException();
        }

        $contact = $this->contactFactory->editContactFromCommand($contact, $command);
    }
}
