<?php

declare(strict_types=1);

namespace spec\LeanPHP\PhpSpec\CodeCoverage\Exception;

use LeanPHP\PhpSpec\CodeCoverage\Exception\NoCoverageDriverAvailableException;
use PhpSpec\ObjectBehavior;

/**
 * @author Stéphane Hulard
 */
class NoCoverageDriverAvailableExceptionSpec extends ObjectBehavior
{
    public function it_is_initializable(): void
    {
        $this->shouldBeAnInstanceOf(\RuntimeException::class);
        $this->shouldHaveType(NoCoverageDriverAvailableException::class);
    }
}
