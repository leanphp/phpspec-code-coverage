<?php

/**
 * This file is part of the friends-of-phpspec/phpspec-code-coverage package.
 *
 * @author  ek9 <dev@ek9.co>
 * @license MIT
 *
 * For the full copyright and license information, please see the LICENSE file
 * that was distributed with this source code.
 */

declare(strict_types=1);

namespace FriendsOfPhpSpec\PhpSpec\CodeCoverage\Listener;

use PhpSpec\Console\ConsoleIO;
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

    private $io;

    private $options;

    private $reports;

    private $skipCoverage;

    public function __construct(ConsoleIO $io, CodeCoverage $coverage, array $reports, bool $skipCoverage = false)
    {
        $this->io = $io;
        $this->coverage = $coverage;
        $this->reports = $reports;
        $this->options = [
            'whitelist' => ['src', 'lib'],
            'blacklist' => ['test', 'vendor', 'spec'],
            'whitelist_files' => [],
            'blacklist_files' => [],
            'output' => ['html' => 'coverage'],
            'format' => ['html'],
        ];

        $this->skipCoverage = $skipCoverage;
    }

    public function afterSuite(SuiteEvent $event): void
    {
        if ($this->skipCoverage) {
            if ($this->io && $this->io->isVerbose()) {
                $this->io->writeln('Skipping code coverage generation');
            }

            return;
        }

        if ($this->io && $this->io->isVerbose()) {
            $this->io->writeln();
        }

        foreach ($this->reports as $format => $report) {
            if ($this->io && $this->io->isVerbose()) {
                $this->io->writeln(sprintf('Generating code coverage report in %s format ...', $format));
            }

            if ($report instanceof Report\Text) {
                $this->io->writeln(
                    $report->process($this->coverage, $this->io->isDecorated())
                );
            } else {
                $report->process($this->coverage, $this->options['output'][$format]);
            }
        }
    }

    /**
     * Note: We use array_map() instead of array_walk() because the latter expects
     * the callback to take the value as the first and the index as the seconds parameter.
     *
     * @param SuiteEvent $event
     */
    public function beforeSuite(SuiteEvent $event): void
    {
        if ($this->skipCoverage) {
            return;
        }

        $filter = $this->coverage->filter();

        foreach ($this->options['whitelist'] as $option) {
            $filter->addDirectoryToWhitelist($option);
        }

        foreach ($this->options['blacklist'] as $option) {
            $filter->removeDirectoryFromWhitelist($option);
        }

        foreach ($this->options['whitelist_files'] as $option) {
            $filter->addFilesToWhitelist($option);
        }

        foreach ($this->options['blacklist_files'] as $option) {
            $filter->removeFileFromWhitelist($option);
        }
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents(): array
    {
        return [
            'beforeSuite' => ['beforeSuite', -10],
            'afterSuite' => ['afterSuite', -10],
        ];
    }

    public function setOptions(array $options): void
    {
        $this->options = $options + $this->options;
    }
}
