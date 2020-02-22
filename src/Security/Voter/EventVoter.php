<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class EventVoter extends Voter
{
    private $security;

    public function __construct(AccessDecisionManagerInterface $decisionManager, Security $security)
    {
        $this->decisionManager = $decisionManager;
        $this->security = $security;
    }

    protected function supports($attribute, $subject)
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, ['EVENT_EDIT', 'EVENT_DELETE'])
            && $subject instanceof \App\Entity\Event;
    }

    protected function voteOnAttribute($attribute, $event, TokenInterface $token)
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case 'EVENT_EDIT':
                return ($event->getAddedBy()->getId() == $user->getId())or($this->security->isGranted('ROLE_ADMIN'));
                break;
            case 'EVENT_DELETE':
                return ($event->getAddedBy()->getId() == $user->getId())or($this->security->isGranted('ROLE_ADMIN'));
                break;
        }

        return false;
    }
}
