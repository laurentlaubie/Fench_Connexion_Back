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

    $payload['user'] = $user->getId();
    $payload['avatar'] = $user->getAvatar();
    $payload['biography'] = $user->getBiography();
    $payload['firstname'] = $user->getFirstname();
    $payload['lastname'] = $user->getLastname();
    $payload['nickname'] = $user->getNickname();
    $payload['helper'] = $user->getHelper();
    $payload['phoneNumber'] = $user->getPhoneNumber();
    $payload['cities'] = array (
      'id' => $user->getCities()->getId(),
      'name' => $user->getCities()->getName(),
      'longitude' => $user->getCities()->getLongitude(),
      'latitude' => $user->getCities()->getLatitude(),
    );
    $payload['hobbies'] = $user->getHobbies();
    $payload['services'] = $user->getServices();
    //dd($user->getServices());
    $event->setData($payload);
  }
}
