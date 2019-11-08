<?php

declare(strict_types=1);

namespace spec\FriendsOfPhpSpec\PhpSpec\CodeCoverage;

use Exception;
use FriendsOfPhpSpec\PhpSpec\CodeCoverage\CodeCoverageExtension;
use PhpSpec\ObjectBehavior;
use PhpSpec\ServiceContainer\IndexedServiceContainer;

/**
 * @author Henrik Bjornskov
 */
class CodeCoverageExtensionSpec extends ObjectBehavior
{
    public function it_is_initializable(): void
    {
        $this->shouldHaveType(CodeCoverageExtension::class);
    }

    public function it_should_transform_format_into_array(): void
    {
        $container = new IndexedServiceContainer();
        $container->setParam('code_coverage', ['format' => 'html']);
        $this->load($container);

        $options = $container->get('code_coverage.options');

        if ($options['format'] !== ['html']) {
            throw new Exception('Default format is not transformed to an array');
        }
    }

    public function it_should_use_html_format_by_default(): void
    {
        $container = new IndexedServiceContainer();
        $this->load($container, []);

        $options = $container->get('code_coverage.options');

        if ($options['format'] !== ['html']) {
            throw new Exception('Default format is not html');
        }
    }

    public function it_should_use_singular_output(): void
    {
        $container = new IndexedServiceContainer();
        $container->setParam('code_coverage', ['output' => 'test', 'format' => 'foo']);
        $this->load($container);

        $options = $container->get('code_coverage.options');

        if (['foo' => 'test'] !== $options['output']) {
            throw new Exception('Default format is not singular output');
        }
    }
}
