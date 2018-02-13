<?php

declare(strict_types=1);

/*
 * Studio 107 (c) 2018 Maxim Falaleev
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mindy\Bundle\DataFixtureBundle\DataFixtureManager;

class Manager
{
    /**
     * @var array
     */
    protected $providers = [];

    /**
     * @param FixtureProviderInterface $provider
     */
    public function addFixtureProvider(FixtureProviderInterface $provider)
    {
        $this->providers[] = $provider;
    }

    /**
     * @return array
     */
    public function getFixtureProvider(): array
    {
        return $this->providers;
    }

    /**
     * @param string|null $bundle
     */
    public function process($bundle = null)
    {
        $providers = [];
        foreach ($this->providers as $provider) {
            if ($provider->getBundleName() === $bundle || null === $bundle) {
                $providers[] = $provider;
            }
        }

        usort($providers, function (FixtureProviderInterface $a, FixtureProviderInterface $b) {
            return $a->getPriority() > $b->getPriority();
        });

        foreach ($providers as $provider) {
            $provider->load();
        }
    }
}
