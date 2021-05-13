<?php

namespace App\Controller\Api\V1;

use App\Entity\Country;
use App\Repository\CountryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/v1/country", name="api_v1_country_")
 */
class CountryController extends AbstractController
{
    /**
     * @Route("", name="browse", methods={"GET"})
     */
    public function browse(CountryRepository $countryRepository): Response
    {
        $countries = $countryRepository->findAll();
        return $this->json($countries, 200, [], [
            'groups' => ['countryBrowse']
            ]);
    }

    /**
     * @Route("/{id}", name="read", methods={"GET"}, requirements={"id": "\d+"})
     */
    public function read(Country $country): Response
    {
        return $this->json($country, 200, [], [
            'groups' => ['countryRead']
        ]);
    }
}
