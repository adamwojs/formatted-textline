<?php

declare(strict_types=1);

namespace AdamWojs\IbexaFormattedTextLineBundle;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class IbexaFormattedTextLineBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__ . '/Resources/config')
        );

        if ($container->hasExtension('ez_search_engine_solr')) {
            $loader->load('services_solr.yaml');
        }

        if ($container->hasExtension('ezplatform_elastic_search_engine')) {
            $loader->load('services_es.yaml');
        }
    }
}
