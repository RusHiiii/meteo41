<?php

namespace Behat\Context;

use App\Repository\UserRepository;
use Behat\Behat\Context\Context;
use Symfony\Component\Security\Core\Encoder\NativePasswordEncoder;
use Webmozart\Assert\Assert;

final class UserContext implements Context
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var NativePasswordEncoder
     */
    private $passwordEncoder;

    public function __construct(
        UserRepository $userRepository,
        NativePasswordEncoder $passwordEncoder
    )
    {
        $this->userRepository = $userRepository;
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @Then User with mail :email has role :role
     */
    public function userShouldHaveRole(string $email, string $role)
    {
        $user = $this->userRepository->findByEmail($email);
        Assert::true(in_array($role, $user->getRoles()));
    }

    /**
     * @Then User with mail :email has password :password
     */
    public function userShouldHavePassword(string $email, string $password)
    {
        $user = $this->userRepository->findByEmail($email);
        Assert::true($this->passwordEncoder->isPasswordValid($user->getPassword(), $password, null));
    }
}