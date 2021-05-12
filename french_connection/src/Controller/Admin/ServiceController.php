<?php

namespace App\Controller\Admin;

use App\Entity\Service;
use App\Form\Admin\ServiceType;
use App\Repository\ServiceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/service", name="admin_service_")
 */
class ServiceController extends AbstractController
{
    /**
     * @Route("", name="browse")
     */
    public function browse(ServiceRepository $serviceRepository): Response
    {
        $services = $serviceRepository->findAll();

        return $this->render('admin/service/browse.html.twig', [
            'services' => $services,
        ]);
    }

    /**
     * @Route("/add", name="add")
     */
    public function add(Request $request): Response
    {
        $service = new Service();

        $form = $this->createForm(ServiceType::class, $service);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($service);
            $em->flush();

            $this->addFlash('success', 'Le service ' . $service->getName() . ' a bien été ajouté');

            return $this->redirectToRoute('admin_service_browse');
        }
        
        return $this->render('admin/service/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/edit/{id}", name="edit", requirements={"id": "\d+"})
     */
    public function edit(Service $service, Request $request, int $id): Response
    {

        $form = $this->createForm(ServiceType::class, $service);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $service->setUpdatedAt(new \DateTime());
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'Le service ' . $service->getName() . ' a bien été modifié');

            return $this->redirectToRoute('admin_service_browse');
        }

        return $this->render('admin/service/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete", requirements={"id": "\d+"}, methods={"DELETE"})
     */
    public function delete(Service $service): Response
    {
            $em = $this->getDoctrine()->getManager();
            $em->remove($service);
            $em->flush();

            $this->addFlash('success', 'Le service ' . $service->getName() . ' a bien été supprimée');
        

        return $this->redirectToRoute('admin_service_browse');
    }
}
