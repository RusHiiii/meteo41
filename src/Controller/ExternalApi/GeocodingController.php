<?php

namespace App\Controller\ExternalApi;

use App\Core\Constant\Contact\ApiSearch;
use App\Core\Exception\Contact\ContactLimitException;
use App\Core\Exception\Contact\ContactNotFoundException;
use App\Core\Exception\ExternalApi\GeocodingException;
use App\Core\Exception\InvalidCommandException;
use App\Core\ExternalApi\Geocoding;
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

class GeocodingController extends AbstractController
{
    /**
     * @var ErrorFactory
     */
    private $errorFactory;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @var Geocoding
     */
    private $geocoding;

    public function __construct(
        ErrorFactory $errorFactory,
        SerializerInterface $serializer,
        Geocoding $geocoding
    ) {
        $this->errorFactory = $errorFactory;
        $this->serializer = $serializer;
        $this->geocoding = $geocoding;
    }

    /**
     * @Route("/api/geocoding", name="geocoding", methods={"GET"})
     */
    public function fetchGeocoding(Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_ANONYMOUSLY');

        $address = $request->query->get('address');
        ;

        try {
            $content = $this->geocoding->fetchGeocoding($address);
        } catch (\Exception $e) {
            $error = $this->errorFactory->create($e);
            return new SerializedErrorResponse($this->serializer->serialize($error, 'json'));
        }

        return new SerializedResponse($this->serializer->serialize($content, 'json'), 200);
    }
}
