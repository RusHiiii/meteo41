<?php

namespace App\Controller;

use App\Core\Exception\InvalidCommandException;
use App\Core\Exception\Unit\UnitAlreadyExistException;
use App\Core\Exception\Unit\UnitNotFoundException;
use App\Core\Factory\ErrorFactory;
use App\Core\Response\SerializedErrorResponse;
use App\Core\Response\SerializedResponse;
use App\Core\Tactician\Command\Unit\DeleteUnitCommand;
use App\Core\Tactician\Command\Unit\EditUnitCommand;
use App\Core\Tactician\Command\Unit\RegisterUnitCommand;
use App\Core\Tactician\Mapper\CommandMapper;
use App\Core\Transformer\UnitTransformer;
use App\Repository\Doctrine\UnitRepository;
use League\Tactician\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class UnitController extends AbstractController
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
     * @var UnitRepository
     */
    private $unitRepository;

    /**
     * @var UnitTransformer
     */
    private $unitTransformer;

    public function __construct(
        CommandBus $commandBus,
        CommandMapper $commandMapper,
        ErrorFactory $errorFactory,
        SerializerInterface $serializer,
        UnitRepository $unitRepository,
        UnitTransformer $unitTransformer
    ) {
        $this->commandBus = $commandBus;
        $this->commandMapper = $commandMapper;
        $this->errorFactory = $errorFactory;
        $this->serializer = $serializer;
        $this->unitRepository = $unitRepository;
        $this->unitTransformer = $unitTransformer;
    }

    /**
     * @Route("/api/unit", name="register_unit", methods={"POST"})
     */
    public function registerUnitAction(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        try {
            $command = $this
                ->commandMapper
                ->map($request->getContent(), RegisterUnitCommand::class);
        } catch (InvalidCommandException $e) {
            return new SerializedErrorResponse($e->getMessage(), 400);
        }

        try {
            $this->commandBus->handle($command);
        } catch (UnitAlreadyExistException $e) {
            $error = $this->errorFactory->create($e);
            return new SerializedErrorResponse($this->serializer->serialize($error, 'json'));
        }

        return new SerializedResponse(null, 201);
    }

    /**
     * @Route("/api/unit/{id}", name="update_unit", methods={"PUT"})
     */
    public function updateUnitAction(Request $request, $id): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        try {
            /** @var EditUnitCommand $command */
            $command = $this
                ->commandMapper
                ->map($request->getContent(), EditUnitCommand::class);
        } catch (InvalidCommandException $e) {
            return new SerializedErrorResponse($e->getMessage(), 400);
        }

        $command->setId($id);

        try {
            $this->commandBus->handle($command);
        } catch (UnitNotFoundException $e) {
            $error = $this->errorFactory->create($e);
            return new SerializedErrorResponse($this->serializer->serialize($error, 'json'));
        }

        return new SerializedResponse(null, 201);
    }

    /**
     * @Route("/api/unit/{id}", name="delete_unit", methods={"DELETE"})
     */
    public function deleteUnitAction(Request $request, $id): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $command = new DeleteUnitCommand($id);

        try {
            $this->commandBus->handle($command);
        } catch (UnitNotFoundException $e) {
            $error = $this->errorFactory->create($e);
            return new SerializedErrorResponse($this->serializer->serialize($error, 'json'), 404);
        }

        return new SerializedResponse(null, 204);
    }

    /**
     * @Route("/api/unit/{id}", name="show_unit", methods={"GET"})
     */
    public function showUnitAction(Request $request, $id): Response
    {
        $this->denyAccessUnlessGranted('ROLE_EDITOR');

        $unit = $this->unitRepository->find($id);
        if ($unit === null) {
            $error = $this->errorFactory->create(new UnitNotFoundException());
            return new SerializedErrorResponse($this->serializer->serialize($error, 'json'), 404);
        }

        $unit = $this->unitTransformer->transformUnitToView($unit);

        return new SerializedResponse($this->serializer->serialize($unit, 'json'), 200);
    }

    /**
     * @Route("/api/unit", name="list_unit", methods={"GET"})
     */
    public function listUnitAction(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_EDITOR');

        $units = $this->unitRepository->findAll();

        $units = $this->unitTransformer->transformUnitToSearchView($units);

        return new SerializedResponse($this->serializer->serialize($units, 'json'), 200);
    }
}
