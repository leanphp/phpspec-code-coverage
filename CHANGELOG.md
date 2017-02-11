# CHANGELOG

All notable changes to [leanphp/phpspec-code-coverage][0] package will be
documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/)
and this project adheres to [Semantic Versioning](http://semver.org/).

## [1.0.1] - 2017-02-11 (backported v1.0.1, original release on 2014-12-11)

**Note!** This version is a direct backport of `1.0.1` of
[henrikbjorn/phpspec-code-coverage][1] package with updated namespaces to work
as [leanphp/phpspec-code-coverage][0].

This is last release to support PHP `5.3`

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

[1.0.1]: https://github.com/leanphp/phpspec-code-coverage/releases/tag/1.0.1

[0]: https://github.com/leanphp/phpspec-code-coverage
[1]: https://github.com/henrikbjorn/PhpSpecCodeCoverageExtension

