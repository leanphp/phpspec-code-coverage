# CHANGELOG

All notable changes to [leanphp/phpspec-code-coverage][0] package will be
documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/)
and this project adheres to [Semantic Versioning](http://semver.org/).

## [3.1.0] - 2017-02-15 (backported master branch on 2017-02-15)

**Note!** This is last backported release which pulls all the changes from the
`master` branch of `henrikbjorn/phpspec-code-coverage` project and releases it as
`3.1.0`.

- Add support for `php-code-coverage` v5.

## [3.0.1] - 2017-02-14 (backported v3.0.1, original release on 2016-08-02)

- Require PhpSpec3
- Require PHP 5.6+ / PHP 7.0+

## [2.1.0] - 2017-02-12 (backported v2.1.0, original release on 2016-05-05)

**Note!** v2.1.0 is final release to support PhpSpec2.

- Added PHP 7 support
- Added `phpdbg` extension support (alternative to `xdebug`)
- Updated `blacklist` to include `test` directory by default
- Updated `text` output to use coloring by default.

## [1.0.1] - 2017-02-11 (backported v1.0.1, original release on 2014-12-11)

**Note!** This version is a direct backport of `1.0.1` of
[henrikbjorn/phpspec-code-coverage][1] package with updated namespaces to work
as [leanphp/phpspec-code-coverage][0].

- PHP `>=5.3`
- PhpSpec `~2.0`
- Xdebug `>=2.1.4`
- Supports Code Coverage generation in `html`, `clover`, `php` and `txt`
  formats.
- Supports per-format `output` directory configuration (e.g.
  `clover:clover.xml`)
- Supports configuring inclusion of uncovered files in code coverage reports.
- Supports configuring lower upper and higher lower bounds for code coverage
  reports.
- Supports configuring a whiltelist of directories to be included in code
  coverage report (`whilelist` option).
- Supports configuring a whiltelist of files to be included in code coverage
  reports (`whitelist_files` option).
- Support configuring a blacklist of directories to be excluded from code
  coverage reports (`blacklist` option).
- Support configuring a blacklist of files to be excluded from code coverage
  reports (`blaclist_files` option).

[3.0.1]: https://github.com/leanphp/phpspec-code-coverage/releases/tag/v3.0.1
[2.1.0]: https://github.com/leanphp/phpspec-code-coverage/releases/tag/v2.1.0
[1.0.1]: https://github.com/leanphp/phpspec-code-coverage/releases/tag/v1.0.1

[0]: https://github.com/leanphp/phpspec-code-coverage
[1]: https://github.com/henrikbjorn/PhpSpecCodeCoverageExtension

