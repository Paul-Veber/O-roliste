<?php

namespace App\Controller;

use App\Entity\Game;
use App\Form\SearchType;
use App\Repository\CategoryRepository;
use App\Repository\GameRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class SearchController extends AbstractController
{
    /**
     * @Route("/search", name="search")
     */
    public function searchForm(Request $request, GameRepository $gameRepository)
    {
        $result = [];
        $searchResult = new Game();
        $form = $this->createForm(SearchType::class, $searchResult);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $result = $gameRepository->search($searchResult->getName(), $searchResult->getCategory(), $searchResult->getTags());
        }

        return $this->render('search/form.html.twig', [
            'form' => $form->createView(),
            'data' => $searchResult,
            'result' => $result
        ]);
    }
}
