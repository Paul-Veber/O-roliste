<?php

namespace App\Controller;

use App\Entity\Game;
use App\Entity\GameMessage;
use App\Entity\User;
use App\Form\GameMessageType;
use App\Repository\GameMessageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/game/{id}/message", name="game_message_")
 */
class GameMessageController extends AbstractController
{
    /**
     * @Route("", name="list")
     */
    public function list(GameMessage $gameMessage): Response
    {
        return $this->render('game_message/list.html.twig', [
            'game_message' => $gameMessage,
        ]);
    }

    /**
     * @Route("/new", name="new")
     */
    public function new(Request $request,Game $game): Response
    {
        $gameMessage = new GameMessage();
        $form = $this->createForm(GameMessageType::class, $gameMessage);
        $form->handleRequest($request);

        //set current User into user.id in entity GameMessage
        $gameMessage->setUser($this->getUser());

        //set current Game into game.id in entity GameMessage
        $gameMessage->setGame($game);
        
        if ($form->isSubmitted() && $form->isValid()) {
            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($gameMessage);
            $entityManager->flush();

            return $this->redirectToRoute('game_browse');
        }

        return $this->render('game_message/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit")
     */

     /*
    public function edit(Request $request, GameMessage $gameMessage): Response
    {
        $form = $this->createForm(GameMessageType::class, $gameMessage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('game_message_index');
        }

        return $this->render('game_message/edit.html.twig', [
            'game_message' => $gameMessage,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="delete")
     */

     /*
    public function delete(Request $request, GameMessage $gameMessage): Response
    {
        if ($this->isCsrfTokenValid('delete'.$gameMessage->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($gameMessage);
            $entityManager->flush();
        }

        return $this->redirectToRoute('game_message_index');
    }*/
}
