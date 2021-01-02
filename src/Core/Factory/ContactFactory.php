<?php

namespace App\Core\Factory;

use App\Core\Tactician\Command\Contact\EditContactCommand;
use App\Core\Tactician\Command\Contact\RegisterContactCommand;
use App\Entity\WebApp\Contact;

class ContactFactory
{
    /**
     * @param RegisterContactCommand $command
     * @return Contact
     */
    public function createContactFromCommand(RegisterContactCommand $command)
    {
        return new Contact(
            $command->getName(),
            $command->getSubject(),
            $command->getEmail(),
            $command->getMessage()
        );
    }

    /**
     * @param Contact $contact
     * @param EditContactCommand $command
     */
    public function editContactFromCommand(Contact $contact, EditContactCommand $command)
    {
        $contact->setEmail($command->getEmail());
        $contact->setMessage($command->getMessage());
        $contact->setName($command->getName());
        $contact->setSubject($command->getSubject());
        $contact->setUpdatedAt(new \DateTime());

        return $contact;
    }
}
