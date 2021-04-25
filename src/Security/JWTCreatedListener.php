<?php

namespace App\Security;

use App\Entity\WebApp\User;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;

class JWTCreatedListener
{
    /**
     * @param JWTCreatedEvent $event
     *
     * @return void
     */
    public function onJWTCreated(JWTCreatedEvent $event)
    {
        /**
         * @var User $user
         */
        $user = $event->getUser();
        if (!$event->getUser() instanceof User) {
            return;
        }

        $payload = $event->getData();
        $payload['firstName'] = $user->getFirstname();
        $payload['lastName'] = $user->getLastname();
        $payload['roles'] = $user->getRoles();
        $payload['id'] = $user->getId();
        $payload['connected'] = true;

        $event->setData($payload);
    }
}
