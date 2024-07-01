[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/nystudio107/craft-twig-sandbox/badges/quality-score.png?b=v5)](https://scrutinizer-ci.com/g/nystudio107/craft-twig-sandbox/?branch=develop) [![Code Coverage](https://scrutinizer-ci.com/g/nystudio107/craft-twig-sandbox/badges/coverage.png?b=v5)](https://scrutinizer-ci.com/g/nystudio107/craft-twig-sandbox/?branch=develop) [![Build Status](https://scrutinizer-ci.com/g/nystudio107/craft-twig-sandbox/badges/build.png?b=v5)](https://scrutinizer-ci.com/g/nystudio107/craft-twig-sandbox/build-status/develop) [![Code Intelligence Status](https://scrutinizer-ci.com/g/nystudio107/craft-twig-sandbox/badges/code-intelligence.svg?b=v5)](https://scrutinizer-ci.com/code-intelligence)

# Craft Twig Sandbox

Allows you to easily create a sandboxed Twig environment where you can control what tags, filters, and functions are allowed

## Requirements

Craft Twig Sandbox requires Craft CMS 5.x

## Installation

To install Craft Twig Sandbox, follow these steps:

1. Open your terminal and go to your Craft project:

        cd /path/to/project

2. Then tell Composer to require the package:

        composer require nystudio107/craft-twig-sandbox

## About Craft Twig Sandbox

Blah blah

## Using Craft Twig Sandbox

In its simplest form, you can create a Twig Sandbox like so:

```php
use nystudio107\crafttwigsandbox\web\SandboxView;

$sandboxView = new SandboxView();
```

This will create a new `SandboxView` that works just like the Craft web `View` class so you can use any of the `View` render methods for Twig templates:
```php
$result = $sandboxView->renderString();
$result = $sandboxView->renderObjectTemplate();
$result = $sandboxView->renderPageTemplate();
$result = $sandboxView->renderTemplate();
```

...and they will be rendered using the default `WhitelistSecurityPolicy` so only whitelisted Twig tags, filters, and functions will be allowed.

If any tags, filters, or functions are used that are not allowed by the security policy, a `SecurityError` exception will be thrown.

### `WhitelistSecurityPolicy`

The `WhitelistSecurityPolicy` is a `SecurityPolicy` that specifies the Twig tags, filters, and functions that **are** allowed.

It defaults to [reasonable subset of whitelisted](https://github.com/nystudio107/craft-twig-sandbox/blob/develop-v5/src/twig/WhitelistSecurityPolicy.php#L19) Twig tags, filters, and functions, but you can customize it as you see fit:

```php
use nystudio107\crafttwigsandbox\twig\WhitelistSecurityPolicy;
use nystudio107\crafttwigsandbox\web\SandboxView;

$securityPolicy = new WhitelistSecurityPolicy([
   'twigTags' => ['for', 'if'],
   'twigFilters' => ['replace', 'sort'],
   'twigFunctions' => ['date', 'random'],
]);
$sandboxView = new SandboxView(['securityPolicy' => $securityPolicy]);
$result = $sandboxView->renderString("{{ dump() }}", []);
```

### `BlacklistSecurityPolicy`

The `BlacklistSecurityPolicy` is a `SecurityPolicy` that specifies the Twig tags, filters, and functions that **are not** allowed.

It defaults to [reasonable subset of blacklisted](https://github.com/nystudio107/craft-twig-sandbox/blob/develop-v5/src/twig/BlacklistSecurityPolicy.php#L19) Twig tags, filters, and functions, but you can customize it as you see fit:

```php
use nystudio107\crafttwigsandbox\twig\WhitelistSecurityPolicy;
use nystudio107\crafttwigsandbox\web\SandboxView;

$securityPolicy = new BlacklistSecurityPolicy([
   'twigTags' => ['import'],
   'twigFilters' => ['base64_decode', 'base64_encode'],
   'twigFunctions' => ['dump'],
]);
$sandboxView = new SandboxView(['securityPolicy' => $securityPolicy]);
$result = $sandboxView->renderString("{{ dump() }}", []);
```

### Custom SecurityPolicy

You can also create your own custom `SecurityPolicy` to use, it just needs to conform to the Twig `SecurityPolicyInterface`:

```php
use my\custom\SecurityPolicy;
use nystudio107\crafttwigsandbox\web\SandboxView;

$securityPolicy = new SecurityPolicy([
   'twigTags' => ['import'],
   'twigFilters' => ['base64_decode', 'base64_encode'],
   'twigFunctions' => ['dump'],
]);
$sandboxView = new SandboxView(['securityPolicy' => $securityPolicy]);
$result = $sandboxView->renderString("{{ dump() }}", []);
```

...
## Craft Twig Sandbox Roadmap

Some things to do, and ideas for potential features:

* Initial release

Brought to you by [nystudio107](https://nystudio107.com/)
