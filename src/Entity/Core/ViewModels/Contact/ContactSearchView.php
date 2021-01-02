<?php

namespace App\Entity\Core\ViewModels\Contact;

class ContactSearchView
{
    private int $numberOfResult;

    private array $contacts;

    /**
     * ContactSearchView constructor.
     * @param int $numberOfResult
     * @param array $contacts
     */
    public function __construct(int $numberOfResult, array $contacts)
    {
        $this->numberOfResult = $numberOfResult;
        $this->contacts = $contacts;
    }

    /**
     * @return int
     */
    public function getNumberOfResult(): int
    {
        return $this->numberOfResult;
    }

    /**
     * @return array
     */
    public function getContacts(): array
    {
        return $this->contacts;
    }
}
