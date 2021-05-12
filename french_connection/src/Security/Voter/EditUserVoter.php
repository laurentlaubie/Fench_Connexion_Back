<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class EditUserVoter extends Voter
{
    protected function supports(string $attribute, $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, ['edit', 'delete', 'addAvatar', 'deleteAvatar'])
            && $subject instanceof \App\Entity\User;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        //dd($token->getUser());
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case 'edit':
                if ($subject === $user) {
                    return true;
                }
                if (in_array($user->getUsername(), ['IS_AUTHENTICATED_FULLY'])) {
                    return true;
                }
                break;
            case 'delete':
                if ($subject === $user) {
                    return true;
                }
                if (in_array($user->getUsername(), ['IS_AUTHENTICATED_FULLY'])) {
                    return true;
                }
                break;
            case 'addAvatar':
                if ($subject === $user) {
                    return true;
                }
                if (in_array($user->getUsername(), ['IS_AUTHENTICATED_FULLY'])) {
                    return true;
                }
                break;
            case 'deleteAvatar':
                if ($subject === $user) {
                    return true;
                }
                if (in_array($user->getUsername(), ['IS_AUTHENTICATED_FULLY'])) {
                    return true;
                }
                break;
        }

        return false;
    }
}
