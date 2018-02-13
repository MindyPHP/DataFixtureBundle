<?php

declare(strict_types=1);

/*
 * Studio 107 (c) 2018 Maxim Falaleev
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mindy\Bundle\DataFixtureBundle\DataFixtureManager;

interface FixtureProviderInterface
{
    public function load();

    /**
     * @return string
     */
    public function getBundleName(): string;

    /**
     * @return int
     */
    public function getPriority();
}
