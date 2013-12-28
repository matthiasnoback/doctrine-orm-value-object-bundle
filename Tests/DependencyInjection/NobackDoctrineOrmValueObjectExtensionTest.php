<?php

namespace Noback\Bundle\DoctrineOrmValueObjectBundle\Tests\DependencyInjection;

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;
use Matthias\SymfonyServiceDefinitionValidator\Compiler\ValidateServiceDefinitionsPass;
use Noback\Bundle\DoctrineOrmValueObjectBundle\DependencyInjection\NobackDoctrineOrmValueObjectExtension;
use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Symfony\Component\DependencyInjection\Definition;

class NobackDoctrineOrmValueObjectExtensionTest extends AbstractExtensionTestCase
{
    protected function getContainerExtensions()
    {
        return array(
            new NobackDoctrineOrmValueObjectExtension()
        );
    }

    /**
     * @test
     */
    public function it_configures_the_metadata_cache_dir()
    {
        $cacheDir = sys_get_temp_dir() . '/noback_doctrine_orm_value_object'.rand(1, 9999);

        $this->load(array('metadata_cache_dir' => $cacheDir));

        $this->assertTrue(is_dir($cacheDir));
        $this->assertContainerBuilderHasParameter('noback_doctrine_orm_value_object.cache_dir', $cacheDir);

        rmdir($cacheDir);
    }

    /**
     * @test
     */
    public function its_service_definitions_are_valid()
    {
        // prepare the container
        $this->container->setParameter('kernel.cache_dir', sys_get_temp_dir());

        $annotationReader = new Definition('Doctrine\Common\Annotations\AnnotationReader');
        $this->container->setDefinition('annotation_reader', $annotationReader);

        $this->container->addCompilerPass(new ValidateServiceDefinitionsPass(), PassConfig::TYPE_AFTER_REMOVING);

        $this->load();
        $this->compile();
    }
}
