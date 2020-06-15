<?php

declare(strict_types=1);

namespace Happyr\MenuBuilderBundle\Model;

final class MenuItem
{
    /**
     * @var string
     */
    private $route;

    /**
     * @var array
     */
    private $routeParameters;

    /**
     * @var string
     */
    private $label;

    /**
     * Any additional parameters like icon.
     * @var array
     */
    private $extra;

    /**
     * @var array<MenuItem>
     */
    private $children;

    public function __construct(string $label, string $url, array $routeParameters = [])
    {
        $this->label = $label;
        $this->route = $url;
        $this->routeParameters = $routeParameters;
        $this->extra = [];
        $this->children = [];
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function getRoute(): string
    {
        return $this->route;
    }

    public function getRouteParameters(): array
    {
        return $this->routeParameters;
    }

    /**
     * @return mixed|null
     */
    public function getExtra(string $name, $default = null)
    {
        if (array_key_exists($name, $this->extra)) {
            return $this->extra;
        }

        return $default;
    }

    /**
     * @param mixed|null $value
     */
    public function addExtra(string $name, $value): void
    {
        $this->extra[$name] = $value;
    }

    /**
     * @return array<MenuItem>
     */
    public function getChildren(): array
    {
        return $this->children;
    }

    /**
     * @param array $children
     */
    public function setChildren(array $children): void
    {
        $this->children = $children;
    }

    public function addChild(MenuItem $menuItem)
    {
        $this->children[] = $menuItem;
    }
}
