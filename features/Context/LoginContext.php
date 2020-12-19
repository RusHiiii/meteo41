<?php

namespace Behat\Context;

use App\Repository\UserRepository;
use Behat\Behat\Context\Context;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Webmozart\Assert\Assert;

final class LoginContext implements Context
{
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
        KernelBrowser $client,
        UserRepository  $userRepository,
        JWTTokenManagerInterface $JWTManager
    ) {
        $this->client = $client;
        $this->userRepository = $userRepository;
        $this->JWTManager = $JWTManager;
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
