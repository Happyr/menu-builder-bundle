<?php

declare(strict_types=1);

namespace Happyr\MenuBuilderBundle\DependencyInjection;

use Happyr\MenuBuilderBundle\MenuBuilder;
use Happyr\MenuBuilderBundle\Twig\MenuExtension;
use Happyr\MenuBuilderBundle\Twig\MenuRuntime;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class HappyrMenuBuilderExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $def = $container->register(MenuExtension::class);
        $def->addTag('twig.extension');

        $def = $container->register(MenuRuntime::class);
        $def->setArguments([
            new Reference(RequestStack::class),
            new Reference(MenuBuilder::class),
            $config['template'],
        ]);
        $def->addTag('twig.runtime');
    }
}
