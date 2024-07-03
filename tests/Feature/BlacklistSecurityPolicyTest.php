<?php

/**
 * Tests the Blacklist Security Policy.
 */

use craft\config\DbConfig;
use nystudio107\crafttwigsandbox\twig\BlacklistSecurityPolicy;
use nystudio107\crafttwigsandbox\web\SandboxView;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Sandbox\SecurityNotAllowedMethodError;
use Twig\Sandbox\SecurityNotAllowedPropertyError;
use Twig\Sandbox\SecurityNotAllowedTagError;

test('Blacklisted tag is not allowed', function() {
    $sandboxView = new SandboxView([
        'securityPolicy' => new BlacklistSecurityPolicy([
            'twigTags' => ['set'],
        ]),
    ]);
    $sandboxView->renderString('{% set x = 1 %}');
})->throws(SecurityNotAllowedTagError::class);

test('Non blacklisted tag is allowed', function() {
    $sandboxView = new SandboxView([
        'securityPolicy' => new BlacklistSecurityPolicy([
            'twigTags' => [],
        ]),
    ]);
    $sandboxView->renderString('{% set x = 1 %}');
})->throwsNoExceptions();

test('Blacklisted filter is not allowed', function() {
    $sandboxView = new SandboxView([
        'securityPolicy' => new BlacklistSecurityPolicy([
            'twigFilters' => ['abs'],
        ]),
    ]);
    $sandboxView->renderString('{{ 6|abs }}');
})->throws(SecurityNotAllowedFilterError::class);

test('Non blacklisted filter is allowed', function() {
    $sandboxView = new SandboxView([
        'securityPolicy' => new BlacklistSecurityPolicy([
            'twigFilters' => [],
        ]),
    ]);
    $sandboxView->renderString('{{ 6|abs }}');
})->throwsNoExceptions();

test('Blacklisted function is not allowed', function() {
    $sandboxView = new SandboxView([
        'securityPolicy' => new BlacklistSecurityPolicy([
            'twigFunctions' => ['random'],
        ]),
    ]);
    $sandboxView->renderString('{{ random() }}');
})->throws(SecurityNotAllowedFunctionError::class);

test('Non blacklisted function is allowed', function() {
    $sandboxView = new SandboxView([
        'securityPolicy' => new BlacklistSecurityPolicy([
            'twigFunctions' => [],
        ]),
    ]);
    $sandboxView->renderString('{{ random() }}');
})->throwsNoExceptions();

test('Blacklisted object method is not allowed', function() {
    $sandboxView = new SandboxView([
        'securityPolicy' => new BlacklistSecurityPolicy([
            'twigMethods' => [
                DbConfig::class => ['password'],
            ],
        ]),
    ]);
    $sandboxView->renderString('{% set password = craft.app.getConfig().getDb().password("") %}');
})->throws(SecurityNotAllowedMethodError::class);

test('Non blacklisted object method is allowed', function() {
    $sandboxView = new SandboxView([
        'securityPolicy' => new BlacklistSecurityPolicy([
            'twigMethods' => [],
        ]),
    ]);
    $sandboxView->renderString('{% set password = craft.app.getConfig().getDb().password("") %}');
})->throwsNoExceptions();

test('Blacklisted object property is not allowed', function() {
    $sandboxView = new SandboxView([
        'securityPolicy' => new BlacklistSecurityPolicy([
            'twigProperties' => [
                DbConfig::class => ['password'],
            ],
        ]),
    ]);
    $sandboxView->renderString('{{ craft.app.config.db.password }}');
})->throws(SecurityNotAllowedPropertyError::class);

test('Non blacklisted object property is allowed', function() {
    $sandboxView = new SandboxView([
        'securityPolicy' => new BlacklistSecurityPolicy([
            'twigProperties' => [],
        ]),
    ]);
    $sandboxView->renderString('{{ craft.app.config.db.password }}');
})->throwsNoExceptions();
