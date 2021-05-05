<?php

namespace App\Controller;

use App\Entity\Hobby;
use App\Form\HobbyType;
use App\Repository\HobbyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class HobbyController extends AbstractController
{
    /**
     * @Route("/hobby", name="hobby_browse")
     */
    public function browse(HobbyRepository $hobbyRepository): Response
    {
        return $this->render('hobby/browse.html.twig', [
            'hobbies' => $hobbyRepository->findAll(),
        ]);
    }

    /**
     * @Route("/hobby/add", name="hobby_add")
     */
    public function add(Request $request): Response
    {
        $hobby = new Hobby();
        
        $form = $this->createForm(HobbyType::class, $hobby);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($hobby);
            $em->flush();

            $this->addFlash('success', 'Le hobby ' . $hobby->getName() . ' a bien été ajouté');

            return $this->redirectToRoute('hobby_browse');
        }
        
        return $this->render('hobby/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
