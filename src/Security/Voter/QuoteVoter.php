<?php

namespace App\Security\Voter;

use App\Entity\Quote;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class QuoteVoter extends Voter
{
    const QUOTE_EDIT = 'QUOTE_EDIT';
    const QUOTE_DELETE = 'QUOTE_DELETE';

    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports($attribute, $subject)
    {
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::QUOTE_EDIT, self::QUOTE_DELETE])
        && $subject instanceof \App\Entity\Quote;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        $quote = $subject;
        if ($this->security->isGranted('ROLE_ADMIN')) {
            return true;
        }
        switch ($attribute) {
            case self::QUOTE_EDIT:
                return $this->canEdit($quote, $user);
            case self::QUOTE_DELETE:
                return $this->canDelete($quote, $user);
        }

        return false;
    }

    private function canEdit(Quote $quote, User $user)
    {
        return $user === $quote->getOwner();
    }

    private function canDelete(Quote $quote, User $user)
    {
        return $user === $quote->getOwner();
    }
}
