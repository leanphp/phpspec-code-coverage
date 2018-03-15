<?php

namespace LeanPHP\PhpSpec\CodeCoverage\Listener;

use PhpSpec\Console\ConsoleIO;
use PhpSpec\Event\SuiteEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * @author Danny Lewis
 */
class NoCodeCoverageListener implements EventSubscriberInterface
{
    private $io;

    public function __construct(ConsoleIO $io)
    {
        $this->io = $io;
    }

    public function showDisabledMessage(SuiteEvent $event)
    {
        $this->io->writeln('Code coverage is disabled, enable with "coverage" flag. e.g. bin/phpspec run --coverage');
    }

    /**
     * {@inheritDoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            'beforeSuite'   => array('showDisabledMessage', -10),
            'afterSuite'    => array('showDisabledMessage', -10),
        );
    }
}
