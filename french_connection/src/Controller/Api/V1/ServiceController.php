<?php

namespace App\Controller\Api\V1;

use App\Repository\ServiceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/api/v1/service", name="api_v1_service_")
 */
class ServiceController extends AbstractController
{
    /**
     * @Route("", name="browse", methods={"GET"})
     */
    public function browse(ServiceRepository $serviceRepository): Response
    {
        $services = $serviceRepository->findAll();
        return $this->json($services, 200, [], [
            'groups' => ['browse']
            ]);
    }
}
