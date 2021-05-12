<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ServiceController extends AbstractController
{
    /**
     * @Route("/admin/service", name="admin_service")
     */
    public function index(): Response
    {
        return $this->render('admin/service/index.html.twig', [
            'controller_name' => 'ServiceController',
        ]);
    }
}
