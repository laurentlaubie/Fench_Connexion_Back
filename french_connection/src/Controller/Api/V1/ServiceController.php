<?php

namespace App\Controller\Api\V1;

use App\Entity\Service;
use App\Form\ServiceType;
use App\Repository\ServiceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    /**
     * @Route("", name="add", methods={"POST"})
     */
    public function add(Request $request): Response
    {
        $service = new Service();
        
        $form = $this->createForm(ServiceType::class, $service, ['csrf_protection' => false]);
        
        $sentData = json_decode($request->getContent(), true);
        $form->submit($sentData);
        
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($service);
            $em->flush();

            return $this->json($service, 201, [], [
                'groups' => ['browse'],
            ]);
        }
        
        return $this->json($form->getErrors(true, false)->__toString(), 400);
    }
}
