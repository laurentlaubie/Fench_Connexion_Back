<?php

namespace App\Controller\Admin;

use App\Entity\Hobby;
use App\Form\HobbyType;
use App\Repository\HobbyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/admin/hobby", name="admin_hobby_")
 */
class HobbyController extends AbstractController
{
    /**
     * @Route("", name="browse")
     */
    public function browse(HobbyRepository $hobbyRepository): Response
    {
        $hobbies = $hobbyRepository->findAll();

        return $this->render('admin/hobby/browse.html.twig', [
            'hobbies' => $hobbies,
        ]);
    }

    /**
     * @Route("/add", name="add")
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

            return $this->redirectToRoute('admin_hobby_browse');
        }
        
        return $this->render('admin/hobby/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/edit/{id}", name="edit", requirements={"id": "\d+"})
     */
    public function edit(Hobby $hobby, Request $request, int $id): Response
    {

        $form = $this->createForm(HobbyType::class, $hobby);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hobby->setUpdatedAt(new \DateTime());
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'Le hobby ' . $hobby->getName() . ' a bien été modifié');

            return $this->redirectToRoute('admin_hobby_browse');
        }

        return $this->render('admin/hobby/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete", requirements={"id": "\d+"}, methods={"DELETE"})
     */
    public function delete(Hobby $hobby): Response
    {
            $em = $this->getDoctrine()->getManager();
            $em->remove($hobby);
            $em->flush();

            $this->addFlash('success', 'Le hobby ' . $hobby->getName() . ' a bien été supprimée');
        

        return $this->redirectToRoute('admin_hobby_browse');
    }
}
