<?php

namespace JDecool\Bundle\MonologExtraBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class JDecoolMonologExtraBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function getContainerExtension()
    {
        if (null === $this->extension) {
            $this->extension = $this->createContainerExtension();
        }

        if ($this->extension) {
            return $this->extension;
        }
    }
}
