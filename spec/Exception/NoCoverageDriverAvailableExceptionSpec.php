<?php

namespace spec\LeanPHP\PhpSpec\CodeCoverage\Exception;

use PhpSpec\ObjectBehavior;
use LeanPHP\PhpSpec\CodeCoverage\Exception\NoCoverageDriverAvailableException;

/**
 * @author Stéphane Hulard
 */
class NoCoverageDriverAvailableExceptionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldBeAnInstanceOf(\RuntimeException::class);
        $this->shouldHaveType(NoCoverageDriverAvailableException::class);
    }
}
