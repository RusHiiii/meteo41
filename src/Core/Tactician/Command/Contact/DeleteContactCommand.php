<?php


namespace App\Core\Tactician\Command\Contact;


class DeleteContactCommand
{
    private int $id;

    /**
     * DeleteContactCommand constructor.
     * @param int $id
     */
    public function __construct(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
}