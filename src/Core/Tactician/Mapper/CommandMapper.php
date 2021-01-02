<?php

namespace App\Core\Tactician\Mapper;

use App\Core\Exception\InvalidCommandException;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CommandMapper
{
    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * CommandMapper constructor.
     * @param SerializerInterface $serializer
     * @param ValidatorInterface $validator
     */
    public function __construct(
        SerializerInterface $serializer,
        ValidatorInterface $validator
    ) {
        $this->serializer = $serializer;
        $this->validator = $validator;
    }

    /**
     * @return array|object
     * @throws InvalidCommandException
     */
    public function map($json, $classToMap)
    {
        $command = $this->serializer->deserialize($json, $classToMap, 'json');
        $violations = $this->validator->validate($command);

        if ($violations->count() > 0) {
            throw new InvalidCommandException($this->serializer->serialize(iterator_to_array($violations), 'json', ['groups' => ['constraint']]));
        }

        return $command;
    }
}
