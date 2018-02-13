<?php

declare(strict_types=1);

/*
 * Studio 107 (c) 2018 Maxim Falaleev
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mindy\Bundle\DataFixtureBundle\DependencyInjection\Compiler;

use Mindy\Bundle\DataFixtureBundle\DataFixtureManager\FixtureProviderInterface;
use Mindy\Bundle\DataFixtureBundle\DataFixtureManager\Manager;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class DataFixtureCompilerPass implements CompilerPassInterface
{
    const TAG = 'data_fixture_provider';

    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (false === $container->hasDefinition(Manager::class)) {
            return;
        }

        $container
            ->registerForAutoconfiguration(FixtureProviderInterface::class)
            ->setPublic(true)
            ->addTag(self::TAG);

        $definition = $container->getDefinition(Manager::class);
        foreach ($container->findTaggedServiceIds(self::TAG) as $id => $params) {
            $definition->addMethodCall(
                'addFixtureProvider',
                [
                    new Reference($id),
                ]
            );
        }
    }
}
