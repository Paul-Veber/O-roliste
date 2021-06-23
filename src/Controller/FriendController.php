<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\AddFriendType;
use App\Form\AddUserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/friend", name="friend_")
 */
class FriendController extends AbstractController
{
    /**
     * @Route("/{id}", name="read", requirements={"id"="\d+"})
     */
    public function read(UserRepository $userRepository, User $user): Response
    {
        $friends = $userRepository->findByUserId($user->getId());
        $idUser=$user->getId();

        return $this->render('friend/read.html.twig', [
            'friends' => $friends,
            'idUser' => $idUser,
            'user' => $user
        ]);
    }

    /**
     * @Route("/add/{id}", name="add", requirements={"id"="\d+"})
     */
    public function add(Request $request, User $user, UserRepository $userRepository)
        {
        $friends = new User;

        $form = $this->createForm(AddFriendType::class, $friends);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $friends = $friends->getMyfriends()[0];

            $user->addMyfriend($friends);
            $friends->addFriendsWithMe($user);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($friends);
            $entityManager->persist($user);
            $entityManager->flush();

            $id = $user->getId();
            return $this->redirectToRoute('friend_read' ,['id'=>$id]);
        }

        return $this->render('friend/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

     /**
     * @Route("/delete/{id}", name="delete", requirements={"id"="\d+"})
     */
    public function delete(Request $request, User $user): Response
    {
        $friends = new User;
        if ($this->isCsrfTokenValid('delete'.$user->removeFriendsWithMe($user), $request->request->get('_token'))) {

            $friends = $friends->getMyfriends()[0];

            $user->removeMyfriend($friends);
            $friends->removeFriendsWithMe($user);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($friends);
            $entityManager->flush();
        }
        $id = $user->getId();
        return $this->redirectToRoute('friend_read' ,['id'=>$id]);
    }
}
