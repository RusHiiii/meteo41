<?php

namespace App\Controller;

use App\Core\Constant\Contact\ApiSearch;
use App\Core\Exception\Contact\ContactLimitException;
use App\Core\Exception\Contact\ContactNotFoundException;
use App\Core\Exception\InvalidCommandException;
use App\Core\Factory\ErrorFactory;
use App\Core\Response\SerializedErrorResponse;
use App\Core\Response\SerializedResponse;
use App\Core\Tactician\Command\Contact\DeleteContactCommand;
use App\Core\Tactician\Command\Contact\EditContactCommand;
use App\Core\Tactician\Command\Contact\RegisterContactCommand;
use App\Core\Tactician\Mapper\CommandMapper;
use App\Core\Transformer\ContactTransformer;
use App\Repository\Doctrine\ContactRepository;
use League\Tactician\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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

    /**
     * @var ContactRepository
     */
    private $contactRepository;

    /**
     * @var ContactTransformer
     */
    private $contactTransformer;

    public function __construct(
        CommandBus $commandBus,
        CommandMapper $commandMapper,
        ErrorFactory $errorFactory,
        SerializerInterface $serializer,
        ContactRepository $contactRepository,
        ContactTransformer $contactTransformer
    ) {
        $this->commandBus = $commandBus;
        $this->commandMapper = $commandMapper;
        $this->errorFactory = $errorFactory;
        $this->serializer = $serializer;
        $this->contactRepository = $contactRepository;
        $this->contactTransformer = $contactTransformer;
    }

    /**
     * @Route("/api/contact", name="register_contact", methods={"POST"})
     */
    public function registerContactAction(Request $request): Response
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

    /**
     * @Route("/api/contact/{id}", name="delete_contact", methods={"DELETE"})
     */
    public function deleteContactAction(Request $request, $id): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $command = new DeleteContactCommand($id);

        try {
            $this->commandBus->handle($command);
        } catch (ContactNotFoundException $e) {
            $error = $this->errorFactory->create($e);
            return new SerializedErrorResponse($this->serializer->serialize($error, 'json'), 404);
        }

        return new SerializedResponse(null, 204);
    }

    /**
     * @Route("/api/contact/{id}", name="update_contact", methods={"PUT"})
     */
    public function updateContactAction(Request $request, $id): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        try {
            /** @var EditContactCommand */
            $command = $this
                ->commandMapper
                ->map($request->getContent(), EditContactCommand::class);
        } catch (InvalidCommandException $e) {
            return new SerializedErrorResponse($e->getMessage(), 400);
        }

        $command->setId($id);

        try {
            $this->commandBus->handle($command);
        } catch (ContactNotFoundException $e) {
            $error = $this->errorFactory->create($e);
            return new SerializedErrorResponse($this->serializer->serialize($error, 'json'), 404);
        }

        return new SerializedResponse(null, 204);
    }

    /**
     * @Route("/api/contact/{id}", name="show_contact", methods={"GET"})
     */
    public function showContactAction(Request $request, $id): Response
    {
        $this->denyAccessUnlessGranted('ROLE_EDITOR');

        $contact = $this->contactRepository->find($id);
        if ($contact === null) {
            $error = $this->errorFactory->create(new ContactNotFoundException());
            return new SerializedErrorResponse($this->serializer->serialize($error, 'json'), 404);
        }

        $contact = $this->contactTransformer->transformContactToView($contact);

        return new SerializedResponse($this->serializer->serialize($contact, 'json'), 200);
    }

    /**
     * @Route("/api/contact", name="list_contact", methods={"GET"})
     */
    public function listContactAction(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_EDITOR');

        try {
            $contacts = $this->contactRepository->findPaginatedContacts(
                $request->query->get('searchBy', []),
                $request->query->get('order', ApiSearch::CONTACT_ORDER_BY_ASC),
                $request->query->get('page', 1),
                $request->query->get('maxResult', 10)
            );
        } catch (\InvalidArgumentException $e) {
            $error = $this->errorFactory->create($e);
            return new SerializedErrorResponse($this->serializer->serialize($error, 'json'), 400);
        }

        $contact = $this->contactTransformer->transformContactToSearchView($contacts);

        return new SerializedResponse($this->serializer->serialize($contact, 'json'), 200);
    }
}
