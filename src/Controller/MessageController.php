<?php

namespace App\Controller;

use App\Entity\MessageUser;
use App\Entity\Conversation;
use App\Repository\MessageUserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/conversation/{id}/message", name="user_message_", requirements={"id": "\d+"})
 */
class MessageController extends AbstractController
{
    /**
     * @Route("", name="browse")
     *
     * @return Response
     */
    public function index(): Response
    {
        return $this->render('message/index.html.twig', [
            'controller_name' => 'MessageController',
        ]);
    }

    /**
     * @Route("/new_message", name="newMessage")
     */
    public function newMessage(Request $request, Conversation $conversation)
    {
        $formData = $request->query->get('newMessage');

        $conversationId = $conversation->getId();

        $newMessage = new MessageUser;
        $newMessage->setBody($formData["body"]);
        $newMessage->setConversation($conversationId);
        $newMessage->setUser($this->getUser());

        $em = $this->getDoctrine()->getManager();
        $em->persist($newMessage);
        $em->flush();

        return $this->redirectToRoute('conversation_read', ['id' => $conversationId]);
    }

    
}
