<?php

namespace JDecool\Bundle\MonologExtraBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * @link http://symfony.com/doc/current/cookbook/bundles/extension.html
 */
class JDecoolMonologExtraExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        $env = $container->getParameter('kernel.environment');

        if ($this->isEnable($config['processor']['security'], $env)) {
            $service = $container->getDefinition('monolog.processor.sf_security');
            $service->addTag('monolog.processor');
        }

        if ($this->isEnable($config['processor']['session'], $env)) {
            $service = $container->getDefinition('monolog.processor.sf_session');
            $service->addTag('monolog.processor');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return 'jdecool_monolog_extra';
    }

    /**
     * Check if processosr is enable for current env
     *
     * @param array  $configs
     * @param string $env
     * @return bool
     */
    private function isEnable(array $configs, $env)
    {
        return $configs['enable'] && (null === $configs['env'] || $env === $configs['env']);
    }
}
