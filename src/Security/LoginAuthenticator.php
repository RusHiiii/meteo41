<?php


namespace App\Security;


use App\Repository\UserRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\NativePasswordEncoder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

class LoginAuthenticator extends AbstractGuardAuthenticator
{
    private $userRepository;

    private $passwordEncoder;

    private $JWTManager;

    public function __construct(
      UserRepository $userRepository,
      NativePasswordEncoder $passwordEncoder,
      JWTTokenManagerInterface $JWTManager
    ) {
        $this->userRepository = $userRepository;
        $this->passwordEncoder = $passwordEncoder;
        $this->JWTManager = $JWTManager;
    }

    public function start(Request $request, AuthenticationException $authException = null)
    {
        return new JsonResponse(null, Response::HTTP_UNAUTHORIZED);
    }

    public function supports(Request $request)
    {
        if ($request->getPathInfo() === '/api/login' and $request->getMethod() === 'POST') {
            return true;
        }

        return false;
    }

    public function getCredentials(Request $request)
    {
        return json_decode($request->getContent(), true);
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $user = $this->userRepository->findByEmail($credentials['email']);

        if (!$user) {
            throw new CustomUserMessageAuthenticationException("User not found");
        }

        return $user;
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        return $this->passwordEncoder->isPasswordValid($user->getPassword(), $credentials['password'], null);
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        return new JsonResponse(['code' => 403, 'message' => 'Bad credential'], Response::HTTP_FORBIDDEN);
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        return new JsonResponse(['token' => $this->JWTManager->create($token->getUser())]);
    }

    public function supportsRememberMe()
    {
        return false;
    }
}