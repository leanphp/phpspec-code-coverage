<?php

/**
 * This file is part of the friends-of-phpspec/phpspec-code-coverage package.
 *
 * @author  shulard <s.hulard@chstudio.fr>
 * @license MIT
 *
 * For the full copyright and license information, please see the LICENSE file
 * that was distributed with this source code.
 */

declare(strict_types=1);

use FriendsOfPhpSpec\PhpSpec\CodeCoverage\CodeCoverageExtension;

class_alias(
    CodeCoverageExtension::class,
    'LeanPHP\PhpSpec\CodeCoverage\CodeCoverageExtension'
);
