<?php
/**
 * This file is part of the leanphp/phpspec-code-coverage package
 *
 * For the full copyright and license information, please see the LICENSE file
 * that was distributed with this source code.
 *
 * @license MIT
 */
namespace LeanPHP\PhpSpec\CodeCoverage\Listener;

use PhpSpec\Console\ConsoleIO;
use PhpSpec\Event\ExampleEvent;
use PhpSpec\Event\SuiteEvent;
use SebastianBergmann\CodeCoverage\CodeCoverage;
use SebastianBergmann\CodeCoverage\Report;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * @author Henrik Bjornskov
 */
class CodeCoverageListener implements EventSubscriberInterface
{
    private $coverage;
    private $reports;
    private $io;
    private $options;
    private $enabled;

    /**
     * @param ConsoleIO    $io
     * @param CodeCoverage $coverage
     * @param []           $reports
     * @param boolean      $skipCoverage
     */
    public function __construct(ConsoleIO $io, CodeCoverage $coverage, array $reports, $skipCoverage = false)
    {
        $this->io = $io;
        $this->coverage = $coverage;
        $this->reports  = $reports;
        $this->options  = array(
            'whitelist' => array('src', 'lib'),
            'blacklist' => array('test', 'vendor', 'spec'),
            'whitelist_files' => array(),
            'blacklist_files' => array(),
            'output'    => array('html' => 'coverage'),
            'format'    => array('html'),
        );

        $this->enabled = !$skipCoverage && (extension_loaded('xdebug') || (PHP_SAPI === 'phpdbg'));
    }

    /**
     * Note: We use array_map() instead of array_walk() because the latter expects
     * the callback to take the value as the first and the index as the seconds parameter.
     *
     * @param SuiteEvent $event
     */
    public function beforeSuite(SuiteEvent $event)
    {
        if (!$this->enabled) {
            return;
        }

        $filter = $this->coverage->filter();

        array_map(
            [$filter, 'addDirectoryToWhitelist'],
            $this->options['whitelist']
        );
        array_map(
            [$filter, 'removeDirectoryFromWhitelist'],
            $this->options['blacklist']
        );
        array_map(
            [$filter, 'addFileToWhitelist'],
            $this->options['whitelist_files']
        );
        array_map(
            [$filter, 'removeFileFromWhitelist'],
            $this->options['blacklist_files']
        );
    }

    /**
     * @param ExampleEvent $event
     */
    public function beforeExample(ExampleEvent $event)
    {
        if (!$this->enabled) {
            return;
        }

        $example = $event->getExample();

        $name = strtr('%spec%::%example%', array(
            '%spec%' => $example->getSpecification()->getClassReflection()->getName(),
            '%example%' => $example->getFunctionReflection()->getName(),
        ));

        $this->coverage->start($name);
    }

    /**
     * @param ExampleEvent $event
     */
    public function afterExample(ExampleEvent $event)
    {
        if (!$this->enabled) {
            return;
        }

        $this->coverage->stop();
    }

    /**
     * @param SuiteEvent $event
     */
    public function afterSuite(SuiteEvent $event)
    {
        if (!$this->enabled) {
            if ($this->io && $this->io->isVerbose()) {
                $this->io->writeln('Did not detect Xdebug extension or phpdbg. No code coverage will be generated.');
            }

            return;
        }

        if ($this->io && $this->io->isVerbose()) {
            $this->io->writeln('');
        }

        foreach ($this->reports as $format => $report) {
            if ($this->io && $this->io->isVerbose()) {
                $this->io->writeln(sprintf('Generating code coverage report in %s format ...', $format));
            }

            if ($report instanceof Report\Text) {
                $output = $report->process($this->coverage, /* showColors */ $this->io->isDecorated());
                $this->io->writeln($output);
            } else {
                $report->process($this->coverage, $this->options['output'][$format]);
            }
        }
    }

    /**
     * @param [] $options
     */
    public function setOptions(array $options)
    {
        $this->options = $options + $this->options;
    }

    /**
     * {@inheritDoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            'beforeExample' => array('beforeExample', -10),
            'afterExample'  => array('afterExample', -10),
            'beforeSuite'   => array('beforeSuite', -10),
            'afterSuite'    => array('afterSuite', -10),
        );
    }
}
