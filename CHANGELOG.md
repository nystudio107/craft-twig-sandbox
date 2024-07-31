# Craft Twig Sandbox Changelog

All notable changes to this project will be documented in this file.

## 5.0.1 - 2024.07.29
### Changed
* Removed the special-casing for the Craft Closure, since it now uses a different loading mechanism
* Simplify the `SanboxView` to use `::registerTwigExtension` rather than overriding `::createTwig()`

## 5.0.0 - 2024.07.03
### Added
* Initial release
