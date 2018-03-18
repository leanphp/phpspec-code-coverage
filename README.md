phpspec-code-coverage
=====================
[![License](https://img.shields.io/packagist/l/leanphp/phpspec-code-coverage.svg?style=flat-square)](#LICENSE)
[![Latest Stable Version](https://img.shields.io/packagist/v/leanphp/phpspec-code-coverage.svg?style=flat-square)](https://packagist.org/packages/leanphp/phpspec-code-coverage)
[![Total Downloads](https://img.shields.io/packagist/dt/leanphp/phpspec-code-coverage.svg?style=flat-square)](https://packagist.org/packages/leanphp/phpspec-code-coverage)
[![Travis](https://img.shields.io/travis/leanphp/phpspec-code-coverage.svg?style=flat-square)](https://travis-ci.org/leanphp/phpspec-code-coverage)
[![AppVeyor](https://img.shields.io/appveyor/ci/leanphp/phpspec-code-coverage/master.svg?style=flat-square)](https://ci.appveyor.com/project/leanphp/phpspec-code-coverage)

[phpspec-code-coverage][0] is a [PhpSpec][2] extension that generates Code
Coverage reports for [PhpSpec][2] tests.

Generating Code Coverage reports allows you to to analyze which parts of your
codebase are tested and how well. However, Code Coverage alone should NOT be
used as a single metric defining how good your tests are.

**Note!** This is a maintained fork of [henrikbjorn/phpspec-code-coverage][1]
package with compatible version numbers for stable releases.

![phpspec-code-coverage console report](https://i.imgur.com/BU10ZAV.png)
![phpspec-code-coverage HTML report](https://i.imgur.com/6xACR1g.png)

## Requirements

- PHP 7+ (for [PhpSpec][2] v4+) or PHP 5.6+ (for [PhpSpec][2] v3)
- [Xdebug][3] or [phpdbg][4] extension enabled (PHP 7+ is required for code
  generation to work with [phpdbg][4]).

## Change Log

Please see [CHANGELOG.md](CHANGELOG.md) for information on recent changes.

## Install

Install this package as a development dependency in your project:

    $ composer require --dev leanphp/phpspec-code-coverage

Enable extension by editing `phpspec.yml` of your project:

``` yaml
extensions:
  LeanPHP\PhpSpec\CodeCoverage\CodeCoverageExtension: ~
```

This will sufficient to enable Code Coverage generation by using defaults
provided by the extension. This extension supports various [configuration
options](#Options). For a fully annotated example configuration
file check [Configuration section](#Configuration).

## Usage

If you execute `phpspec run` command, you will see code coverage generated in `coverage` directory (in `html` format):

    $ bin/phpspec run

**Note!** When generating Code Coverage reports make sure PHP processes run via
CLI are not memory limited (i.e. `memory_limit` set to `-1` in
`/etc/php/cli/php.ini`).

### Running with phpdbg

This extension now supports [phpdbg][4], which results in faster execution when
using more recent versions of PHP. Run `phpspec` via [phpdbg][4]:

    $ phpdbg -qrr phpspec run

**Note!** PHP 7+ is required for code generation to work with [phpdbg][4].

## Configuration

You can see fully annotated `phpspec.yml` example file below, which can be used
as a starting point to further customize the defaults of the extension. The
configuration file below has all of the [Configuration Options](#Options).

```yaml
# phpspec.yml
# ...
extensions:
  # ... other extensions ...
  # leanphp/phpspec-code-coverage
  LeanPHP\PhpSpec\CodeCoverage\CodeCoverageExtension:
    # Specify a list of formats in which code coverage report should be
    # generated.
    # Default: [html]
    format:
      - text
      - html
      #- clover
      #- php
      #- xml
    #
    # Specify output file/directory where code coverage report will be
    # generated. You can configure different output file/directory per
    # enabled format.
    # Default: coverage
    output:
      html: coverage
      #clover: coverage.xml
      #php: coverage.php
      #xml: coverage
    #
    # Should uncovered files be included in the reports?
    # Default: true
    #show_uncovered_files: true
    #
    # Set lower upper bound for code coverage
    # Default: 35
    #lower_upper_bound: 35
    #
    # Set high lower bound for code coverage
    # Default: 70
    #high_lower_bound: 70
    #
    # Whilelist directories for which code generation should be done
    # Default: [src, lib]
    #
    whitelist:
      - src
      - lib
    #
    # Whiltelist files for which code generation should be done
    # Default: empty
    #whilelist_files:
      #- app/bootstrap.php
      #- web/index.php
    #
    # Blacklist directories for which code generation should NOT be done
    #blacklist:
      #- src/legacy
    #
    # Blacklist files for which code generation should NOT be done
    #blacklist_files:
      #- lib/bootstrap.php
```

### Options

* `format` (optional) a list of formats in which code coverage should be
  generated. Can be one or many of: `clover`, `php`, `text`, `html`, `xml` (default
  `html`)
  **Note**: When using `clover` format option, you have to configure specific
  `output` file for the `clover` format (see below).
* `output` (optional) sets an output file/directory where specific code
  coverage format will be generated. If you configure multiple formats, takes
  a hash of `format:output` (e.g. `clover:coverage.xml`) (default `coverage`)
* `show_uncovered_files` (optional) for including uncovered files in coverage
  reports (default `true`)
* `lower_upper_bound` (optional) sets lower upper bound for code coverage
  (default `35`).
* `high_lower_bound` (optional) sets high lower bound for code coverage
  (default `70`)
* `whitelist` takes an array of directories to whitelist (default: `lib`,
  `src`).
* `whitelist_files` takes an array of files to whitelist (default: none).
* `blacklist` takes an array of directories to blacklist (default: `test,
  vendor, spec`)
* `blacklist_files` takes an array of files to blacklist

## Authors

Copyright (c) 2017-2018 ek9 <dev@ek9.co> (https://ek9.co).

Copyright (c) 2013-2016 Henrik Bjornskov, for portions of code from
[henrikbjorn/phpspec-code-coverage][1] project.

## License

Licensed under [MIT License](LICENSE).

[0]: https://github.com/leanphp/phpspec-code-coverage
[1]: https://github.com/henrikbjorn/PhpSpecCodeCoverageExtension
[2]: http://www.phpspec.net/en/stable
[3]: https://xdebug.org/
[4]: http://phpdbg.com/

[travis-image]: https://travis-ci.org/leanphp/phpspec-code-coverage.svg
[travis-url]: https://travis-ci.org/leanphp/phpspec-code-coverage

