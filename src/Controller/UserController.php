<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\AddUserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/user/", name="user_")
 */

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="index")
     */
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    /**
     * @Route("add",name="add")
     */
    public function add(Request $request, UserPasswordHasherInterface $encoder)
    {
        $user = new User();

        $form = $this->createForm(AddUserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // password encoding
            $user->setPassword($encoder->hashPassword($user, $user->getPassword()));

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('user_add');
        }

        return $this->render('user/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
