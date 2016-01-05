<?php

namespace JDecool\Bundle\MonologExtraBundle\Tests\Units\Processor;

use atoum;

class SecurityProcessor extends atoum
{
    public function testInvoke()
    {
        $this
            ->given(
                $tokenStorage = new \mock\Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface(),
                $tokenStorage->getMockController()->getToken = function() { return null; }
            )
            ->if($this->newTestedInstance($tokenStorage))
            ->then
                ->array($this->testedInstance->__invoke([]))
                    ->isEmpty()
                ->array($this->testedInstance->__invoke(['foo' => 'bar']))
                    ->isEqualTo(['foo' => 'bar'])


            ->given(
                $token = new \mock\Symfony\Component\Security\Core\Authentication\Token\TokenInterface(),
                $token->getMockController()->getUser = function() { return null; },
                $tokenStorage = new \mock\Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface(),
                $tokenStorage->getMockController()->getToken = function() use ($token) { return $token; }
            )
            ->if($this->newTestedInstance($tokenStorage))
            ->then
                ->array($this->testedInstance->__invoke([]))
                    ->isEmpty()
                ->array($this->testedInstance->__invoke(['foo' => 'bar']))
                    ->isEqualTo(['foo' => 'bar'])

            ->given(
                $user = new \mock\Symfony\Component\Security\Core\User\UserInterface(),
                $user->getMockController()->getUsername = function() { return 'john.doe'; },
                $user->getMockController()->getRoles = function() { return 'ROLE_USER'; },
                $token = new \mock\Symfony\Component\Security\Core\Authentication\Token\TokenInterface(),
                $token->getMockController()->getUser = function() use ($user) { return $user; },
                $tokenStorage = new \mock\Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface(),
                $tokenStorage->getMockController()->getToken = function() use ($token) { return $token; }
            )
            ->if($this->newTestedInstance($tokenStorage))
            ->then
                ->array($this->testedInstance->__invoke([]))
                    ->isEqualTo(['extra' => [
                        'user' => [
                            'username' => 'john.doe',
                            'roles'    => 'ROLE_USER',
                        ],
                    ]])
                ->array($this->testedInstance->__invoke(['foo' => 'bar']))
                    ->isEqualTo([
                        'foo'   => 'bar',
                        'extra' => [
                            'user' => [
                                'username' => 'john.doe',
                                'roles'    => 'ROLE_USER',
                            ],
                        ],
                    ])

            ->given(
                $user = new \mock\Symfony\Component\Security\Core\User\AdvancedUserInterface(),
                $user->getMockController()->getUsername = function() { return 'admin'; },
                $user->getMockController()->getRoles = function() { return ['ROLE_USER', 'ROLE_ADMIN']; },
                $user->getMockController()->isAccountNonExpired = function() { return true; },
                $user->getMockController()->isAccountNonLocked = function() { return false; },
                $user->getMockController()->isCredentialsNonExpired = function() {return true; },
                $user->getMockController()->isEnabled = function() {return false; },
                $token = new \mock\Symfony\Component\Security\Core\Authentication\Token\TokenInterface(),
                $token->getMockController()->getUser = function() use ($user) { return $user; },
                $tokenStorage = new \mock\Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface(),
                $tokenStorage->getMockController()->getToken = function() use ($token) { return $token; }
            )
            ->if($this->newTestedInstance($tokenStorage))
            ->then
                ->array($this->testedInstance->__invoke([]))
                    ->isEqualTo(['extra' => [
                        'user' => [
                            'username'                => 'admin',
                            'roles'                   => ['ROLE_USER', 'ROLE_ADMIN'],
                            'account_non_expired'     => true,
                            'account_non_locked'      => false,
                            'credentials_non_expired' => true,
                            'enable'                  => false,
                        ],
                    ]])
                ->array($this->testedInstance->__invoke(['foo' => 'bar']))
                    ->isEqualTo([
                        'foo'   => 'bar',
                        'extra' => [
                            'user' => [
                                'username'                => 'admin',
                                'roles'                   => ['ROLE_USER', 'ROLE_ADMIN'],
                                'account_non_expired'     => true,
                                'account_non_locked'      => false,
                                'credentials_non_expired' => true,
                                'enable'                  => false,
                            ],
                        ],
                    ])
        ;
    }
}
