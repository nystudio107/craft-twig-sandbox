# Craft Twig Sandbox Changelog

All notable changes to this project will be documented in this file.

## 5.0.5 - 2028.08.18
### Added
* Provide a mechanism for adding Twig Extensions in bulk to the `SandboxView` ([#1632](https://github.com/nystudio107/craft-seomatic/issues/1632))

## 5.0.4 - 2025.06.10
### Fixed
* Remove errant dependency on SEOmatic in the `SecurityPolicy` helper class

## 5.0.3 - 2025.06.08
### Added
* Add an example `config/blacklist-sandbox.php` and `config/whitelist-sandbox.php` files for user-customizable Twig sandbox environments
* Add `SecurityPolicy::createFromFile()` to create a new Twig sandbox from a config file in the `config/` directory

### Changed
* Cleaned up the `BlacklistSecurityPolicy` to no longer blacklist innocuous tags/filters/functions

## 5.0.2 - 2025.02.17
### Added
* Craft Twig Sandbox no longer automatically handles exceptions when rendering sandbox templates. Instead, you can decide whether to handle the exception yourself, or pass it along to the `sandboxErrorHandler` for display in the browser/console

### Changed
* Use the official `markhuot/craft-pest-core:^2.0.4` package instead of the patch version from @bencroker

## 5.0.1 - 2024.07.29
### Changed
* Removed the special-casing for the Craft Closure, since it now uses a different loading mechanism
* Simplify the `SanboxView` to use `::registerTwigExtension` rather than overriding `::createTwig()`

## 5.0.0 - 2024.07.03
### Added
* Initial release
