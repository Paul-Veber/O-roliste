<?php

namespace App\Controller;

use App\Entity\Game;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\GameRepository;
use App\Repository\UserRepository;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="main")
     */
    public function index(GameRepository $gameRepository, UserRepository $userRepository): Response
    {

        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
            'gamesFive' => $gameRepository->findBy([], [], 5),
            'usersFive' => $userRepository->findBy([], [], 5)
        ]);
    }
}
