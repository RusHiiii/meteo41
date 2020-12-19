<?php


namespace App\Core\Assembler;


use App\Core\Tactician\Command\Contact\RegisterContactCommand;
use App\Entity\WebApp\Contact;

class ContactAssembler
{
    public function createContactFromCommand(RegisterContactCommand  $command)
    {
        return new Contact(
            $command->getName(),
            $command->getSubject(),
            $command->getEmail(),
            $command->getMessage()
        );
    }
}