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
    $payload['firstname'] = $user->getFirstname();
    $payload['lastname'] = $user->getLastname();
    $payload['nickname'] = $user->getNickname();
    $payload['helper'] = $user->getHelper();
    $payload['phoneNumber'] = $user->getPhoneNumber();

    if (!empty($user->getCities())) {
      $payload['cities'] = array (
        'id' => $user->getCities()->getId(),
        'name' => $user->getCities()->getName(),
        'longitude' => $user->getCities()->getLongitude(),
        'latitude' => $user->getCities()->getLatitude(),
      );
    } else {
      $payload['cities'] =[];
    }
    
    if (!empty($user->getCities())) {
      $payload['countries'] = array (
        'id' => $user->getCities()->getCountry()->getId(),
        'name' => $user->getCities()->getCountry()->getName(),
        'frenchName' => $user->getCities()->getCountry()->getFrenchName(),
      );
    } else {
      $payload['countries'] =[];
    }
    

    $services = $user->getServices();

    if (count($services) > 0) {
        foreach ($services as $service) {
            $payload['services'][] = array(
        'id' => $service->getId(),
        'name' => $service->getName(),
      );
        }
    } else {
      $payload['services'] =[];
    }

    $hobbies = $user->getHobbies();

    if (count($hobbies) > 0) {
        foreach ($hobbies as $hobby) {
            $payload['hobbies'][] = array(
        'id' => $hobby->getId(),
        'name' => $hobby->getName(),
      );
        }
    } else {
      $payload['hobbies'] =[];
    }

    $event->setData($payload);
  }
}
