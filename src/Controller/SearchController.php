<?php

namespace App\Controller;

;
use App\Repository\CategoryRepository;
use App\Repository\GameRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SearchController extends AbstractController
{
    /**
     * @Route("/search", name="search")
     * */
    public function search(GameRepository $game, CategoryRepository $category): Response
    {

        return $this->render('search/index.html.twig', [
            'search' => $game->search('te', 5, [6])
        ]);
    }
}
