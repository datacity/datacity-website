<?php

// src/Datacity/UserBundle/EventListener/UserRegisteredListener.php

namespace Datacity\UserBundle\EventListener;

use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Util\SecureRandom;
use Datacity\PrivateBundle\Service\PrivateApi;

/**
 * Listener responsible to create a new user in the api
 */
class UserRegisteredListener implements EventSubscriberInterface
{
    /**
     * {@inheritDoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            FOSUserEvents::REGISTRATION_SUCCESS => 'onRegisterSuccess',
        );
    }

     public function onRegisterSuccess(FormEvent $event)
    {
        $user = $event->getForm()->getData();
        $generator = new SecureRandom();
        $user->genPublicKey($generator)
             ->genPrivateKey($generator);
    }
}
