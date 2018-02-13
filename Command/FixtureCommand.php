<?php

declare(strict_types=1);

/*
 * Studio 107 (c) 2018 Maxim Falaleev
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mindy\Bundle\DataFixtureBundle\Command;

use Mindy\Bundle\DataFixtureBundle\DataFixtureManager\Manager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpKernel\Bundle\BundleInterface;
use Symfony\Component\HttpKernel\KernelInterface;

class FixtureCommand extends Command
{
    protected static $defaultName = 'orm:fixture:load';

    /**
     * @var KernelInterface
     */
    protected $kernel;
    /**
     * @var Manager
     */
    protected $dataFixtureManager;

    /**
     * FixtureCommand constructor.
     *
     * @param KernelInterface $kernel
     * @param Manager         $dataFixtureManager
     * @param string|null     $name
     */
    public function __construct(
        KernelInterface $kernel,
        Manager $dataFixtureManager,
        string $name = null
    ) {
        $this->dataFixtureManager = $dataFixtureManager;
        $this->kernel = $kernel;
        parent::__construct($name);
    }

    protected function configure()
    {
        $this
            ->addOption('bundle', 'b', InputOption::VALUE_OPTIONAL, 'Bundle name');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $bundleName = $input->getOption('bundle');
        if (empty($bundleName)) {
            $bundles = $this->kernel->getBundles();
        } else {
            $bundles = [
                $this->kernel->getBundle($bundleName),
            ];
        }

        foreach ($bundles as $name => $bundle) {
            /** @var BundleInterface $bundle */
            $migrationPath = sprintf('%s/DataFixture', $bundle->getPath());
            if (false === is_dir($migrationPath)) {
                continue;
            }

            $this->dataFixtureManager->process($name);
        }
    }
}
