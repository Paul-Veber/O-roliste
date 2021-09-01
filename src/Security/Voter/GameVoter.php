<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class GameVoter extends Voter
{
    protected function supports(string $attribute, $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, ['GAME_EDIT', 'GAME_SECRETINFORMATION'])
            && $subject instanceof \App\Entity\Game;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case 'GAME_EDIT':
                if ($subject->getCreator()->getId() == $user->getId()) {
                    return true;
                    break;
                }
            case 'GAME_SECRETINFORMATION':
                if ($subject->getCreator() == $user || $subject->getGuests()->contains($user)) {
                    return true;
                    break;
                }
        }
        return false;
    }
}
