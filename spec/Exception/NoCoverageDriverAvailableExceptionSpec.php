<?php

declare(strict_types=1);

namespace spec\FriendsOfPhpSpec\PhpSpec\CodeCoverage\Exception;

use FriendsOfPhpSpec\PhpSpec\CodeCoverage\Exception\NoCoverageDriverAvailableException;
use PhpSpec\ObjectBehavior;
use RuntimeException;

/**
 * @author Stéphane Hulard
 */
class NoCoverageDriverAvailableExceptionSpec extends ObjectBehavior
{
    public function it_is_initializable(): void
    {
        $this->shouldBeAnInstanceOf(RuntimeException::class);
        $this->shouldHaveType(NoCoverageDriverAvailableException::class);
    }
}
