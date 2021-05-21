<?php

namespace App\Controller\Api\V1;

use App\Entity\City;
use App\Entity\User;
use App\Form\UserType;
use App\Form\UserEditType;
use App\Repository\CityRepository;
use App\Service\AvatarUploader;
use App\Repository\UserRepository;
use App\Repository\CountryRepository;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/api/v1/user", name="api_v1_user_")
 */
class UserController extends AbstractController
{
    /**
     * @Route("", name="browse", methods={"GET"})
     */
    public function browse(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();

        return $this->json($users, 200, [], [
            'groups' => ['browse']
        ]);
    }

    /**
     * @Route("/home", name="home_browse", methods={"GET"})
     */
    public function homeBrowse(Request $request, UserRepository $userRepository): Response
    {
        $limitParameter = intval($request->query->get('limit'));

        if ($limitParameter == 0) {
            $limitParameter = 4;
        }

        $users = $userRepository->findByLatest($limitParameter);

        return $this->json($users, 200, [], [
            'groups' => ['homeBrowse']
        ]);
    }

    /**
     * @Route("/{id}", name="read", methods={"GET"}, requirements={"id": "\d+"})
     */
    public function read(User $user): Response
    {
        return $this->json($user, 200, [], [
            'groups' => ['read']
        ]);
    }

    /**
     * @Route("", name="add", methods={"POST"})
     */
    public function add(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = new User();

        $form = $this->createForm(UserType::class, $user, ['csrf_protection' => false]);

        $sentData = json_decode($request->getContent(), true);
        $form->submit($sentData);

        if ($form->isValid()) {
            $password = $form->get('password')->getData();
            $confirmedPassword = $form->get('confirmedPassword')->getData();

            if ($password === $confirmedPassword) {
                $user->setPassword($passwordEncoder->encodePassword($user, $password));

                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();

                return $this->json($user, 201, [], [
                    'groups' => ['add'],
                ]);
            }
        }

        return $this->json($form->getErrors(true, false)->__toString(), 400);
    }

    /**
     * @Route("/avatar/{id}", name="avatar_add", methods={"POST"}, requirements={"id": "\d+"})
     */
    public function addAvatar(User $user, Request $request, AvatarUploader $avatarUploader, FileSystem $filesystem): Response
    {
        $this->denyAccessUnlessGranted('addAvatar', $user);

        $userId = $user->getId();

        $userAvatar = $user->getAvatar();

        if ($userAvatar != NULL) {
            $targetDirectory = $_ENV['AVATAR_PICTURE'];
            $path = $targetDirectory . '/' . $userAvatar;
            $filesystem->remove($path);
        }

        $uploadedFile = $request->files->get('avatar');

        $newFileName = $avatarUploader->upload($uploadedFile, $userId);

        $user->setAvatar($newFileName);

        $user->setUpdatedAt(new \DateTime());

        $this->getDoctrine()->getManager()->flush();

        return $this->json($user, 200, [], [
            'groups' => ['avatarAdd'],
        ]);
    }

    /**
     * @Route("/{id}", name="edit", methods={"PUT", "PATCH"}, requirements={"id": "\d+"})
     */
    public function edit(User $user, Request $request, UserPasswordEncoderInterface $passwordEncoder, CountryRepository $countryRepository, CityRepository $cityRepository): Response
    {
        $this->denyAccessUnlessGranted('edit', $user);

        $form = $this->createForm(UserEditType::class, $user, ['csrf_protection' => false]);

        $sentData = json_decode($request->getContent(), true);
        $form->submit($sentData);



        if ($form->isValid()) {
            //todo : clean this code
            $password = $form->get('password')->getData();

            $userAdress = $form->get('userAdress')->getData();

            if (!empty($userAdress)) {
                $city = $cityRepository->findByCity($userAdress[0]);
                $country = $countryRepository->findByCountry($userAdress[1]);

                if (!empty($city)) {
                    $user->setCities($city[0]);
                } else {
                    $city = new City();
                    $city->setName($userAdress[0]);
                    $city->setLongitude($userAdress[3]);
                    $city->setLatitude($userAdress[2]);
                    $city->setCountry($country[0]);
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($city);
                    $em->flush();
                    $user->setCities($city);
                }
            }

            if ($password !== null) {
                $confirmedPassword = $form->get('confirmedPassword')->getData();
                if ($password === $confirmedPassword) {
                    $user->setPassword($passwordEncoder->encodePassword($user, $confirmedPassword));
                } else {
                    return $this->json('the 2 passwords are differents', 404);
                }
            }
            $user->setUpdatedAt(new \DateTime());
            $this->getDoctrine()->getManager()->flush();

            return $this->json($user, 200, [], [
                'groups' => ['read'],
            ]);
        }
        return $this->json($form->getErrors(true, false)->__toString(), 400);
    }

    /**
     * @Route("/{id}", name="delete", methods={"DELETE"}, requirements={"id": "\d+"})
     */
    public function delete(User $user, Filesystem $filesystem): Response
    {
        $this->denyAccessUnlessGranted('delete', $user);

        $userAvatar = $user->getAvatar();

        if ($userAvatar != NULL) {
            $targetDirectory = $_ENV['AVATAR_PICTURE'];
            $path = $targetDirectory . '/' . $userAvatar;
            $filesystem->remove($path);
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();

        return $this->json(null, 204);
    }

    /**
     * @Route("/avatar/{id}", name="avatar_delete", methods={"DELETE"}, requirements={"id": "\d+"})
     */
    public function deleteAvatar(User $user, Filesystem $filesystem): Response
    {
        $this->denyAccessUnlessGranted('deleteAvatar', $user);

        $userAvatar = $user->getAvatar();

        if ($userAvatar != NULL) {
            $targetDirectory = $_ENV['AVATAR_PICTURE'];
            $path = $targetDirectory . '/' . $userAvatar;
            $filesystem->remove($path);

            $user->setAvatar(null);
            $this->getDoctrine()->getManager()->flush();

            return $this->json(null, 204);
        }

        return $this->json('No avatar found for this user', 404);
    }

    /**
     * @Route("/search", name="search", methods={"GET"})
     */
    public function search(CountryRepository $countryRepository, Request $request): Response
    {
        $countryParameter = trim($request->query->get('country'));

        $users = $countryRepository->findByCountry($countryParameter);

        if (empty($users)) {
            return $this->json('Country not found', 404);
        }
        return $this->json($users, 200, [], [
            'groups' => ['searchResults']
        ]);
    }
}
