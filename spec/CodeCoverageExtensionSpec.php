<?php

namespace spec\LeanPHP\PhpSpec\CodeCoverage;

use PhpSpec\ObjectBehavior;
use PhpSpec\ServiceContainer\IndexedServiceContainer;
use Prophecy\Argument;

/**
 * @author Henrik Bjornskov
 */
class CodeCoverageExtensionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('LeanPHP\PhpSpec\CodeCoverage\CodeCoverageExtension');
    }

    function it_should_use_html_format_by_default()
    {
        $container = new IndexedServiceContainer;
        $this->load($container, []);

        $options = $container->get('code_coverage.options');
        if ($options['format'] !== ['html']) {
            throw new Exception("Default format is not html");
        }
    }

    function it_should_transform_format_into_array()
    {
        $container = new IndexedServiceContainer;
        $container->setParam('code_coverage', array('format' => 'html'));
        $this->load($container);

        $options = $container->get('code_coverage.options');
        if ($options['format'] !== ['html']) {
            throw new Exception("Default format is not transformed to an array");
        }

    }

    function it_should_use_singular_output()
    {
        $container = new IndexedServiceContainer;
        $container->setParam('code_coverage', array('output' => 'test', 'format' => 'foo'));
        $this->load($container);

        $options = $container->get('code_coverage.options');
        if ($options['output'] !== ['foo' => 'test']) {
            throw new Exception("Default format is not singular output");
        }


    }
}
