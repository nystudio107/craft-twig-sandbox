# Craft Twig Sandbox Changelog

All notable changes to this project will be documented in this file.

## 5.0.2 - UNRELEASED
### Changed
* Use the official `markhuot/craft-pest-core:^2.0.4` package instead of the patch version from @bencroker

## 5.0.1 - 2024.07.29
### Changed
* Removed the special-casing for the Craft Closure, since it now uses a different loading mechanism
* Simplify the `SanboxView` to use `::registerTwigExtension` rather than overriding `::createTwig()`

## 5.0.0 - 2024.07.03
### Added
* Initial release
