<?php

namespace App\Controller\Api\V1;

use App\Entity\Hobby;
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
}
