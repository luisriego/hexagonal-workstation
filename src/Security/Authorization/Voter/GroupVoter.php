<?php

declare(strict_types=1);

namespace App\Security\Authorization\Voter;

use App\Entity\Condo;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class GroupVoter extends Voter
{
    public final const CONDO_READ = 'CONDO_READ';
    public final const CONDO_CREATE = 'CONDO_CREATE';
    public final const CONDO_UPDATE = 'CONDO_UPDATE';
    public final const CONDO_DELETE = 'CONDO_DELETE';

    protected function supports(string $attribute, $subject): bool
    {
        return \in_array($attribute, $this->supportedAttributes(), true);
    }

    /**
     * @param Condo|null $subject
     */
    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token)
    {
        if (self::CONDO_CREATE === $attribute) {
            return true;
        }

        if (\in_array($attribute, [self::CONDO_READ, self::CONDO_UPDATE, self::CONDO_DELETE], true)) {
            return $subject->containsUser($token->getUser());
        }

        return false;
    }

    private function supportedAttributes(): array
    {
        return [
            self::CONDO_READ,
            self::CONDO_CREATE,
            self::CONDO_UPDATE,
            self::CONDO_DELETE,
        ];
    }
}
