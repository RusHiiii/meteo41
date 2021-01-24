<?php

namespace App\Core\Transformer;

use App\Entity\Core\ViewModels\User\UserSearchView;
use App\Entity\Core\ViewModels\User\UserView;
use App\Entity\WebApp\User;
use Doctrine\ORM\Tools\Pagination\Paginator;

class UserTransformer
{
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
        return new UserView(
            $user->getId(),
            $user->getFirstname(),
            $user->getLastname(),
            $user->getEmail(),
            $user->getRoles(),
            $user->getCreatedAt(),
            $user->getUpdatedAt()
        );
    }
}
