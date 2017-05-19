<?php

namespace Yoh\JasperReportBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * @link http://symfony.com/doc/current/cookbook/bundles/extension.html
 */
class YohJasperReportExtension extends Extension
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

        $reportClientDefinition = $container->getDefinition('yoh.jasper.report');

        $reportClientDefinition->addMethodCall('setJrsHost', array($config['jrs_host']));
        $reportClientDefinition->addMethodCall('setJrsPort', array($config['jrs_port']));
        $reportClientDefinition->addMethodCall('setJrsBase', array($config['jrs_base']));
        $reportClientDefinition->addMethodCall('setJrsUsername', array($config['jrs_username']));
        $reportClientDefinition->addMethodCall('setJrsPassword', array($config['jrs_password']));
        $reportClientDefinition->addMethodCall('setJrsOrgId', array($config['jrs_org_id']));

        $reportClientDefinition->addMethodCall('init');
    }
}
