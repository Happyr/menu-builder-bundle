<?php

declare(strict_types=1);

namespace Happyr\MenuBuilderBundle\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
final class MenuExtension extends AbstractExtension
{
    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return [
            new TwigFunction('render_menu', [MenuRuntime::class, 'renderMenu'], [
                'needs_environment' => true,
                'is_safe' => ['html'],
            ]),
        ];
    }
}
