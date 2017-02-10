phpspec-code-coverage
=====================

[phpspec-code-coverage][0] is a [PhpSpec][2] extension that generates Code
Coverage reports for [PhpSpec][2] tests.

Generating Code Coverage reports allows you to to analyze which parts of your
codebase are tested and how well. However, Code Coverage alone should NOT be
used as a single metric defining how good your tests are.

**Note!** This is a maintained fork of [henrikbjorn/phpspec-code-coverage][1]
package with compatible version numbers for stable releases.

## Requirements

- PHP 5.3
- PHP [Xdebug][3] extension
- [PhpSpec v2][2]

## Install

Install this package as a development dependency in your project:

    $ composer require --dev leanphp/phpspec-code-coverage

Enable extension by editing `phpspec.yml` of your project:

``` yaml
extensions:
  - LeanPHP\PhpSpec\CodeCoverageExtension
```

This will sufficient to enable Code Coverage generation by using defaults
provided by the extension. If you execute `phpspec run` command, you will see
code coverage generated in `coverage` directory (in `html` format). This
extension supports various [configuration options](#Configuration Options). For
a fully annotated example configuration file check [Configuration
section](#Configuration).

## Configuration

You can see fully annotated `phpspec.yml` example file below, which can be used
as a starting point to further customize the defaults of the extension. The
configuration file below has all of the [Configuration Options](#Configuration
Options).

```yaml
# phpspec.yml
# ...
extensions:
  # ... other extensions ...
  # leanphp/phpspec-code-coverage
  - LeanPHP\PhpSpec\CodeCoverageExtension

# leanphp/phpspec-code-coverage
code_coverage:
  # Specify a list of formats in which code coverage report should be
  # generated.
  # Default: [html]
  format:
    - html
    #- clover
    #- php
    #- text
  #
  # Specify output file/directory where code coverage report will be
  # generated. You can configure different output file/directory per
  # enabled format.
  # Default: coverage
  output:
    html: coverage
    #clover: coverage.xml
    #php: coverage.php
    #text: coverage.txt
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

### Configuration Options

* `format` (optional) a list of formats in which code coverage should be
  generated. Can be one or many of: `clover`, `php`, `text`, `html` (default
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
* `blacklist` takes an array of directories to blacklist
* `blacklist_files` takes an array of files to blacklist

## Authors

Copyright (c) 2017 ek9 <dev@ek9.co> (https://ek9.co).
Copyright (c) 2013-2016 Henrik Bjornskov, for portions of code from
[henrikbjorn/phpspec-code-coverage][1] project.

## License

Licensed under [MIT License](LICENSE).

[0]: https://github.com/leanphp/phpspec-code-coverage
[1]: https://github.com/henrikbjorn/PhpSpecCodeCoverageExtension
[2]: http://www.phpspec.net/en/2.5.1
[3]: https://xdebug.org/
[4]: http://phpdbg.com/
