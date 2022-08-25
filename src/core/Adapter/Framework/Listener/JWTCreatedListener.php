<?php

declare(strict_types=1);

namespace App\core\Adapter\Framework\Listener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;

class JWTCreatedListener
{
    public function __construct()
    {
    }

    public function onJWTCreated(JWTCreatedEvent $event): void
    {
        $user = $event->getUser();

        $payload = $event->getData();
        $payload['id'] = $user->getId();
        unset($payload['roles']);

        $event->setData($payload);
    }
}
