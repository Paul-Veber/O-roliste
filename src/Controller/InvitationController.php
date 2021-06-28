<?php

namespace App\Controller;

use App\Entity\Game;
use App\Entity\User;
use App\Repository\GameRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * @Route("/invitation", name="invitation_")
 */
class InvitationController extends AbstractController
{
    public function form(int $idUser)
    {

        $gameSelect = new User;

        $this->denyAccessUnlessGranted('ROLE_USER', $gameSelect);

        $form = $this->createFormBuilder($gameSelect, [
            'csrf_protection' => false,
            'action' => $this->generateUrl('invitation_add', ['id' => $idUser])
        ])
            ->add('creator', EntityType::class, [
                'class' => Game::class,
                'multiple' => true,
                'expanded' => false,
                'required' => false,
                'query_builder' => function (GameRepository $gameRepository) {
                    return $gameRepository->createQueryBuilder('g')
                        ->andWhere('g.creator IN (:id)')
                        ->setParameter('id', $this->getUser()->getId());
                }

            ])
            ->getForm();
    
            return $this->render('form/invitationForm.html.twig',[
                'form' => $form->createView()
            ]);
    }
    /**
     * @Route("/user/{id}", name="add", requirements={"id"="\d+"})
     *
     * @param Request $request
     * @param User $user
     * @return void
     */
    public function addGuest(Request $request, User $user, GameRepository $gameRepository)
    {
        $formData = $request->request->get('form')['creator'][0];
        $game = $gameRepository->find($formData);

        $game->addGuest($user);

        $this->getDoctrine()->getManager()->flush();

        $id = $game->getId();
        return $this->redirectToRoute('game_read', ['id' => $id]);
       
    }

    /**
     * @Route("/game/{id}/guest/delete/{idGuest}", name="delete", requirements={"idGuest": "\d+", "id": "\d+"} )
     * @ParamConverter("user", options={"id"="idGuest"})
     * 
     * @param User $user
     * @return void
     */
    public function delete(Game $game, User $user)
    {
        $game->removeGuest($user);

        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute('game_read', ['id' => $game->getId()]);
    }
}
