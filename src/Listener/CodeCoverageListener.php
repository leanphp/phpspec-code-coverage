<?php
/**
 * This file is part of the leanphp/phpspec-code-coverage package
 *
 * @author  ek9 <dev@ek9.co>
 *
 * @license MIT
 *
 * For the full copyright and license information, please see the LICENSE file
 * that was distributed with this source code.
 *
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
    private $skipCoverage;

    /**
     * @param ConsoleIO    $io
     * @param CodeCoverage $coverage
     * @param array        $reports
     * @param boolean      $skipCoverage
     */
    public function __construct(ConsoleIO $io, CodeCoverage $coverage, array $reports, $skipCoverage = false)
    {
        $this->io = $io;
        $this->coverage = $coverage;
        $this->reports  = $reports;
        $this->options  = [
            'whitelist' => ['src', 'lib'],
            'blacklist' => ['test', 'vendor', 'spec'],
            'whitelist_files' => [],
            'blacklist_files' => [],
            'output'    => ['html' => 'coverage'],
            'format'    => ['html'],
        ];

        $this->enabled = extension_loaded('xdebug') || (PHP_SAPI === 'phpdbg');
        $this->skipCoverage = $skipCoverage;
    }

    /**
     * Note: We use array_map() instead of array_walk() because the latter expects
     * the callback to take the value as the first and the index as the seconds parameter.
     *
     * @param SuiteEvent $event
     */
    public function beforeSuite(SuiteEvent $event) : void
    {
        if (!$this->enabled || $this->skipCoverage) {
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
    public function beforeExample(ExampleEvent $event): void
    {
        if (!$this->enabled || $this->skipCoverage) {
            return;
        }

        $example = $event->getExample();

        $name = strtr('%spec%::%example%', [
            '%spec%' => $example->getSpecification()->getClassReflection()->getName(),
            '%example%' => $example->getFunctionReflection()->getName(),
        ]);

        $this->coverage->start($name);
    }

    /**
     * @param ExampleEvent $event
     */
    public function afterExample(ExampleEvent $event): void
    {
        if (!$this->enabled || $this->skipCoverage) {
            return;
        }

        $this->coverage->stop();
    }

    /**
     * @param SuiteEvent $event
     */
    public function afterSuite(SuiteEvent $event): void
    {
        if (!$this->enabled || $this->skipCoverage) {
            if ($this->io && $this->io->isVerbose()) {
                if (!$this->enabled) {
                    $this->io->writeln('No code coverage will be generated as neither Xdebug nor phpdbg was detected.');
                } elseif ($this->skipCoverage) {
                    $this->io->writeln('Skipping code coverage generation');
                }
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
     * @param array $options
     */
    public function setOptions(array $options): void
    {
        $this->options = $options + $this->options;
    }

    /**
     * {@inheritDoc}
     */
    public static function getSubscribedEvents(): array
    {
        return [
            'beforeExample' => ['beforeExample', -10],
            'afterExample'  => ['afterExample', -10],
            'beforeSuite'   => ['beforeSuite', -10],
            'afterSuite'    => ['afterSuite', -10],
        ];
    }
}
