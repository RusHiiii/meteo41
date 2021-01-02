<?php


namespace App\Core\Transformer;


use App\Entity\Core\ViewModels\Contact\ContactSearchView;
use App\Entity\Core\ViewModels\Contact\ContactView;
use App\Entity\WebApp\Contact;
use Doctrine\ORM\Tools\Pagination\Paginator;

class ContactTransformer
{
    /**
     * @param Paginator $paginator
     * @return ContactSearchView
     */
    public function transformContactToSearchView(Paginator $paginator)
    {
        $contacts = [];

        foreach ($paginator as $contact) {
            $contacts[] = $this->transformContactToView($contact);
        }

        return new ContactSearchView(
            $paginator->count(),
            $contacts
        );
    }

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