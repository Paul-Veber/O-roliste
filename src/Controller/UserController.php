<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\AddUserType;
use App\Form\EditPasswordType;
use App\Form\EditUserType;
use App\Service\ImageUploader;
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
     * @Route("profil", name="profil")
     */
    public function profil(): Response
    {
        $user = $this->getUser();

        return $this->render('user/profil.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("{id}", name="read", requirements={"id"="\d+"})
     */
    public function read(User $user): Response
    {
        return $this->render('user/viewuser.html.twig', [
            'users' => $user,
        ]);
    }

    /**
     * @Route("signin",name="signin")
     */
    public function add(Request $request, UserPasswordHasherInterface $encoder, ImageUploader $imageUploader)
    {
        $user = new User();

        $form = $this->createForm(AddUserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // password encoding
            $user->setPassword($encoder->hashPassword($user, $user->getPassword()));

            //upload avatar
            $newAvatarPicture = $imageUploader->upload($form, 'avatar');
            $user->setAvatar($newAvatarPicture);

            //add default avatar image if the field is empty
            if ($user->getAvatar() == null) {
                $user->setAvatar("default/avatar-default.svg");
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('user_profil');
        }

        return $this->render('user/signin.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("edit", name="edit")
     */
    public function edit(Request $request, ImageUploader $imageUploader)
    {
        $user = $this->getUser();

        $form = $this->createForm(EditUserType::class, $user);

        $form->handleRequest($request);


        //upload avatar

        $newAvatarPicture = $imageUploader->upload($form, 'avatar');
        if ($newAvatarPicture !== null) {
            $user->setAvatar($newAvatarPicture);
        }

        if ($form->isSubmitted() && $form->isValid()) {


            $user->setUpdatedAt(new \DateTime());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            $this->addFlash('success', 'Profil modifié.');

            return $this->redirectToRoute('user_profil');
        }

        return $this->render('user/edit.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
        ]);
    }

    /**
     * @Route("edit-password", name="edit-password")
     */
    public function editPassword(Request $request, UserPasswordHasherInterface $encoder)
    {
        $user = $this->getUser();

        $form = $this->createForm(EditPasswordType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user->setPassword($encoder->hashPassword($user, $user->getPassword()));

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();
            $this->addFlash('success', 'Mot de passe modifié.');

            return $this->redirectToRoute('user_profil');
        }

        return $this->render('user/editpassword.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
