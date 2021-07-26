<?php

namespace Behat\Context;

use App\Repository\UserRepository;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
use Webmozart\Assert\Assert;

final class RequestContext implements Context
{
    /**
     * @var KernelInterface
     */
    private $kernel;

    /**
     * @var Response|null
     */
    private $response;

    /**
     * @var KernelBrowser
     */
    private $client;

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var JWTTokenManagerInterface
     */
    private $JWTManager;

    public function __construct(
        KernelInterface $kernel,
        KernelBrowser $client,
        UserRepository $userRepository,
        JWTTokenManagerInterface $JWTManager
    ) {
        $this->kernel = $kernel;
        $this->client = $client;
        $this->userRepository = $userRepository;
        $this->JWTManager = $JWTManager;
    }

    /**
     * @Then the status code should be :code
     */
    public function theStatusCodeShouldBe(string $code)
    {
        Assert::eq($this->response->getStatusCode(), $code);
    }

    /**
     * @Then the content type should be :contentType
     */
    public function theContentTypeShouldBe(string $contentType)
    {
        Assert::contains($this->response->headers->get('Content-Type'), $contentType);
    }

    /**
     * @Then the response should have the following content
     */
    public function theContentShouldBe(PyStringNode $payload = null)
    {
        $dataContent = json_decode($payload->getRaw(), true);
        Assert::eq($dataContent, json_decode($this->response->getContent(), true));
    }

    /**
     * @Then the response should contains :arg number of result
     */
    public function theContentContainNumberofData($arg)
    {
        Assert::eq($arg, json_decode($this->response->getContent(), true)['numberOfResult']);
    }

    /**
     * @When I request the url :uri with http verb :method and with the payload
     */
    public function iRequestTheUrlWithHttpVerbAndWithThePayload($uri, $method, PyStringNode $payload = null)
    {
        $payloadString =  $payload ? $payload->getRaw() : null;

        $this->client->request(
            $method,
            $uri,
            ['content-type' => 'application/json'],
            [],
            [],
            $payloadString
        );

        $this->response = $this->client->getResponse();
    }

    /**
     * @When I request the url :uri with http verb :method
     */
    public function iRequestTheUrlWithHttpVerb($uri, $method)
    {
        $this->client->request(
            $method,
            $uri,
            ['content-type' => 'application/json'],
            [],
            [],
            null
        );

        $this->response = $this->client->getResponse();
    }

    /**
     * @Given I am logged with the email :arg1
     */
    public function iAmLoggedWithTheEmail(string $email)
    {
        $user = $this->userRepository->findByEmail($email);

        $this
            ->client
            ->setServerParameter('HTTP_AUTHORIZATION', sprintf('Bearer %s', $this->JWTManager->create($user)));
    }
}
