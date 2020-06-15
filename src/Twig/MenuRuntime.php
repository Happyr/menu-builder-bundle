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
        if (null === $request) {
            return '';
        }

        $menuItems = $this->builder->getMenu($name, $options);

        return $twig->render($options['template'] ?? $this->defaultTemplate, [
            'menuItems' => $menuItems,
            'route' => $request->attributes->get('_route', ''),
            'options' => $options,
        ]);
    }
}
