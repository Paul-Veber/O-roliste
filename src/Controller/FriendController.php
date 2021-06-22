<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
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
    public function index(UserRepository $userRepository, User $user): Response
    {
        $friends = $userRepository->findByUserId($user->getId());
        $idUser=$user->getId();

        return $this->render('friend/index.html.twig', [
            'friends' => $friends,
            'idUser' => $idUser
        ]);
    }

}
