<?php

/**
 * Tests the Whitelist Security Policy.
 */

use nystudio107\crafttwigsandbox\twig\WhitelistSecurityPolicy;
use nystudio107\crafttwigsandbox\web\SandboxView;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
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
