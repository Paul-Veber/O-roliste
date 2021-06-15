<?php

namespace App\Controller;

use App\Entity\Game;
use App\Form\GameType;
use App\Repository\GameRepository;
use App\Service\ImageUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/game", name="game_")
 */
class GameController extends AbstractController
{
    /**
     * @Route("", name="browse", methods={"GET"})
     */
    public function browse(GameRepository $gameRepository): Response
    {
        return $this->render('game/browse.html.twig', [
            'games' => $gameRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}", name="read", requirements={"id"="\d+"})
     */
    public function read(Game $game): Response
    {
        return $this->render('game/read.html.twig', [
            'game' => $game,
        ]);
    }

    /**
     * @Route("/add", name="add")
     */
    public function add(Request $request, ImageUploader $imageUploader): Response
    {
        $game = new Game();

        $form = $this->createForm(GameType::class, $game);
        
        // handleRequest prend les données en POST et les place dans $form puis dans $game
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()) {

            //upload avatar
            $newAvatarPicture = $imageUploader->upload($form, 'avatar');
            $game->setImage($newAvatarPicture);

            //add default avatar image if the field is empty
            if ($game->getImage() == null) {
                $game->setImage("default/avatar-default.svg");
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($game);
            $em->flush();

            return $this->redirectToRoute('game_browse');
        }

        return $this->render('game/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/edit/{id}", name="edit", requirements={"id"="\d+"})
     */
    public function edit(Game $game, Request $request): Response
    {

        $form = $this->createForm(GameType::class, $game);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('game_browse');
        }

        return $this->render('game/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete", requirements={"id"="\d+"}, methods={"DELETE"})
     */
    public function delete(Game $game, Request $request)
    {
        // Avant de supprimer $movie, on vérifie le token
        $token = $request->request->get('_token');
        if ($this->isCsrfTokenValid('deleteGame', $token)) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($game);
            $em->flush();

            return $this->redirectToRoute('game_browse');
        }

        // Si le token n'est pas valide, on lance une exception Access Denied
        throw $this->createAccessDeniedException('Le token n\'est pas valide.');
    }
}
