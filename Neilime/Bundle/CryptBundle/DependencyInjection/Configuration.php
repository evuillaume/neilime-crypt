<?php

namespace Neilime\Bundle\CryptBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('neilime_crypt');

        $this->addConfigSection($rootNode);

        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        return $treeBuilder;
    }

    /**
     * Extension is disabled by default
     *
     * @param ArrayNodeDefinition $node
     */
    private function addConfigSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
            ->booleanNode('enabled')->defaultFalse()
            ->end();
    }


}
