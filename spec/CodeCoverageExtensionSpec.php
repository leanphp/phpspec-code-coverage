<?php

namespace spec\LeanPHP\PhpSpec\CodeCoverage;

use PhpSpec\ObjectBehavior;
use PhpSpec\ServiceContainer;
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
        $container = new ServiceContainer;
        $container->setParam('code_coverage', array());
        $this->load($container);

        $options = $container->get('code_coverage.options');
        expect($options['format'])->toBe(array('html'));
    }

    function it_should_transform_format_into_array()
    {
        $container = new ServiceContainer;
        $container->setParam('code_coverage', array('format' => 'html'));
        $this->load($container);

        $options = $container->get('code_coverage.options');
        expect($options['format'])->toBe(array('html'));
    }

    function it_should_use_singular_output()
    {
        $container = new ServiceContainer;
        $container->setParam('code_coverage', array('output' => 'test', 'format' => 'foo'));
        $this->load($container);

        $options = $container->get('code_coverage.options');
        expect($options['output'])->toBe(array('foo' => 'test'));
    }
}
