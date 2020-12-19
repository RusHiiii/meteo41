<?php

namespace App\Controller;

use App\Core\Exception\Contact\ContactLimitException;
use App\Core\Exception\InvalidCommandException;
use App\Core\Factory\ErrorFactory;
use App\Core\Response\SerializedErrorResponse;
use App\Core\Response\SerializedResponse;
use App\Core\Tactician\Command\Contact\RegisterContactCommand;
use App\Core\Tactician\Mapper\CommandMapper;
use League\Tactician\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class ContactController extends AbstractController
{
    /**
     * @var CommandBus
     */
    private $commandBus;

    /**
     * @var CommandMapper
     */
    private $commandMapper;

    /**
     * @var ErrorFactory
     */
    private $errorFactory;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    public function __construct(
        CommandBus $commandBus,
        CommandMapper $commandMapper,
        ErrorFactory $errorFactory,
        SerializerInterface $serializer
    ) {
        $this->commandBus = $commandBus;
        $this->commandMapper = $commandMapper;
        $this->errorFactory = $errorFactory;
        $this->serializer = $serializer;
    }


    /**
     * @Route("/api/contact", name="register_contact", methods={"POST"})
     */
    public function index(Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_ANONYMOUSLY');

        try {
            $command = $this
                ->commandMapper
                ->map($request->getContent(), RegisterContactCommand::class);
        } catch (InvalidCommandException $e) {
            return new SerializedErrorResponse($e->getMessage(), 400);
        }

        try {
            $this->commandBus->handle($command);
        } catch (ContactLimitException $e) {
            $error = $this->errorFactory->create($e);
            return new SerializedErrorResponse($this->serializer->serialize($error, 'json'));
        }

        return new SerializedResponse(null, 201);
    }
}
