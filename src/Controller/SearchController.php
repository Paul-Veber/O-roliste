<?php

namespace App\Controller;

use App\Entity\Game;
use App\Form\SearchType;
use App\Repository\GameRepository;
use Doctrine\ORM\Query;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class SearchController extends AbstractController
{
    public function searchBar()
    {
        $searchResult = new Game();
        $form = $this->createForm(SearchType::class, $searchResult, [
            'csrf_protection' => false,
            'action' => $this->generateUrl('search')
        ]);
        return $this->render('form/searchForm.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/search", name="search" )
     *
     * @param Request $request
     */
    public function search(Request $request, GameRepository $gameRepository)
    {
        $formData = $request->query->get('search');
        $tags = $formData['tags'] ?? null;
        
        $category = !$formData['category'] ? null :  intval($formData['category']);
        //dd($tags, $category, $formData['name']);
        $searchResult = $gameRepository->search($formData['name'], $category, $tags);
        //$searchResult = $gameRepository->search('','2',null);
        return $this->render('search/form.html.twig', [
            //'form' => $form->createView(),
            //'data' => $searchResult,
            'formData' => $formData,
            'results' => $searchResult
        ]);
    }
}
