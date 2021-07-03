<?php

namespace App\Controller\ExternalApi;

use App\Core\Constant\Contact\ApiSearch;
use App\Core\Exception\Contact\ContactLimitException;
use App\Core\Exception\Contact\ContactNotFoundException;
use App\Core\Exception\ExternalApi\GeocodingException;
use App\Core\Exception\InvalidCommandException;
use App\Core\ExternalApi\Geocoding;
use App\Core\ExternalApi\OpenWeather;
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

class OpenWeatherController extends AbstractController
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
     * @var OpenWeather
     */
    private $openWeather;

    public function __construct(
        ErrorFactory $errorFactory,
        SerializerInterface $serializer,
        OpenWeather $openWeather
    ) {
        $this->errorFactory = $errorFactory;
        $this->serializer = $serializer;
        $this->openWeather = $openWeather;
    }

    /**
     * @Route("/api/openWeather", name="openWeather", methods={"GET"})
     */
    public function fetchOpenWeather(Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_ANONYMOUSLY');

        $lat = $request->query->get('lat');
        $lng = $request->query->get('lng');

        try {
            $content = $this->openWeather->fetchOpenWeather($lat, $lng);
        } catch (\Exception $e) {
            $error = $this->errorFactory->create($e);
            return new SerializedErrorResponse($this->serializer->serialize($error, 'json'));
        }

        return new SerializedResponse($this->serializer->serialize($content, 'json'), 200);
    }
}
