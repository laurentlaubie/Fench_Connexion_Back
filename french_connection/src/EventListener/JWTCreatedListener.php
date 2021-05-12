<?php

namespace App\EventListener;

use Symfony\Component\HttpFoundation\RequestStack;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;

class JWTCreatedListener
{
  /**
   * @var RequestStack
   */
  private $requestStack;

  /**
   * @param RequestStack $requestStack
   */
  public function __construct(RequestStack $requestStack)
  {
    $this->requestStack = $requestStack;
  }

  /**
   * @param JWTCreatedEvent $event
   *
   * @return void
   */
  public function onJWTCreated(JWTCreatedEvent $event)
  {
    $user = $event->getUser();
    
    $payload = $event->getData();
    
    $payload['id'] = $user->getId();
    $payload['avatar'] = $user->getAvatar();
    $payload['biography'] = $user->getBiography();
    $payload['avatar'] = $user->getAvatar();
    $payload['firsttname'] = $user->getFirstname();
    $payload['lasttname'] = $user->getLastname();
    $payload['nickname'] = $user->getNickname();
    $payload['helper'] = $user->getHelper();

    $event->setData($payload);
  }
}