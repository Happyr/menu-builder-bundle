<?php

declare(strict_types=1);

namespace Happyr\MenuBuilderBundle\Twig;

use Happyr\MenuBuilderBundle\MenuBuilder;
use Happyr\MenuBuilderBundle\Model\MenuItem;
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
        $menuItems = $this->builder->getMenu($name, $options);

        $request = $this->requestStack->getMasterRequest();
        $route = null;
        if (null !== $request) {
            $route = $request->attributes->get('_route', null);
            $this->markAsActive($menuItems, $route);
        }

        return $twig->render($options['template'] ?? $this->defaultTemplate, [
            'menuItems' => $menuItems,
            'route' => $route,
            'options' => $options,
        ]);
    }

    /**
     * @param MenuItem[] $menuItems
     * @param string|null $route
     * @return bool
     */
    private function markAsActive(array $menuItems, ?string $route): bool
    {
        if ($route === null) {
            return false;
        }

        $returnValue = false;
        foreach ($menuItems as $item) {
            if ($route === $item->getRoute() || ($item->hasChildren() && $this->markAsActive($item->getChildren(), $route))) {
                $item->setActive(true);
                $returnValue = true;
            }
        }

        return $returnValue;
    }
}
