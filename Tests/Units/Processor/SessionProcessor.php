<?php

namespace JDecool\Bundle\MonologExtraBundle\Tests\Units\Processor;

use atoum;

class SessionProcessor extends atoum
{
    public function testInvoke()
    {
        $this
            ->given(
                $expected = ['foo' => 'bar', 'john' => 'doe'],
                $session = new \mock\Symfony\Component\HttpFoundation\Session\SessionInterface(),
                $session->getMockController()->all = function() use ($expected) { return $expected; }
            )
            ->if($this->newTestedInstance($session))
            ->then
                ->array($this->testedInstance->__invoke([]))
                ->isEqualTo([
                    'extra' => ['session' => $expected]
                ])
        ;
    }
}
