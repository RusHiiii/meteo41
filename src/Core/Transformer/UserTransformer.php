<?php

namespace App\Core\Transformer;

use App\Entity\Core\ViewModels\User\UserSearchView;
use App\Entity\Core\ViewModels\User\UserView;
use App\Entity\WebApp\User;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Security;

class UserTransformer
{
    /**
     * @var Security
     */
    private $security;

    /**
     * UserTransformer constructor.
     */
    public function __construct(
        Security $security
    ) {
        $this->security = $security;
    }

    /**
     * @param Paginator $paginator
     * @return UserSearchView
     */
    public function transformUserToSearchView(Paginator $paginator)
    {
        $users = [];

        foreach ($paginator as $user) {
            $users[] = $this->transformUserToView($user);
        }

        return new UserSearchView(
            $paginator->count(),
            $users
        );
    }

    /**
     * @param User $user
     * @return UserView
     */
    public function transformUserToView(User $user)
    {
        $email = $roles = null;

        $token = $this->security->getToken();
        if ($token && $this->security->isGranted('ROLE_EDITOR')) {
            $email = $user->getEmail();
            $roles = $user->getRoles();
        }

        return new UserView(
            $user->getId(),
            $user->getFirstname(),
            $user->getLastname(),
            $email,
            $roles,
            $user->getCreatedAt(),
            $user->getUpdatedAt()
        );
    }
}
