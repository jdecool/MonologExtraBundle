<?php

namespace JDecool\Bundle\MonologExtraBundle\Processor;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

class SessionProcessor
{
    /** @var SessionInterface */
    private $session;


    /**
     * Constructor
     *
     * @param SessionInterface $session
     */
    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    public function __invoke(array $record)
    {
        $record['extra']['session'] = $this->session->all();

        return $record;
    }
}
