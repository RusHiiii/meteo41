<?php

namespace Behat\Context;

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
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

    public function __construct(
        KernelInterface $kernel,
        KernelBrowser $client
    )
    {
        $this->kernel = $kernel;
        $this->client = $client;
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
     * @Then the content should have the following content
     */
    public function theContentShouldBe(PyStringNode $payload = null)
    {
        $dataContent = json_decode($payload->getRaw(), true);

        Assert::eq($dataContent, json_decode($this->response->getContent(), true));
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
}
