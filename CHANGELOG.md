# Craft Twig Sandbox Changelog

All notable changes to this project will be documented in this file.

## 4.0.3 - UNRELEASED
### Added
* Added `addTwigTags()`, `addTwigFilters()`, `addTwigFunctions()`, `addTwigMethods()`, and `addTwigProperties()` methods to allow for adding properties to the base config
* Added `removeTwigTags()`, `removeTwigFilters()`, `removeTwigFunctions()`, `removeTwigMethods()`, and `removeTwigProperties()` methods to allow for adding properties to the base config
* Add an example `config.php` file for user-customizable Twig sandbox environments
* Add `SandboxConfig::sandboxFromFile()` to create a new Twig sandbox from a config file in the `config/` directory


### Changed
* Cleaned up the `BlacklistSecurityPolicy` to no longer blacklist innocuous tags/filters/functions

## 4.0.2 - 2025.02.17
### Added
* Craft Twig Sandbox no longer automatically handles exceptions when rendering sandbox templates. Instead, you can decide whether to handle the exception yourself, or pass it along to the `sandboxErrorHandler` for display in the browser/console

### Changed
* Use the official `markhuot/craft-pest-core:^2.0.4` package instead of the patch version from @bencroker

## 4.0.1 - 2024.07.29
### Changed
* Removed the special-casing for the Craft Closure, since it now uses a different loading mechanism
* Simplify the `SanboxView` to use `::registerTwigExtension` rather than overriding `::createTwig()`

## 4.0.0 - 2024.07.03
### Added
* Initial release
