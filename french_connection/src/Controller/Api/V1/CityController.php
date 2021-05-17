<?php

namespace App\Controller\Api\V1;

use App\Entity\City;
use App\Form\CityType;
use App\Repository\CityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/api/v1/city", name="api_v1_city_")
 */
class CityController extends AbstractController
{
    /**
     * @Route("", name="browse", methods={"GET"})
     */
    public function index(CityRepository $cityRepository): Response
    {
        $cities = $cityRepository->findAll();
        
        return $this->json($cities, 200, [], [
            'groups' => ['cityBrowse']
            ]);
    }

    /**
     * @Route("/{id}", name="read", methods={"GET"}, requirements={"id": "\d+"})
     */
    public function read(City $city): Response
    {
        return $this->json($city, 200, [], [
            'groups' => ['cityRead']
        ]);
    }

    /**
     * @Route("", name="add", methods={"POST"})
     */
    public function add(Request $request): Response
    {
        $city = new City();
        
        $form = $this->createForm(CityType::class, $city, ['csrf_protection' => false]);
        
        $sentData = json_decode($request->getContent(), true);
        $form->submit($sentData);
        
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($city);
            $em->flush();

            return $this->json($city, 201, [], [
                'groups' => ['cityRead'],
            ]);
        }
        
        return $this->json($form->getErrors(true, false)->__toString(), 400);
    }
}
