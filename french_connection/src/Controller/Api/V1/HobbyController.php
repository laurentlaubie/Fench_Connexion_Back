<?php

namespace App\Controller\Api\V1;

use App\Entity\Hobby;
use App\Form\HobbyType;
use App\Repository\HobbyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/api/v1/hobby", name="api_v1_hobby_")
 */
class HobbyController extends AbstractController
{
    /**
     * @Route("", name="browse", methods={"GET"})
     */
    public function browse(HobbyRepository $hobbyRepository): Response
    {
        $hobbies = $hobbyRepository->findAll();
        return $this->json($hobbies, 200, [], [
            'groups' => ['browse']
            ]);
    }

    /**
     * @Route("", name="add", methods={"POST"})
     */
    public function add(Request $request): Response
    {
        $hobby = new Hobby();
        
        $form = $this->createForm(HobbyType::class, $hobby, ['csrf_protection' => false]);
        
        $sentData = json_decode($request->getContent(), true);
        $form->submit($sentData);
        
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($hobby);
            $em->flush();

            return $this->json($hobby, 201, [], [
                'groups' => ['browse'],
            ]);
        }
        
        return $this->json($form->getErrors(true, false)->__toString(), 400);
    }
}
