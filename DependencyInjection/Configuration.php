<?php

namespace Noback\Bundle\DoctrineOrmValueObjectBundle\DependencyInjection;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();

        $rootNode = $treeBuilder->root('noback_doctrine_orm_value_object');

        $rootNode
            ->children()
                ->scalarNode('metadata_cache_dir')
                    ->defaultValue('%kernel.cache_dir%/doctrine_orm_object_value')
                ->end()
            ->end();

        return $treeBuilder;
    }
}
