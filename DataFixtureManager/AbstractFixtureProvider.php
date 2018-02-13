<?php

declare(strict_types=1);

/*
 * Studio 107 (c) 2018 Maxim Falaleev
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mindy\Bundle\DataFixtureBundle\DataFixtureManager;

use ReflectionClass;

abstract class AbstractFixtureProvider implements FixtureProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function getBundleName(): string
    {
        $path = (new ReflectionClass(get_called_class()))->getFileName();
        $basePath = substr($path, 0, strrpos(strtolower($path), 'bundle') + 7);
        $files = glob(sprintf('%s/*Bundle.php', $basePath));
        $firstBundle = current($files);

        return pathinfo($firstBundle, PATHINFO_FILENAME);
    }

    /**
     * {@inheritdoc}
     */
    public function getPriority()
    {
        return 0;
    }
}
