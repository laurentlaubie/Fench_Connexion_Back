<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ServiceController extends AbstractController
{
    /**
     * @Route("/service", name="service_browse")
     */
    public function browse(): Response
    {
        return $this->render('service/browse.html.twig', [
            'controller_name' => 'ServiceController',
        ]);
    }
}
