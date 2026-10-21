<?php

namespace ResqueBundle\Resque\Command;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * What FrameworkBundle's ContainerAwareCommand gave these commands, which Symfony 5.0 removes:
 * the kernel's container, set by the FrameworkBundle console application or taken from it.
 */
abstract class ContainerAwareCommand extends Command implements ContainerAwareInterface
{
    private $container;

    /**
     * @return ContainerInterface
     */
    protected function getContainer()
    {
        if (null === $this->container) {
            $application = $this->getApplication();
            if (!$application instanceof Application) {
                throw new \LogicException('The container cannot be retrieved as the application instance is not yet set.');
            }

            $this->container = $application->getKernel()->getContainer();
        }

        return $this->container;
    }

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
}
