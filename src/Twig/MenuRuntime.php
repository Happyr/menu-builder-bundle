<?php

declare(strict_types=1);

namespace Happyr\MenuBuilderBundle\Twig;

use Happyr\MenuBuilderBundle\MenuBuilder;
use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Environment;
use Twig\Extension\RuntimeExtensionInterface;

/**
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
final class MenuRuntime implements RuntimeExtensionInterface
{
    private $requestStack;
    private $builder;
    private $defaultTemplate;

    public function __construct(RequestStack $requestStack, MenuBuilder $builder, string $defaultTemplate)
    {
        $this->requestStack = $requestStack;
        $this->builder = $builder;
        $this->defaultTemplate = $defaultTemplate;
    }

    public function renderMenu(Environment $twig, string $name, array $options = []): string
    {
        $request = $this->requestStack->getMasterRequest();
        $route = null;
        if (null !== $request) {
            $route = $request->attributes->get('_route', null);
        }

        $menuItems = $this->builder->getMenu($name, $options);

        return $twig->render($options['template'] ?? $this->defaultTemplate, [
            'menuItems' => $menuItems,
            'route' => $route,
            'options' => $options,
        ]);
    }
}
