<?php


namespace App\Core\Transformer;


use App\Entity\Core\ViewModels\Contact\ContactView;
use App\Entity\WebApp\Contact;

class ContactTransformer
{
    /**
     * @param Contact $contact
     * @return ContactView
     */
    public function transformContactToView(Contact $contact)
    {
        return new ContactView(
            $contact->getId(),
            $contact->getName(),
            $contact->getSubject(),
            $contact->getEmail(),
            $contact->getCreatedAt(),
            $contact->getUpdatedAt(),
            $contact->getMessage()
        );
    }
}