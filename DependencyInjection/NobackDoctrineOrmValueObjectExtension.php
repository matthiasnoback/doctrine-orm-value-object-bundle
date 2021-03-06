<?php

namespace Noback\Bundle\DoctrineOrmValueObjectBundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;

class NobackDoctrineOrmValueObjectExtension extends Extension
{
    public function load(array $config, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.xml');

        $processedConfig = $this->processConfiguration(new Configuration(), $config);

        $cacheDirectory = $container->getParameterBag()->resolveValue($processedConfig['metadata_cache_dir']);
        $container->setParameter(
            'noback_doctrine_orm_value_object.cache_dir',
            $cacheDirectory
        );

        if (!is_dir($cacheDirectory)) {
            mkdir($cacheDirectory, 0777, true);
        }
    }
}
