<?php

namespace App\Controller;

use App\Entity\Game;
use App\Entity\GameMessage;
use App\Form\GameMessageType;
use App\Repository\GameMessageRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/game/{id}/message", name="game_message_", requirements={"id": "\d+"})
 *  */
class GameMessageController extends AbstractController
{
    /**
     * @Route("", name="list")
     */
    public function list(GameMessageRepository $gameMessageRepository, Game $game): Response
    {
        //take all the message per id
          $gameMessages = $gameMessageRepository->findByGameId($game->getId());
          $idGame=$game->getId();

        return $this->render('game_message/list.html.twig', [
            'idGame'=> $idGame,
            'gameMessages' => $gameMessages,
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

            $id=$gameMessage->getGame()->getId();
            return $this->redirectToRoute('game_message_list',['id'=>$id]);
        }

        return $this->render('game_message/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/edit/{idMessage}", name="edit", requirements={"idMessage": "\d+"})
     * @ParamConverter("gameMessage", options={"id"="idMessage"})
     */     
    public function edit(Request $request, GameMessage $gameMessage): Response
    {
        $form = $this->createForm(GameMessageType::class, $gameMessage);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {

            $gameMessage->setUpdatedAt(new \DateTime());
            $this->getDoctrine()->getManager()->flush();            
            
            $id=$gameMessage->getGame()->getId();
            return $this->redirectToRoute('game_message_list',['id'=>$id]);
        }

        return $this->render('game_message/edit.html.twig', [
            'gameMessage' => $gameMessage,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{idMessage}", name="delete", requirements={"idMessage": "\d+"})
     * @ParamConverter("gameMessage", options={"id"="idMessage"})
     */
    public function delete(Request $request, GameMessage $gameMessage): Response
    {
        if ($this->isCsrfTokenValid('delete'.$gameMessage->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($gameMessage);
            $entityManager->flush();
        }
        $id=$gameMessage->getGame()->getId();
        return $this->redirectToRoute('game_message_list',['id'=>$id]);
    }
}
