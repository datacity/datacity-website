<?php

// src/Datacity/UserBundle/EventListener/UserRegisteredListener.php

namespace Datacity\UserBundle\EventListener;

use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Datacity\PrivateBundle\Service\PrivateApi;

/**
 * Listener responsible to create a new user in the api
 */
class UserRegisteredListener implements EventSubscriberInterface
{
    private $privateApi;

    public function __construct(PrivateApi $privateApi)
    {
        $this->privateApi = $privateApi;
    }

    /**
     * {@inheritDoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            FOSUserEvents::REGISTRATION_COMPLETED => 'onRegisterCompleted',
        );
    }

    public function onRegisterCompleted(FilterUserResponseEvent $event)
    {
        try {
            $this->privateApi->createClient($event->getUser()->getUsernameCanonical(), '40M');
        }
        catch (\Exception $e)
        {
            //TODO Mark user was not created
        }
        //$event->setResponse(new RedirectResponse($url));
    }
}
