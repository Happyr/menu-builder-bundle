<?php

namespace Happyr\MenuBuilderBundle;

use Happyr\MenuBuilderBundle\Model\MenuItem;

interface MenuBuilder
{
    /**
     * @return array<MenuItem>
     */
    public function getMenu(string $name, array $options): array;
}
