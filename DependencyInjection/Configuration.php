<?php

namespace Yoh\JasperReportBundle\DependencyInjection;

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
        $rootNode = $treeBuilder->root('yoh_jasper_report');

        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.
        $rootNode
            ->children()
            ->scalarNode('jrs_host')->end()
            ->scalarNode('jrs_port')->end()
            ->scalarNode('jrs_base')->end()
            ->scalarNode('jrs_username')->end()
            ->scalarNode('jrs_password')->end()
            ->scalarNode('jrs_org_id')->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
