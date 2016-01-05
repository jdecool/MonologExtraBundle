<?php

namespace JDecool\Bundle\MonologExtraBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/configuration.html}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('jdecool_monolog_extra');

        $this->addProcessorNode($rootNode);

        return $treeBuilder;
    }

    /**
     * Add container configuration for "processor" node
     *
     * @param ArrayNodeDefinition $node
     */
    private function addProcessorNode(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('processor')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('security')
                            ->addDefaultsIfNotSet()
                            ->beforeNormalization()
                                ->ifTrue()
                                ->then(function ($v) { return ['enable' => $v]; })
                            ->end()
                            ->children()
                                ->scalarNode('enable')->defaultFalse()->end()
                                ->scalarNode('env')->defaultNull()->end()
                            ->end()
                        ->end()
                        ->arrayNode('session')
                            ->addDefaultsIfNotSet()
                            ->beforeNormalization()
                                ->ifTrue()
                                ->then(function ($v) { return ['enable' => $v]; })
                            ->end()
                            ->children()
                                ->scalarNode('enable')->defaultFalse()->end()
                                ->scalarNode('env')->defaultNull()->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }
}
