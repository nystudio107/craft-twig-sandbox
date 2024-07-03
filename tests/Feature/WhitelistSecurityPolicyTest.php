<?php

/**
 * Tests the Whitelist Security Policy.
 */

use craft\config\GeneralConfig;
use craft\services\Config;
use craft\web\Application;
use craft\web\twig\variables\CraftVariable;
use nystudio107\crafttwigsandbox\twig\WhitelistSecurityPolicy;
use nystudio107\crafttwigsandbox\web\SandboxView;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Sandbox\SecurityNotAllowedMethodError;
use Twig\Sandbox\SecurityNotAllowedPropertyError;
use Twig\Sandbox\SecurityNotAllowedTagError;

test('Whitelisted tag is allowed', function() {
    $sandboxView = new SandboxView([
        'securityPolicy' => new WhitelistSecurityPolicy([
            'twigTags' => ['set'],
        ]),
    ]);
    $sandboxView->renderString('{% set x = 1 %}');
})->throwsNoExceptions();

test('Non whitelisted tag is not allowed', function() {
    $sandboxView = new SandboxView([
        'securityPolicy' => new WhitelistSecurityPolicy([
            'twigTags' => [],
        ]),
    ]);
    $sandboxView->renderString('{% set x = 1 %}');
})->throws(SecurityNotAllowedTagError::class);

test('Whitelisted filter is allowed', function() {
    $sandboxView = new SandboxView([
        'securityPolicy' => new WhitelistSecurityPolicy([
            'twigFilters' => ['abs'],
        ]),
    ]);
    $sandboxView->renderString('{{ 6|abs }}');
})->throwsNoExceptions();

test('Non whitelisted filter is not allowed', function() {
    $sandboxView = new SandboxView([
        'securityPolicy' => new WhitelistSecurityPolicy([
            'twigFilters' => [],
        ]),
    ]);
    $sandboxView->renderString('{{ 6|abs }}');
})->throws(SecurityNotAllowedFilterError::class);

test('Whitelisted function is allowed', function() {
    $sandboxView = new SandboxView([
        'securityPolicy' => new WhitelistSecurityPolicy([
            'twigFunctions' => ['random'],
        ]),
    ]);
    $sandboxView->renderString('{{ random() }}');
})->throwsNoExceptions();

test('Non whitelisted function is not allowed', function() {
    $sandboxView = new SandboxView([
        'securityPolicy' => new WhitelistSecurityPolicy([
            'twigFunctions' => [],
        ]),
    ]);
    $sandboxView->renderString('{{ random() }}');
})->throws(SecurityNotAllowedFunctionError::class);

test('Whitelisted object method is allowed', function() {
    $sandboxView = new SandboxView([
        'securityPolicy' => new WhitelistSecurityPolicy([
            'twigMethods' => [
                Application::class => ['getConfig'],
                Config::class => ['getGeneral'],
                GeneralConfig::class => ['devMode'],
            ],
            'twigProperties' => [
                CraftVariable::class => ['app'],
            ]
        ]),
    ]);
    $sandboxView->renderString('{% set dev = craft.app.getConfig().getGeneral().devMode(true) %}');
})->throwsNoExceptions();

test('Non whitelisted object method is not allowed', function() {
    $sandboxView = new SandboxView([
        'securityPolicy' => new WhitelistSecurityPolicy([
            'twigMethods' => [],
            'twigProperties' => [
                CraftVariable::class => ['app'],
            ]
        ]),
    ]);
    $sandboxView->renderString('{{ craft.app.getConfig().getGeneral().getDevMode() }}');
})->throws(SecurityNotAllowedMethodError::class);

test('Whitelisted object property is allowed', function() {
    $sandboxView = new SandboxView([
        'securityPolicy' => new WhitelistSecurityPolicy([
            'twigProperties' => [
                Application::class => ['config'],
                Config::class => ['general'],
                GeneralConfig::class => ['devMode'],
                CraftVariable::class => ['app'],
            ]
        ]),
    ]);
    $sandboxView->renderString('{{ craft.app.config.general.devMode }}');
})->throwsNoExceptions();

test('Non whitelisted object property is not allowed', function() {
    $sandboxView = new SandboxView([
        'securityPolicy' => new WhitelistSecurityPolicy([
            'twigMethods' => [],
            'twigProperties' => [
                CraftVariable::class => ['app'],
            ]
        ]),
    ]);
    $sandboxView->renderString('{{ craft.app.config.general.devMode }}');
})->throws(SecurityNotAllowedPropertyError::class);
