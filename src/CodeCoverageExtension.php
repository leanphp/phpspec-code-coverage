<?php
/**
 * This file is part of the leanphp/phpspec-code-coverage package
 *
 * @author ek9 <dev@ek9.co>
 *
 * @license MIT
 *
 * For the full copyright and license information, please see the LICENSE file
 * that was distributed with this source code.
 *
 */
namespace LeanPHP\PhpSpec\CodeCoverage;

use LeanPHP\PhpSpec\CodeCoverage\Listener\CodeCoverageListener;
use PhpSpec\Extension;
use PhpSpec\ServiceContainer;
use SebastianBergmann\CodeCoverage\CodeCoverage;
use SebastianBergmann\CodeCoverage\Filter;
use SebastianBergmann\CodeCoverage\Report;
use SebastianBergmann\CodeCoverage\Version;
use Symfony\Component\Console\Input\InputOption;

/**
 * Injects Code Coverage Event Subscriber into the EventDispatcher.
 * The Subscriber will add Code Coverage information before each example
 *
 * @author Henrik Bjornskov
 */
class CodeCoverageExtension implements Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(ServiceContainer $container, array $params = [])
    {
        foreach ($container->getByTag('console.commands') as $command) {
            $command->addOption('no-coverage', null, InputOption::VALUE_NONE, 'Skip code coverage generation');
        }

        $container->define('code_coverage.filter', function () {
            return new Filter();
        });

        $container->define('code_coverage', function ($container) {
            return new CodeCoverage(null, $container->get('code_coverage.filter'));
        });

        $container->define('code_coverage.options', function ($container) use ($params) {
            $options = !empty($params) ? $params : $container->getParam('code_coverage');

            if (!isset($options['format'])) {
                $options['format'] = array('html');
            } elseif (!is_array($options['format'])) {
                $options['format'] = (array) $options['format'];
            }

            if (isset($options['output'])) {
                if (!is_array($options['output']) && count($options['format']) === 1) {
                    $format = $options['format'][0];
                    $options['output'] = array($format => $options['output']);
                }
            }

            if (!isset($options['show_uncovered_files'])) {
                $options['show_uncovered_files'] = true;
            }
            if (!isset($options['lower_upper_bound'])) {
                $options['lower_upper_bound'] = 35;
            }
            if (!isset($options['high_lower_bound'])) {
                $options['high_lower_bound'] = 70;
            }

            return $options;
        });

        $container->define('code_coverage.reports', function ($container) {
            $options = $container->get('code_coverage.options');

            $reports = array();
            foreach ($options['format'] as $format) {
                switch ($format) {
                    case 'clover':
                        $reports['clover'] = new Report\Clover();
                        break;
                    case 'php':
                        $reports['php'] = new Report\PHP();
                        break;
                    case 'text':
                        $reports['text'] = new Report\Text(
                            $options['lower_upper_bound'],
                            $options['high_lower_bound'],
                            $options['show_uncovered_files'],
                            /* $showOnlySummary */ false
                        );
                        break;
                    case 'xml':
                        $reports['xml'] = new Report\Xml\Facade(Version::id());
                        break;
                    case 'crap4j':
                        $reports['crap4j'] = new Report\Crap4j();
                        break;
                    case 'html':
                        $reports['html'] = new Report\Html\Facade();
                        break;
                }
            }

            $container->setParam('code_coverage', $options);

            return $reports;
        });

        $container->define('event_dispatcher.listeners.code_coverage', function ($container) {

            $skipCoverage = false;
            $input = $container->get('console.input');
            if ($input->hasOption('no-coverage') && $input->getOption('no-coverage')) {
                $skipCoverage = true;
            }

            $listener = new CodeCoverageListener(
                $container->get('console.io'),
                $container->get('code_coverage'),
                $container->get('code_coverage.reports'),
                $skipCoverage
            );
            $listener->setOptions($container->getParam('code_coverage', array()));

            return $listener;
        }, ['event_dispatcher.listeners']);
    }
}
