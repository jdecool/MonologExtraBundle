<?php

namespace JDecool\Bundle\MonologExtraBundle\Processor;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class SecurityProcessor
{
    /** @var TokenStorageInterface */
    private $tokenStorage;


    /**
     * Constructor
     *
     * @param TokenStorageInterface $tokenStorage
     */
    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    public function __invoke(array $record)
    {
        if (null === ($token = $this->tokenStorage->getToken())) {
            return $record;
        }

        if (null === ($user = $token->getUser())) {
            return $record;
        }

        if ($user instanceof AdvancedUserInterface) {
            $record['extra']['user'] = [
                'username'                => $user->getUsername(),
                'roles'                   => $user->getRoles(),
                'account_non_expired'     => $user->isAccountNonExpired(),
                'account_non_locked'      => $user->isAccountNonLocked(),
                'credentials_non_expired' => $user->isCredentialsNonExpired(),
                'enable'                  => $user->isEnabled(),
            ];
        } elseif ($user instanceof UserInterface) {
            $record['extra']['user'] = [
                'username' => $user->getUsername(),
                'roles'    => $user->getRoles(),
            ];
        }

        return $record;
    }
}
