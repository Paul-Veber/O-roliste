<?php

namespace App\Controller;

use App\Entity\Game;
use App\Form\SearchType;
use App\Repository\GameRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class SearchController extends AbstractController
{
    public function search(Request $request, GameRepository $gameRepository)
    {
        $result = [];
        $searchResult = new Game();
        $form = $this->createForm(SearchType::class, $searchResult, ['csrf_protection' => false]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            dd('test');
            $result = $gameRepository->search($searchResult->getName(), $searchResult->getCategory(), $searchResult->getTags());

            return $this->redirectToRoute('search/form.html.twig', [
                'form' => $form->createView(),
                'data' => $searchResult,
                'result' => $result
            ]);
        }

        return $this->render('form/searchForm.html.twig', [
            'form' => $form->createView(),
            'data' => $searchResult,
            'result' => $result
        ]);
    }

    /**
     * @Route("/search", name="search")
     *
     * @param Request $request
     * @return void
     */
    public function searchDisplay(Request $request)
    {
        return $this->render('search/form.html.twig',[
            'result' => $request,
        ]);
    }
}
